<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Obter o locale da rota
        $locale = $request->route('locale');

        // Lista de idiomas suportados
        $supportedLocales = ['en', 'pt'];

        // Verificar se o locale está na lista de suportados
        if (in_array($locale, $supportedLocales)) {
            App::setLocale($locale); // Definir o idioma da aplicação
        } else {
            // Opcional: Redirecionar para um idioma padrão ou exibir erro
            App::setLocale(config('app.fallback_locale', 'en')); // Idioma padrão
        }

        return $next($request);
    }
}
