<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PopupHelper;
use App\Models\OrderItem;
use App\Models\Room;
use Illuminate\Support\Facades\DB;


class HotelController extends Controller
{
    public function showHotels(Request $request)
    {
        // Recupera os parâmetros enviados pelo POST
        $location = $request->input('location', 'All');
        $checkin = $request->input('checkin');
        $checkout = $request->input('checkout');
        $people = $request->input('people', 1); // Valor padrão para 'people' é 1

        // Inicia a query para buscar os hotéis
        $query = Hotel::query()
            ->with(['item.images', 'rooms'])
            ->select('hotels.*')
            ->selectRaw('COALESCE((
                SELECT MIN(price_night)
                FROM rooms
                WHERE rooms.hotel_id = hotels.id_item
                ), 0) as min_price');

        // Ordenação
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'price_asc':
                    // Ordenar por preço de forma crescente (Low to High), usando o menor preço de room associado ao hotel
                    $query->leftJoin('rooms', 'rooms.hotel_id', '=', 'hotels.id_item')
                        ->groupBy('hotels.id_item') // Garante que a ordenação será por hotel
                        ->orderByRaw('MIN(rooms.price_night) ASC');
                    break;
                case 'price_desc':
                    // Ordenar por preço de forma decrescente (High to Low)
                    $query->leftJoin('rooms', 'rooms.hotel_id', '=', 'hotels.id_item')
                        ->groupBy('hotels.id_item')
                        ->orderByRaw('MIN(rooms.price_night) DESC');
                    break;
                case 'alphabetical':
                    // Ordenar alfabeticamente
                    $query->orderBy('hotels.name', 'asc');
                    break;
                case 'most_booked':
                    // Ordenar por mais reservado (contando as reservas)
                    $query->leftJoin('order_items', 'order_items.item_id', '=', 'hotels.id_item')
                        ->selectRaw('hotels.*, COUNT(order_items.id) as total_bookings')
                        ->groupBy('hotels.id_item')
                        ->orderBy('total_bookings', 'desc');
                    break;
                default:
                    $query->orderBy('hotels.name', 'asc');
            }
        }

        // Aplica o filtro de localização, se fornecido e não for "All"
        if ($location && $location !== 'All') {
            $query->where('city', $location);
        }

        // Filtro de Faixa de Preço - Usando os preços dos quartos da tabela 'rooms'
        if ($request->has('price_range') && !empty($request->price_range)) {
            $priceRange = explode('-', $request->price_range);
            if (count($priceRange) === 2 && is_numeric($priceRange[0]) && is_numeric($priceRange[1])) {
                // Filtra pelo menor preço da room associada ao hotel
                $query->whereHas('rooms', function ($query) use ($priceRange) {
                    $query->selectRaw('MIN(price_night) as min_price')
                        ->whereBetween('price_night', [$priceRange[0], $priceRange[1]])
                        ->groupBy('rooms.hotel_id');
                });
            }
        }

        // Filtros adicionais
        if ($request->has('stars') && is_numeric($request->stars)) {
            $query->where('stars', $request->stars);
        }

        if ($request->has('guest_ratings') && !empty($request->guest_ratings)) {
            $ratingsRange = explode('-', $request->guest_ratings);
            if (count($ratingsRange) === 2 && is_numeric($ratingsRange[0]) && is_numeric($ratingsRange[1])) {
                $query->whereBetween('average_guest_rating', [$ratingsRange[0], $ratingsRange[1]]);
            }
        }

        // Filtro de Comodidades
        $amenities = [
            'breakfast' => 'breakfast_included',
            'free_wifi' => 'free_wifi',
            'parking' => 'parking',
            'gym' => 'gym',
            'pool' => 'pool',
            'spa' => 'spa_and_wellness',
            'restaurant' => 'hotel_restaurant',
            'bar' => 'bar',
            'non_smoking_rooms' => 'non_smoking_rooms',
        ];

        foreach ($amenities as $input => $column) {
            if ($request->has($input)) {
                $value = (bool) $request->$input;  // Converte para booleano
                $query->where($column, $value);
            }
        }

        // Filtro de Política de Cancelamento
        if ($request->has('free_cancellation') && $request->free_cancellation) {
            $query->where('free_cancellation', true);
        }
        if ($request->has('refundable_reservations') && $request->refundable_reservations) {
            $query->where('refundable_reservations', true);
        }

        // Paginação
        $hotels = $query->paginate(5)
            ->appends($request->query()); // Preserva os parâmetros da URL na paginação

        // Obter todas as cidades distintas
        $cities = Hotel::distinct()->pluck('city');

        // Passar as coordenadas dos hotéis para a view
        $hotelCoordinates = Hotel::all()->map(function ($hotel) {
            return [
                'id' => $hotel->id_item,
                'name' => $hotel->name,
                'latitude' => $hotel->lat,
                'longitude' => $hotel->lon,
                'url' => route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item]),
            ];
        });

        // Verifica se a requisição é via AJAX
        if ($request->ajax()) {
            // Retorna apenas os hotéis paginados em formato JSON
            return response()->json([
                'html' => view('hotels._hotel_list', compact('hotels'))->render(),
                'next_page' => $hotels->nextPageUrl(),
            ]);
        }

        // Caso contrário, retorna a view completa
        return view('hotels.hotels', compact('hotels', 'cities', 'hotelCoordinates', 'location', 'checkin', 'checkout', 'people'));
    }


    public function showHotelDetails(Request $request)
    {
        $id = $request->route('id');

        // Busca o hotel pelo ID
        $hotel = Hotel::where('id_item', $id)->firstOrFail();

        // Carrega hotéis semelhantes na mesma cidade
        $similarHotels = Hotel::where('city', $hotel->city)
            ->where('id_item', '!=', $hotel->id_item)
            ->limit(4) // Limita o número de hotéis semelhantes
            ->with('item.images')
            ->get();

        // Carrega os quartos do hotel (relacionamento separado)
        $hotel->load([
            'rooms' => function ($query) {
                $query->orderBy('price_night', 'asc'); // Ordena os quartos pelo preço
            },
            // Carregar as imagens associadas ao hotel
            'item.images', // Relacionamento para carregar imagens do Item
            // Carrega as avaliações do hotel (relacionamento separado)
            'reviews' => function ($query) {
                $query->latest(); // Ordena as avaliações da mais recente para a mais antiga
            }
        ]);

        return view('hotel.hotel', compact('hotel', 'similarHotels'));
    }

    public function hotelDetail_reservation(Request $request)
    {

        $locale = $request->route('locale');
        $popupError = PopupHelper::showPopup(
            'Authentication!',
            'You must be logged in to add items to the cart',
            'Error',
            'OK',
            false,
            '',
            5000
        );

        // Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('auth.login.form', ['locale' => $locale])
                ->with('popup', $popupError);
        }
        $id = $request->input('id');

        // Verifica se o hotel está no carrinho do usuário autenticado
        $hotel = OrderItem::where('item_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();



        if (!$hotel) {
            $popupError = PopupHelper::showPopup(
                'Error!',
                'Hotel not found in the reservations',
                'Error',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('profile.show', ['locale' => $locale])->with('popup', $popupError);
        }
        $hotelde = Hotel::where('id_item', $id)->firstOrFail();

        $hotelde->load([
            'rooms' => function ($query) use ($hotel) {
                $query->where('type', $hotel->room_type_hotel) // Filtra pelos quartos pelo tipo armazenado no `room_type_hotel`
                    ->orderBy('price_night', 'asc'); // Ordena os quartos pelo preço
            },
            'item.images', // Relacionamento para carregar imagens do Item
        ]);
        // Consulta mais simples, utilizando Eloquent para carregar os dados necessários
        $hotelReservation = OrderItem::where('item_id', $id) // Filtra pelo item_id
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id()); // Filtra pelo user_id do usuário autenticado
            })
            ->with([
                'order',
            ])
            ->first();


        $hotelReservation->details = $hotelde;

        return view('hotelDetail.hotelDetail', compact('hotelReservation', 'locale'));
    }
}
