<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    /**
     * Upload de imagem
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        // Validação da imagem
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:8192',
        ]);

        // Verifique se a validação falhou
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'A imagem deve ser um arquivo de imagem válido (jpeg, png, jpg) e não deve ultrapassar 8MB.',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Verifique se o arquivo foi enviado
        if ($request->hasFile('image')) {
            // Armazenar a imagem na pasta 'uploads' dentro de 'storage/app/public'
            $path = $request->file('image')->store('imageUploads', 'public');

            // Gerar a URL da imagem
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'message' => 'Imagem carregada com sucesso.',
                'data' => [
                    'url' => $url,
                    'path' => $path,
                    'size' => $request->file('image')->getSize(),
                    'mime' => $request->file('image')->getMimeType(),
                    'original_name' => $request->file('image')->getClientOriginalName(),
                ]
            ], 200);
        }

        // Caso o arquivo não tenha sido enviado
        return response()->json([
            'success' => false,
            'message' => 'Nenhuma imagem foi enviada.',
        ], 400);
    }
}

