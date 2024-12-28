<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomepageController extends Controller
{
    public function showIndex()
    {
        // Obter coordenadas dos hotéis com imagens
        $hotelCoordinates = Hotel::with('item.images')
            ->get()
            ->map(function ($hotel) {
                return [
                    'id' => $hotel->id_item,
                    'name' => $hotel->name,
                    'latitude' => $hotel->lat,
                    'longitude' => $hotel->lon,
                    'url' => route('hotel.hotel', ['locale' => app()->getLocale(), 'id' => $hotel->id_item]),
                    'images' => $hotel->item->images->pluck('url')->toArray(),
                ];
            });

        // Obter as cidades únicas
        $cities = Hotel::distinct()->pluck('city');

        // Obter coordenadas dos tours/atividades
        $tourCoordinates = Activity::with('item.images')  // Carregar as imagens através do item
            ->get()
            ->map(function ($tour) {
                return [
                    'id' => $tour->id_item,
                    'name' => $tour->name,
                    'latitude' => $tour->lat,
                    'longitude' => $tour->lon,
                    'url' => route('tour.tour', ['locale' => app()->getLocale(), 'id' => $tour->id_item]),
                    'images' => $tour->item->images->pluck('url')->toArray(),
                ];
            });

        // Obter os hotéis mais populares com contagem de reservas
        $popularHotels = Hotel::with('item.images')
            ->join('order_items', 'hotels.id_item', '=', 'order_items.item_id')
            ->select('hotels.*', DB::raw('COUNT(order_items.id) as reservation_count'))
            ->groupBy('hotels.id_item', 'hotels.name', 'hotels.description', 'hotels.stars', 'hotels.average_guest_rating', 'hotels.free_wifi', 'hotels.parking', 'hotels.gym', 'hotels.pool', 'hotels.non_smoking_rooms', 'hotels.hotel_restaurant', 'hotels.bar', 'hotels.refundable_reservations', 'hotels.country', 'hotels.zip_code', 'hotels.city', 'hotels.street', 'hotels.lat', 'hotels.lon', 'hotels.created_at', 'hotels.updated_at')
            ->orderByDesc('reservation_count')
            ->limit(4)
            ->get();

        // Obter as tours mais populares com contagem de reservas
        $popularTours = Activity::with('item.images')
            ->join('order_items', 'activities.id_item', '=', 'order_items.item_id')
            ->select('activities.*', DB::raw('COUNT(order_items.id) as reservation_count'))
            ->groupBy('activities.id_item', 'activities.name', 'activities.description', 'activities.price_hour', 'activities.cancel_anytime', 'activities.reserve_now_pay_later', 'activities.guide', 'activities.small_groups', 'activities.language', 'activities.country', 'activities.zip_code', 'activities.city', 'activities.street', 'activities.lat', 'activities.lon', 'activities.created_at', 'activities.updated_at')
            ->orderByDesc('reservation_count')
            ->limit(4)
            ->get();


        // Retornar a visão com as informações necessárias
        return view('homepage', [
            'locale' => 'en',
            'hotelCoordinates' => $hotelCoordinates,
            'tourCoordinates' => $tourCoordinates,
            'cities' => $cities,
            'popularHotels' => $popularHotels,
            'popularTours' => $popularTours,
        ]);
    }

}