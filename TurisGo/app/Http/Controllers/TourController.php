<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PopupHelper;
use App\Models\OrderItem;

class TourController extends Controller
{
    public function showTours(Request $request)
    {
<<<<<<< HEAD
        $query = Activity::with('item.images'); // Inclui as imagens associadas
        
        // Ordenação
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'price_asc':
                    // Ordenar por preço de forma crescente (Low to High)
                    $query->orderBy('activities.price_hour', 'asc'); // Usando price_hour da tabela activities
                    break;
                case 'price_desc':
                    // Ordenar por preço de forma decrescente (High to Low)
                    $query->orderBy('activities.price_hour', 'desc'); // Usando price_hour da tabela activities
                    break;
        
                case 'alphabetical':
                    // Ordenar alfabeticamente
                    $query->orderBy('activities.name', 'asc');
                    break;
                case 'most_booked':
                    // Ordenar por mais reservado (contando as reservas)
                    $query->leftJoin('order_items', 'order_items.item_id', '=', 'activities.id_item') // Relaciona a tabela order_items com activities
                          ->selectRaw('activities.*, COUNT(order_items.id) as total_bookings') // Conta as reservas
                          ->groupBy('activities.id_item') // Agrupa por tour (atividade)
                          ->orderBy('total_bookings', 'desc'); // Ordena decrescentemente pelas reservas
                    break;
                default:
                    $query->orderBy('activities.name', 'asc');
            }
        }
        
        // Paginação com todos os itens ordenados
        $tours = $query->paginate(5);
    
        return view('tours.tours', compact('tours'));
    }
    
    
    
=======
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


>>>>>>> 8f3b3217c93740ae22ef80939a6856019b96e5df
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

    public function tourDetail_reservation(Request $request)
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
        $tour = OrderItem::where('item_id', $id)
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        if (!$tour) {
            $popupError = PopupHelper::showPopup(
                'Error!',
                'Tour not found in the reservations',
                'Error',
                'OK',
                false,
                '',
                5000
            );

            return redirect()->route('profile.show', ['locale' => $locale])->with('popup', $popupError);
        }
        $tour = Activity::where('id_item', $id)->firstOrFail();

        $tour->load([
            'item.images', // Relacionamento para carregar imagens do Item
        ]);
        
        $tourReservation = OrderItem::where('item_id', $id) // Filtra pelo item_id
            ->whereHas('order', function ($query) {
                $query->where('user_id', Auth::id()); // Filtra pelo user_id do usuário autenticado
            })
            ->with([
                'order',
            ])
            ->first();

        $tourReservation->details = $tour;

        return view('tourDetail.tourDetail', compact('tourReservation', 'locale'));
    }
}


