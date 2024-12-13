<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function showHotels()
    {
        // Carrega os hotéis com os quartos disponíveis, ordenando os quartos por preço
        $hotels = Hotel::with(['rooms' => function ($query) {
            $query->where('available', true) // Apenas quartos disponíveis
                  ->orderBy('price_night', 'asc') // Ordena pelo preço do mais barato
                  ->limit(1); // Pega o quarto mais barato por hotel
        }])->paginate(5); // Paginando os hotéis, 5 por página
    
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
}
