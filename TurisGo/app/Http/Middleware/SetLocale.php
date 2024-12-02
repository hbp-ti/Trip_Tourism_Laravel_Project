<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Obter o locale da rota
        $locale = $request->route('locale'); // Obtém o locale diretamente da rota

        // Lista de idiomas suportados
        $supportedLocales = ['en', 'pt'];

        // Verificar se o locale está na lista de suportados
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale); // Definir o idioma da aplicação
            Session::put('locale', $locale); // Armazenar o idioma na sessão
        } else {
            // Se o idioma não for suportado, usa o idioma padrão
            App::setLocale(config('app.fallback_locale', 'en')); // Idioma padrão
            Session::put('locale', 'en'); // Garantir que o idioma na sessão seja 'en'
        }

        return $next($request);
    }
}
