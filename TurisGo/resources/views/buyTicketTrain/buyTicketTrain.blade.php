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
        <h1>{{ __('Tickets') }}</h1>
        <p>{{ __('Buy tickets with us') }}</p>
    </div>
    <main>
        <section class="tickets">
            <h1>{{ __('Tickets') }}</h1>
            <div class="online-tickets">
                <h2>{{ __('Online Tickets') }}</h2>
                <div class="form-container">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <input type="text" placeholder="{{ __('Origin') }}">
                            <input type="text" placeholder="{{ __('Destination') }}">
                        </div>
                        <div class="form-group">
                            <input type="date" value="2024-11-05">
                            <input type="date" value="2024-11-05">
                        </div>
                        <div class="form-group">
                            <select>
                                <option value="comfort">{{ __('Comfort / 1st') }}</option>
                                <option value="tourist">{{ __('Tourist / 2nd') }}</option>
                            </select>
                            <input type="number" min="1" value="1" placeholder="{{ __('Passengers') }}">
                        </div>
                        <div class="form-options-container">
                            <div class="form-options">
                                <label>
                                    <input type="radio" name="preference" value="regional" checked>
                                    {{ __('Alfa Pendular / IC') }}
                                </label>
                                <label>
                                    <input type="radio" name="preference" value="intercity">
                                    {{ __('Intercity') }}
                                </label>
                                <label>
                                    <input type="radio" name="preference" value="urban">
                                    {{ __('Urban') }}
                                </label>
                                <label>
                                    <input type="radio" name="preference" value="regional">
                                    {{ __('Regional') }}
                                </label>
                            </div>
                            <div class="form-submit">
                                <button type="submit">{{ __('Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="timetable">
            <h2>{{ __('Timetable') }}</h2>
            <div class="route">
                <div class="go-container">
                    <span class="go-label">{{ __('GO') }}</span>
                </div>
                <div class="route-info-container">
                    <span class="route-info">Águeda &gt; Aveiro</span>
                </div>
            </div>
            
            <div class="timetable-container">
                <table class="timetable">
                    <thead>
                        <tr>
                            <th></th> <!-- Coluna para os checkboxes -->
                            <th>{{ __('Service') }}</th>
                            <th>{{ __('Departure') }}</th>
                            <th>{{ __('Arrival') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>R1111</td>
                            <td>15:42</td>
                            <td>17:04</td>
                            <td>01h22</td>
                            <td>$22.20</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>R1112</td>
                            <td>15:42</td>
                            <td>17:04</td>
                            <td>01h22</td>
                            <td>$22.20</td>
                        </tr>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>R1113</td>
                            <td>15:42</td>
                            <td>17:04</td>
                            <td>01h22</td>
                            <td>$22.20</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="confirm">
                <label>
                    <input type="checkbox" required>
                    {{ __('I declare that I don’t have less than 18 years.') }}
                </label>
                <button type="button">{{ __('Continue') }}</button>
            </div>
        </section>
        
    </main>
    <x-footer />
</body>
</html>
