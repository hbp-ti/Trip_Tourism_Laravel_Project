<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Tour;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    // Adicionar um hotel
    public function addHotel(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'stars' => 'required|integer|min:0|max:5',
            'average_guest_rating' => 'nullable|numeric|min:0|max:5',
            'free_wifi' => 'required|boolean',
            'parking' => 'required|boolean',
            'gym' => 'required|boolean',
            'pool' => 'required|boolean',
            'non_smoking_rooms' => 'required|boolean',
            'hotel_restaurant' => 'required|boolean',
            'bar' => 'required|boolean',
            'refundable_reservations' => 'required|boolean',
            'country' => 'required|string|max:30',
            'zip_code' => 'required|string|max:20',
            'city' => 'required|string|max:30',
            'street' => 'required|string|max:60',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Criar o item pai
        $item = Item::create([
            'item_type' => 'Hotel',
        ]);

        // Criar o hotel
        $hotel = new Hotel($validated);
        $hotel->id_item = $item->id;
        $hotel->save();

        // Adicionar imagens
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images');
                Image::create([
                    'url' => $path,
                    'item_id' => $item->id,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Hotel adicionado com sucesso!');
    }

    // Adicionar uma atividade
    public function addActivity(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'price_hour' => 'required|numeric',
            'cancel_anytime' => 'required|boolean',
            'reserve_now_pay_later' => 'required|boolean',
            'guide' => 'required|boolean',
            'small_groups' => 'required|boolean',
            'language' => 'required|string|max:20',
            'country' => 'required|string|max:30',
            'zip_code' => 'required|string|max:10',
            'city' => 'required|string|max:30',
            'street' => 'required|string|max:60',
            'lat' => 'nullable|numeric',
            'lon' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Criar o item pai
        $item = Item::create([
            'item_type' => 'Activity',
        ]);

        // Criar a atividade
        $activity = new Activity($validated);
        $activity->id_item = $item->id;
        $activity->save();

        // Adicionar imagens
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images');
                Image::create([
                    'url' => $path,
                    'item_id' => $item->id,
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Atividade adicionada com sucesso!');
    }

    // Remover um item
    public function removeItem($id)
    {
        $item = Item::findOrFail($id);

        // Remover imagens associadas
        Image::where('item_id', $item->id)->delete();

        // Remover hotel ou atividade associado
        if ($item->item_type === 'Hotel') {
            Hotel::where('id_item', $item->id)->delete();
        } elseif ($item->item_type === 'Activity') {
            Activity::where('id_item', $item->id)->delete();
        }

        // Remover o item pai
        $item->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Item removido com sucesso!');
    }

    // Alterar um hotel ou atividade
    public function updateItem(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if ($item->item_type === 'Hotel') {
            $hotel = Hotel::where('id_item', $item->id)->firstOrFail();
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string|max:1000',
                'stars' => 'required|integer|min:0|max:5',
                'average_guest_rating' => 'nullable|numeric|min:0|max:5',
                'free_wifi' => 'required|boolean',
                'parking' => 'required|boolean',
                'gym' => 'required|boolean',
                'pool' => 'required|boolean',
                'non_smoking_rooms' => 'required|boolean',
                'hotel_restaurant' => 'required|boolean',
                'bar' => 'required|boolean',
                'refundable_reservations' => 'required|boolean',
                'country' => 'required|string|max:30',
                'zip_code' => 'required|string|max:20',
                'city' => 'required|string|max:30',
                'street' => 'required|string|max:60',
                'lat' => 'nullable|numeric',
                'lon' => 'nullable|numeric',
            ]);
            $hotel->update($validated);
        } elseif ($item->item_type === 'Activity') {
            $activity = Activity::where('id_item', $item->id)->firstOrFail();
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string|max:1000',
                'price_hour' => 'required|numeric',
                'cancel_anytime' => 'required|boolean',
                'reserve_now_pay_later' => 'required|boolean',
                'guide' => 'required|boolean',
                'small_groups' => 'required|boolean',
                'language' => 'required|string|max:20',
                'country' => 'required|string|max:30',
                'zip_code' => 'required|string|max:10',
                'city' => 'required|string|max:30',
                'street' => 'required|string|max:60',
                'lat' => 'nullable|numeric',
                'lon' => 'nullable|numeric',
            ]);
            $activity->update($validated);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Item atualizado com sucesso!');
    }
}