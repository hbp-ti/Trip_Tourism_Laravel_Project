<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
    <x-header/>
     <!-- Header Section -->
     <section class="header">
        <h1>{{ __('messages.Dashboard') }}</h1>
        <p>{{ __('messages.Some things about us') }}</p>
    </section>

    

    <x-footer/>
</body>
</html>
