<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/buyTicketTrain.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/buyTicket.js'])
</head>

<body>
    <x-header />
    <div class="header">
        <h1>{{ __('messages.Tickets') }}</h1>
        <p>{{ __('messages.Buy tickets with us') }}</p>
    </div>
    <main>
        <section class="tickets">
            <h1>{{ __('messages.Tickets') }}</h1>
            <div class="online-tickets">
                <h2>{{ __('messages.Online Tickets') }}</h2>
                <div class="form-container">
                    <form action="{{ route('search.journeys', ['locale' => app()->getLocale()]) }}" method="POST">
                        @csrf
                    
                        <div class="form-group">
                            <!-- Campo "from" (origem) -->
                            <select name="from" required>
                                <option value="">{{ __('messages.Origin') }}</option>
                                @foreach ($stations as $station)
                                    <option value="{{ $station['id'] }}" {{ old('fromId', $fromId ?? '') == $station['id'] ? 'selected' : '' }}>
                                        {{ $station['name'] }}
                                    </option>
                                @endforeach
                            </select>
                    
                            <!-- Campo "to" (destino) -->
                            <select name="to" required>
                                <option value="">{{ __('messages.Destination') }}</option>
                                @foreach ($stations as $station)
                                    <option value="{{ $station['id'] }}" {{ old('toId', $toId ?? '') == $station['id'] ? 'selected' : '' }}>
                                        {{ $station['name'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    
                        <div class="form-group">
                            <input type="date" name="date" value="{{ old('date', $date ?? '') }}" required>
                        </div>
                    
                        <div class="form-group">
                            <select name="class">
                                <option value="Comfort" {{ (old('class') == 'comfort' || isset($class) && $class == 'comfort') ? 'selected' : '' }}>
                                    {{ __('messages.Comfort / 1st') }}
                                </option>
                                <option value="Tourist" {{ (old('class') == 'tourist' || isset($class) && $class == 'tourist') ? 'selected' : '' }}>
                                    {{ __('messages.Tourist / 2nd') }}
                                </option>
                            </select>
                            <input type="number" name="passengers" min="1" value="{{ old('passengers', $passengers ?? 1) }}"
                                placeholder="{{ __('messages.Passengers') }}" required>
                        </div>
                    
                        <div class="form-options-container">
                            <div class="form-options">
                                <label for="preference">{{ __('messages.Train') }}</label>
                                <select name="preference" id="preference">
                                    <option value="AP" {{ (old('preference') == 'AP' || isset($train) && $train == 'AP') ? 'selected' : '' }}>
                                        {{ __('messages.Alfa Pendular') }}
                                    </option>
                                    <option value="IR" {{ (old('preference') == 'IR' || isset($train) && $train == 'IR') ? 'selected' : '' }}>
                                        {{ __('messages.Inter regional') }}
                                    </option>
                                    <option value="IC" {{ (old('preference') == 'IC' || isset($train) && $train == 'IC') ? 'selected' : '' }}>
                                        {{ __('messages.Inter city') }}
                                    </option>
                                    <option value="U" {{ (old('preference') == 'U' || isset($train) && $train == 'U') ? 'selected' : '' }}>
                                        {{ __('messages.Urban') }}
                                    </option>
                                    <option value="R" {{ (old('preference') == 'R' || isset($train) && $train == 'R') ? 'selected' : '' }}>
                                        {{ __('messages.Regional') }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    
                        <button type="submit">{{ __('messages.Search') }}</button>
                    </form>
                    
                    
                </div>
            </div>

            <!-- Exibição das Jornadas -->
            @isset($journeys)
                <section class="timetable">
                    <h2>{{ __('messages.Timetable') }}</h2>
                    <div class="route">
                        <div class="go-container">
                            <span class="go-label">{{ __('messages.GO') }}</span>
                        </div>
                        <div class="route-info-container">
                            <span class="route-info">{{ $from }} &gt; {{ $to }}</span>
                        </div>
                    </div>

                    <div class="timetable-container">
                        <table class="timetable">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.Service') }}</th>
                                    <th>{{ __('messages.Departure') }}</th>
                                    <th>{{ __('messages.Arrival') }}</th>
                                    <th>{{ __('messages.Duration') }}</th>
                                    <th>{{ __('messages.Price') }}</th>
                                    <th>{{ __('messages.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($journeys as $journey)
                                    @foreach ($journey['legs'] as $leg)
                                        <tr data-journey-id="{{ $journey['id'] }}">
                                            <td>{{ $leg['line']['productCode'] . ' - ' . $leg['line']['id'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($leg['departure'])->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($leg['arrival'])->format('H:i') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($leg['departure'])->diff(\Carbon\Carbon::parse($leg['arrival']))->format('%H:%I') }}
                                            </td>
                                            <td>{{ $journey['price']['amount'] }} {{ $journey['price']['currency'] }}</td>
                                            <td>
                                                <button class="book-now" type="button"
                                                    data-journey="{{ urlencode(json_encode($journey)) }}"
                                                    data-leg="{{ urlencode(json_encode($leg)) }}">
                                                    {{ __('messages.Book Now') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>
            @endisset
        </section>
        @if (session('popup'))
            {!! session('popup') !!}
        @endif
    </main>
    <x-footer />
</body>

</html>
