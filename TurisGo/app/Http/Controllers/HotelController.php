<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


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

        // Passar as coordenadas dos hotéis para a view
        $hotelCoordinates = Hotel::all()->map(function($hotel) {
            return [
                'id' => $hotel->id_item,
                'name' => $hotel->name,
                'latitude' => $hotel->lat,
                'longitude' => $hotel->lon,
                'url' => route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item])
            ];
        });

        return view('hotels.hotels', compact('hotels', 'hotelCoordinates'));
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
    
}
