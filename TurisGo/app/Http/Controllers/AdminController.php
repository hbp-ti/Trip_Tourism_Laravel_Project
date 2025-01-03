<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Item;
use App\Models\Activity;
use App\Models\User;
use App\Models\Room;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Uploader;
use Cloudinary\Api\Upload\UploadApi;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Obter os hotéis com as informações necessárias
        $hotels = Hotel::query()
            ->with(['item.images'])
            ->select('hotels.*')
            ->paginate(5);

        // Obter os tours com as informações necessárias
        $tours = Activity::query()
            ->with(['item.images'])
            ->select('activities.*')
            ->paginate(5);

        // Obter a lista de admins
        $admins = User::where('is_admin', true)->paginate(5);

        // Obter a lista de utilizadores não admins
        $users = User::where('is_admin', false)->paginate(5);

        $locale = $request->route('locale');
        return view('admin.dashboard', compact('hotels', 'tours', 'admins', 'users', 'locale'));
    }

    public function promoteToAdmin(Request $request)
    {
        $userId = $request->route('id');
        // Encontrar o utilizador pelo ID
        $user = User::findOrFail($userId);

        // Promover o utilizador para administrador
        $user->is_admin = true;
        $user->save();

        // Redirecionar de volta com sucesso
        return redirect()->route('auth.admin.dashboard', ['locale' => app()->getLocale()])->with('success', 'Utilizador promovido a administrador com sucesso!');
    }

    public function addHotel(Request $request)
    {


        $request->merge(input: [
            'free_wifi' => filter_var($request->input('free_wifi'), FILTER_VALIDATE_BOOLEAN),
            'parking' => filter_var($request->input('parking'), FILTER_VALIDATE_BOOLEAN),
            'gym' => filter_var($request->input('gym'), FILTER_VALIDATE_BOOLEAN),
            'pool' => filter_var($request->input('pool'), FILTER_VALIDATE_BOOLEAN),
            'non_smoking_rooms' => filter_var($request->input('non_smoking_rooms'), FILTER_VALIDATE_BOOLEAN),
            'hotel_restaurant' => filter_var($request->input('hotel_restaurant'), FILTER_VALIDATE_BOOLEAN),
            'bar' => filter_var($request->input('bar'), FILTER_VALIDATE_BOOLEAN),
            'refundable_reservations' => filter_var($request->input('refundable_reservations'), FILTER_VALIDATE_BOOLEAN),
            // Para os quartos, também aplicamos a conversão nos campos `available` de cada quarto
            'rooms' => collect($request->input('rooms'))->map(function ($room) {
                $room['available'] = filter_var($room['available'], FILTER_VALIDATE_BOOLEAN);
                return $room;
            })->toArray(),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string|max:1000',
            'stars' => 'required|integer|min:0|max:5',
            'average_guest_rating' => 'required|integer|min:0|max:5',
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
            'hotel_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            // Validação dos quartos
            'rooms' => 'required|array',
            'rooms.*.type' => 'required|string|max:255',
            'rooms.*.bed_type' => 'required|string|max:255',
            'rooms.*.bed_count' => 'required|integer|min:1',
            'rooms.*.price_night' => 'required|numeric|min:0',
            'rooms.*.available' => 'required|boolean',
        ]);

        // Criar o item pai
        $item = Item::create([
            'item_type' => 'Hotel',
        ]);

        // Criar o hotel
        $hotel = Hotel::create([
            'id_item' => $item->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'stars' => $validated['stars'],
            'average_guest_rating' => $validated['average_guest_rating'],
            'free_wifi' => $validated['free_wifi'],
            'parking' => $validated['parking'],
            'gym' => $validated['gym'],
            'pool' => $validated['pool'],
            'non_smoking_rooms' => $validated['non_smoking_rooms'],
            'hotel_restaurant' => $validated['hotel_restaurant'],
            'bar' => $validated['bar'],
            'refundable_reservations' => $validated['refundable_reservations'],
            'country' => $validated['country'],
            'zip_code' => $validated['zip_code'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'lat' => $validated['lat'],
            'lon' => $validated['lon'],
        ]);
        // Adicionar imagens
        if ($request->has('hotel_images_asdasdsa')) {
            foreach ($request->file('hotel_images') as $image) {
                // Upload da imagem para o Cloudinary
                $uploadedFilePath = Storage::disk('cloudinary')->put('hotels/images', $image);

                // Construir a URL pública manualmente
                $url = "https://res.cloudinary.com/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload/" . $uploadedFilePath;

                // Salvar a URL da imagem no banco de dados
                Image::create([
                    'url' => $url,
                    'item_id' => $item->id,
                ]);
            }
        }

        // Adicionar os quartos
        if ($request->has('rooms')) {
            foreach ($request->input('rooms') as $roomData) {
                $room = Room::create([
                    'hotel_id' => $hotel->id_item,
                    'type' => $roomData['type'],
                    'bed_type' => $roomData['bed_type'],
                    'bed_count' => $roomData['bed_count'],
                    'price_night' => $roomData['price_night'],
                    'available' => $roomData['available'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Hotel adicionado com sucesso!',
        ]);
    }


    public function addActivity(Request $request)
    {
        $request->merge([
            'cancel_anytime' => filter_var($request->input('cancel_anytime'), FILTER_VALIDATE_BOOLEAN),
            'reserve_now_pay_later' => filter_var($request->input('reserve_now_pay_later'), FILTER_VALIDATE_BOOLEAN),
            'guide' => filter_var($request->input('guide'), FILTER_VALIDATE_BOOLEAN),
            'small_groups' => filter_var($request->input('small_groups'), FILTER_VALIDATE_BOOLEAN),
        ]);

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
            'tour_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Criar o item pai
        $item = Item::create([
            'item_type' => 'Activity',
        ]);

        // Criar a nova atividade usando os dados validados
        $activity = Activity::create([
            'id_item' => $item->id,  // ID do item associado à atividade
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price_hour' => $validated['price_hour'],
            'cancel_anytime' => $validated['cancel_anytime'],
            'reserve_now_pay_later' => $validated['reserve_now_pay_later'],
            'guide' => $validated['guide'],
            'small_groups' => $validated['small_groups'],
            'language' => $validated['language'],
            'country' => $validated['country'],
            'zip_code' => $validated['zip_code'],
            'city' => $validated['city'],
            'street' => $validated['street'],
            'lat' => $validated['lat'],
            'lon' => $validated['lon']
        ]);

        // Agora, a atividade foi criada com os dados validados

        // Adicionar imagens
        if ($request->has('tour_images')) {

            foreach ($request->file('tour_images') as $image) {
                // Upload da imagem para o Cloudinary
                $uploadedFilePath = Storage::disk('cloudinary')->put('activities/images', $image);

                // Construir a URL pública manualmente
                $url = "https://res.cloudinary.com/" . env('CLOUDINARY_CLOUD_NAME') . "/image/upload/" . $uploadedFilePath;

                // Salvar a URL da imagem no banco de dados
                Image::create([
                    'url' => $url,
                    'item_id' => $item->id,
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Atividade adicionada com sucesso!',
        ]);
    }


    // Remover um item
    public function removeItem(Request $request)
    {
        $id = $request->route('id');
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
        return redirect()->route('auth.admin.dashboard', ['locale' => app()->getLocale()])->with('success', 'Item removido com sucesso!');
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
        $locale = $request->route('locale');

        return redirect()->route('auth.admin.dashboard')->with('success', 'Item atualizado com sucesso!');
    }
}
