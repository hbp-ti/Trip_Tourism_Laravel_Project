<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PopupHelper;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;


class HotelController extends Controller
{
    public function showHotels(Request $request)
    {
        // Recupera os parâmetros da requisição
        $location = $request->get('location');
        $sortBy = $request->get('sort_by', 'price_asc');

        // Definindo as opções de ordenação
        $sortOptions = [
            'price_asc' => ['min_price', 'asc'],
            'price_desc' => ['min_price', 'desc'],
            'alphabetical' => ['hotels.name', 'asc'],
        ];

        // Determina a ordenação com base no parâmetro
        $sort = $sortOptions[$sortBy] ?? $sortOptions['price_asc'];

        // Inicia a query para buscar os hotéis
        $query = Hotel::query()
            ->with(['item.images', 'rooms']) // Carrega imagens e quartos associados
            ->select('hotels.*')
            ->selectRaw('COALESCE((SELECT MIN(price_night) FROM rooms WHERE rooms.hotel_id = hotels.id_item), 0) as min_price');

        // Aplica o filtro de localização, se fornecido
        if ($location) {
            $query->where('city', $location);
        }

        // Ordena conforme a opção de ordenação selecionada
        $hotels = $query->orderBy($sort[0], $sort[1])
            ->paginate(5); // Paginação

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

        return view('hotels.hotels', compact('hotels', 'cities', 'hotelCoordinates'));
    }

    

    public function filterHotels(Request $request)
    {
        $query = Hotel::query();

        if ($request->has('price_range')) {
            $priceRange = explode('-', $request->price_range);
            $query->whereBetween('price', $priceRange);
        }

        if ($request->has('stars')) {
            $query->where('stars', $request->stars);
        }

        if ($request->has('location') && $request->location != '') {
            $query->where('city', $request->location);
        }

        // Adicione outros filtros aqui

        // Carregar hotéis com imagens associadas ao item
        $hotels = $query->with(['item.images']) // Incluindo as imagens do item
            ->get();

        return view('hotels.hotels', compact('hotels'));
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
