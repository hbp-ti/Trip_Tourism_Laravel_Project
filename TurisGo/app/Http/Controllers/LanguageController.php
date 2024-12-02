<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function changeLanguage($new_locale)
    {
        // Verificar se o idioma é válido
        $supportedLocales = ['en', 'pt'];
        
        if (in_array($new_locale, $supportedLocales)) {
            // Definir o idioma
            Session::put('locale', $new_locale); // Armazena o novo idioma na sessão
        } else {
            // Se o idioma não for suportado, redireciona para o idioma padrão
            $new_locale = 'en'; // Idioma padrão
            Session::put('locale', 'en');
        }
        
        // Redireciona de volta para a página anterior
        return Redirect::back();
    }
}
