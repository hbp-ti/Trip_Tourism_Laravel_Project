<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Activity;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function showOnMap() {

        $hotelCoordinates = Hotel::all()->map(function($hotel) {
            return [
                'id' => $hotel->id_item,
                'name' => $hotel->name,
                'latitude' => $hotel->lat,
                'longitude' => $hotel->lon,
                'url' => route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item])
            ];
        });

        $tourCoordinates = Activity::all()->map(function($tour) {
            return [
                'id' => $tour->id_item,
                'name' => $tour->name,
                'latitude' => $tour->lat,
                'longitude' => $tour->lon,
                'url' => route('tour.tour', ['locale' => app()->getLocale(), 'id' => $tour->id_item])
            ];
        });

        return view('homepage', ['locale'=>'en', 'hotelCoordinates' => $hotelCoordinates, 'tourCoordinates' => $tourCoordinates]);
    }
}
