<?php

namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Http\Request;

class TourController extends Controller
{
    public function showTours()
    {
        $tours = Activity::paginate(5);

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

        $tours = $query->get();

        return view('tour.tour', compact('tours'));
    }

    public function showTourDetails(Request $request)
    {
        $id = $request->route('id');

        // Busca o hotel pelo ID
        $tour = Activity::where('id_item', $id)->firstOrFail();

        $similarTours = Activity::where('city', $tour->city)
            ->where('id_item', '!=', $tour->id_item)
            ->limit(4)
            ->get();


        $tour->load([
            'reviews' => function ($query) {
                $query->latest();
            }
        ]);

        return view('tour.tour', compact('tour', 'similarTours'));
    }
}
