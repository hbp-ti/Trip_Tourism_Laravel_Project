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
        $supportedLocales = ['en', 'pt']; // Idiomas suportados
        $locale = null;

        // Obtém os segmentos da URL
        $segments = $request->segments();

        // Verifica se o segundo segmento é um idioma suportado
        if (!empty($segments) && isset($segments[1]) && in_array($segments[1], $supportedLocales)) {
            $locale = $segments[1];
        }

        // Se não houver locale ou ele for inválido
        if (!$locale) {
            // Usa o locale da sessão ou o padrão
            $locale = Session::get('locale', config('app.locale'));
            if (!in_array($locale, $supportedLocales)) {
                $locale = config('app.fallback_locale', 'en'); // Locale padrão
            }

            // Redireciona com o locale correto
            return redirect($this->addLocaleToUrl($request, $locale));
        }

        // Define o locale na aplicação
        App::setLocale($locale);

        // Armazena o locale na sessão
        Session::put('locale', $locale);

        return $next($request);
    }

    /**
     * Adiciona o locale na URL sem duplicar o prefixo ou afetar a estrutura original.
     */
    private function addLocaleToUrl(Request $request, $locale)
    {
        $supportedLocales = ['en', 'pt']; // Idiomas suportados
        $segments = $request->segments();

        // Remove o idioma existente, se presente no segundo segmento
        if (isset($segments[1]) && in_array($segments[1], $supportedLocales)) {
            unset($segments[1]);
        }

        // Adiciona o novo idioma no segundo segmento
        array_splice($segments, 1, 0, $locale);

        // Reconstrói a URL com os segmentos corrigidos
        $baseUrl = $request->getSchemeAndHttpHost(); // Ex.: http://estga-dev.ua.pt
        return $baseUrl . '/' . implode('/', $segments);
    }
}