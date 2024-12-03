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
        // Obtém o locale da URL
        $locale = $request->route('locale');
        $supportedLocales = ['en', 'pt']; // Idiomas suportados


        // Se não houver locale na URL
        if (!$locale) {
            // Tenta buscar o locale da sessão ou usa o padrão
            $locale = Session::get('locale', config('app.locale'));
            // Se não houver locale válido, adiciona o padrão à URL
            return redirect()->to($this->addLocaleToUrl($request, $locale));
        }

        // Verifica se o locale é válido
        if (!in_array($locale, $supportedLocales)) {
            // Se o locale não for válido, usa o locale padrão
            $locale = config('app.fallback_locale', 'en');
            // Redireciona para a mesma URL com o locale correto
            return redirect()->to($this->addLocaleToUrl($request, $locale));
        }

        // Define o locale na aplicação
        App::setLocale($locale);
        // Armazena o locale na sessão
        Session::put('locale', $locale);

        return $next($request);
    }

    /**
     * Adiciona o locale na URL sem perder os parâmetros e a rota original.
     */
    private function addLocaleToUrl(Request $request, $locale)
    {
        // Verifica se a URL já contém o locale
        $url = $request->url();
        
        // Se o locale não estiver na URL, adicione ao início da URL
        if (strpos($url, '/' . $locale) === false) {
            return url($locale . $request->getRequestUri());
        }

        // Caso o locale já esteja na URL, retorna a URL original
        return $url;
    }
}
