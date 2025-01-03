<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/js/translations.js', 'resources/css/error.css', 'resources/js/contact.js'])
</head>
<body>

    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Error') }}</h1>
        <p>{{ __('messages.Page not found') }}</p>
    </section>

    <!-- Error Section -->
    <section class="error-section">
        <div class="error-container">
            <h2>{{ __('messages.Not Found Error 404') }}</h2>
            <p>{{ __('messages.The page you are looking for might have been removed or is temporarily unavailable.') }}</p>
            <p>{{ __('messages.Please return to the homepage.') }}</p>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

</body>
</html>

