<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function showForm()
    {
        return view('upload');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png|max:8192', 
        ]);

        $path = $request->file('image')->store('imageUploads', 'public');

        return back()->with('success', 'Imagem carregada com sucesso!')->with('path', $path);
	}
}
