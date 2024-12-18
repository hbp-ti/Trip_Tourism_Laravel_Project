<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PopupHelper;

class ReviewController extends Controller
{
    public function addReview(Request $request)
    {
        // Verifica se o usuário está logado
        $locale = $request->route('locale');
        $item_id  = $request->route('item_id');

        if (!Auth::check()) {

            $popupError = PopupHelper::showPopup(
                'Authentication!',
                'You must be logged in to remove items from the cart',
                'Error',
                'OK',
                false,
                '',
                5000
            );
            // Se não estiver logado, redireciona para a página de login e exibe um popup
            return redirect()->route('auth.login.form', ['locale' => $locale])
                ->with('popup', $popupError);
        }

        $item = Item::find($item_id);

        if (!$item) {

            $popupError = PopupHelper::showPopup(
                'Error!',
                'Item not found',
                'Error',
                'OK',
                false,
                '',
                5000
            );
            // Se não encontrar o item, lance um erro ou retorne uma mensagem personalizada
            return redirect()->back()->with('popup', $popupError);
        }
        // Validação dos campos
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Criação da nova review
        $review = Review::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'rating' => $validatedData['rating'],
            'user_id' => Auth::id(), // Obtém o ID do usuário autenticado
            'item_id' => $item_id, // Aqui usamos o 'item_id' da URL, não o 'validatedData'
        ]);


        $popupSuccess = PopupHelper::showPopup(
            'Success!',
            'your review has been added with success',
            'Success',
            'OK',
            false,
            '',
            5000
        );
        // Retorna uma resposta (pode ser uma página ou uma mensagem JSON)
        return redirect()->back()->with('popup', $popupSuccess);
    }
}
