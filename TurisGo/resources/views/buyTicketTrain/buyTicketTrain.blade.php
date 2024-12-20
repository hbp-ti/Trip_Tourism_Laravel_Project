<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    @vite(['resources/css/buyTicketTrain.css'])
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
                            <select name="from" required>
                                <option value="">{{ __('messages.Origin') }}</option>
                                @foreach($stations as $station)
                                <option value="{{ $station['id'] }}">{{ $station['name'] }}</option>
                                @endforeach
                            </select>
                            <select name="to" required>
                                <option value="">{{ __('messages.Destination') }}</option>
                                @foreach($stations as $station)
                                <option value="{{ $station['id'] }}">{{ $station['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="date" name="date" required>
                        </div>
                        <div class="form-group">
                            <select name="class">
                                <option value="comfort">{{ __('messages.Comfort / 1st') }}</option>
                                <option value="tourist">{{ __('messages.Tourist / 2nd') }}</option>
                            </select>
                            <input type="number" name="passengers" min="1" value="1" placeholder="{{ __('messages.Passengers') }}" required>
                        </div>
                        <div class="form-options-container">
                            <div class="form-options">
                                <label for="preference">{{ __('messages.Train') }}</label>
                                <select name="preference" id="preference">
                                    <option value="AP" selected>{{ __('messages.Alfa Pendular') }}</option>
                                    <option value="IR">{{ __('messages.Inter regional') }}</option>
                                    <option value="IC">{{ __('messages.Inter city') }}</option>
                                    <option value="U">{{ __('messages.Urban') }}</option>
                                    <option value="R">{{ __('messages.Regional') }}</option>
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
                            @foreach($journeys as $journey)
                            @foreach($journey['legs'] as $leg)
                            <tr>
                                <form action="{{ route('auth.createTicket', ['locale' => app()->getLocale()]) }}" method="POST">
                                    @csrf
                                    <td>{{ $leg['line']['productCode'] . ' - ' . $leg['line']['id'] }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leg['departure'])->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leg['arrival'])->format('H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($leg['departure'])->diff(\Carbon\Carbon::parse($leg['arrival']))->format('%H:%I') }}</td>
                                    <td>{{ $journey['price']['amount'] }} {{ $journey['price']['currency'] }}</td>
                                    <td>
                                        <button type="submit">{{ __('messages.Book Now') }}</button>
                                        <input type="hidden" name="journey_id" value="{{ $journey['id'] }}">
                                    </td>
                                </form>
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
    <x-footer/>
</body>

</html>
