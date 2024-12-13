<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class HotelController extends Controller
{
    public function showHotels()
    {
        $hotels = Hotel::with(['rooms' => function ($query) {
            $query->orderBy('price_night', 'asc')
                ->limit(1);
        }])->paginate(5);

        return view('hotel.hotel', compact('hotels'));
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

        // Adicione outros filtros aqui

        $hotels = $query->get();

        return view('hotels.index', compact('hotels'));
    }

    public function showHotelDetails(Request $request)
    {
        $id = $request->route('id');

        // Busca o hotel pelo ID
        $hotel = Hotel::where('id_item', $id)->firstOrFail();

        $similarHotels = Hotel::where('city', $hotel->city)
            ->where('id_item', '!=', $hotel->id_item)
            ->limit(4) // Limita o número de hotéis semelhantes
            ->get();

        // Carrega os quartos do hotel (relacionamento separado)
        $hotel->load([
            'rooms' => function ($query) {
                $query->orderBy('price_night', 'asc'); // Ordena os quartos pelo preço
            }
        ]);

        // Carrega as avaliações do hotel (relacionamento separado)
        $hotel->load([
            'reviews' => function ($query) {
                $query->latest(); // Ordena as avaliações da mais recente para a mais antiga
            }
        ]);

        return view('hoteldetails.hotel', compact('hotel', 'similarHotels'));
    }
}
