<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PopupHelper;
use App\Models\OrderItem;

class HotelController extends Controller
{
    public function showHotels()
    {
        // Carregar hotéis com quartos e imagens
        $hotels = Hotel::with(['rooms' => function ($query) {
            $query->orderBy('price_night', 'asc')
                ->limit(1);
        }, 'item.images']) // Incluindo imagens associadas ao item
            ->paginate(5);

        // Obter todas as cidades distintas da tabela de hotéis
        $cities = Hotel::distinct()->pluck('city');

        // Passar as coordenadas dos hotéis para a view
        $hotelCoordinates = Hotel::all()->map(function ($hotel) {
            return [
                'id' => $hotel->id_item,
                'name' => $hotel->name,
                'latitude' => $hotel->lat,
                'longitude' => $hotel->lon,
                'url' => route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item])
            ];
        });

        return view('hotels.hotels', compact('hotels', 'hotelCoordinates', 'cities'));
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
