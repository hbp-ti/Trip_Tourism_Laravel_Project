<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Captura o locale da URL
        $locale = $request->route('locale'); // Obtém o locale diretamente da URL

        // Lista de idiomas suportados
        $supportedLocales = ['en', 'pt'];

        // Verifica se o locale é suportado
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale); // Define o idioma
            Session::put('locale', $locale); // Armazena o idioma na sessão
        } else {
            // Se o idioma não for suportado, usa o idioma padrão
            App::setLocale(config('app.fallback_locale', 'en'));
            Session::put('locale', 'en');
        }

        return $next($request);
    }
}
