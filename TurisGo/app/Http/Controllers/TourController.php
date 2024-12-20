<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function showTours()
    {
        $tours = Activity::with('item.images') // Inclui as imagens associadas ao item da atividade
            ->paginate(5);
    
        return view('tours.tours', compact('tours'));
    }
    

    public function filterTours(Request $request)
    {
        $query = Activity::query();
    
        if ($request->has('price_range')) {
            $priceRange = explode('-', $request->price_range);
            $query->whereBetween('price', $priceRange);
        }
    
        if ($request->has('stars')) {
            $query->where('stars', $request->stars);
        }
    
        // Adicione outros filtros aqui
    
        // Carregar as atividades com imagens associadas
        $tours = $query->with('item.images') // Incluindo as imagens
                       ->get();
    
        return view('tour.tour', compact('tours'));
    }
    

    public function showTourDetails(Request $request)
    {
        $id = $request->route('id');
    
        // Busca a atividade pelo ID
        $tour = Activity::where('id_item', $id)->firstOrFail();
    
        // Hotéis semelhantes na mesma cidade
        $similarTours = Activity::where('city', $tour->city)
            ->where('id_item', '!=', $tour->id_item)
            ->limit(4)
            ->get();
    
        // Carregar as imagens, avaliações e outros dados relacionados
        $tour->load([
            'item.images', // Carregar as imagens associadas ao Item
            'reviews' => function ($query) {
                $query->latest(); // Ordena as avaliações pela mais recente
            }
        ]);
    
        return view('tour.tour', compact('tour', 'similarTours'));
    }
    
}
