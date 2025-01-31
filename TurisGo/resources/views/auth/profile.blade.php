<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <!-- Incluir o SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/profile.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/translations.js', 'resources/js/profile.js'])
</head>

<body>
    <x-header /> <!-- Componente de Cabeçalho -->

    <div class="header">
        <!-- Container do Cabeçalho -->
        <div class="profile-pic-container">
            <img src="{{ file_exists(public_path('storage/' . Auth::user()->image)) ? asset('storage/' . Auth::user()->image) : asset('images/default_user_image.png') }}"
                class="profile-pic" alt="Profile Picture">
            <div class="button-overlay">
                <form id="profileForm" action="{{ route('upload.handle', ['locale' => app()->getLocale()]) }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Input de imagem -->
                    <input type="file" name="profile_picture" id="uploadInput" accept="image/*"
                        style="display: none;">
                    <!-- Botão de enviar imagem -->
                    <button type="button" class="edit-profile-pic" id="changeprofilepic">
                        <img src="{{ asset('images/changeImage.png') }}" alt="Edit Icon">
                    </button>
                </form>
            </div>
        </div>

        <div class="header-text">
            <h1 class="header-title">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
            <p class="header-subtitle">{{ __('Profile') }}</p>
        </div>
    </div>
    <!-- Conteúdo do Perfil -->
    <div class="profile-content">
        <img src="{{ asset('images/fundoprofile.png') }}" class="profile-background" alt="Profile Background">

        <form class="profile-info" method="POST"
            action="{{ route('auth.profile.update', ['locale' => app()->getLocale()]) }}">
            @csrf
            <div class="form-group">
                <label>{{ __('messages.First Name') }}</label>
                <input type="text" name="first_name" value="{{ Auth::user()->first_name }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Last Name') }}</label>
                <input type="text" name="last_name" value="{{ Auth::user()->last_name }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Username') }}</label>
                <input type="text" name="username" value="{{ Auth::user()->username }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Email') }}</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Phone') }}</label>
                <input type="text" name="phone" value="{{ Auth::user()->phone ?? __('messages.Not provided') }}">
            </div>
            <div class="form-group">
                <label>{{ __('messages.Submit') }}</label>
                <button id="changeinfoButton" type="submit"
                    class="change-info-btn">{{ __('messages.Submit Changes') }}</button>
            </div>
        </form>
        @if (session('popup'))
            {!! session('popup') !!}
        @endif
        <div class="right-align">
            <button id="changePasswordButton" type="button"
                class="change-password-btn">{{ __('messages.Change Password') }}</button>
        </div>
        <!-- Popup de Mudança de Password -->
        <div class="popup-overlay">
            <div id="passwordPopup" class="popup hidden">
                <div class="popup-content">
                    <h2>{{ __('messages.Change Password') }}</h2>

                    <form id="changePasswordForm" method="POST"
                        action="{{ route('auth.profile.updatePassword', ['locale' => app()->getlocale()]) }}">
                        @csrf
                        <!-- Campo para senha antiga -->
                        <div class="form-group">
                            <label for="oldPassword">{{ __('messages.Current Password') }}</label>
                            <input type="password" id="oldPassword" name="oldPassword"
                                placeholder="{{ __('messages.Enter last password') }}" required>
                        </div>

                        <!-- Campo para nova senha -->
                        <div class="form-group">
                            <label for="newPassword">{{ __('messages.New Password') }}</label>
                            <input type="password" id="newPassword" name="newPassword"
                                placeholder="{{ __('messages.Enter new password') }}" required>
                        </div>

                        <!-- Campo para confirmação da nova senha -->
                        <div class="form-group">
                            <label for="confirmPassword">{{ __('messages.Confirm New Password') }}</label>
                            <input type="password" id="confirmPassword" name="newPassword_confirmation"
                                placeholder="{{ __('messages.Confirm new password') }}" required>
                        </div>

                        <!-- Botões -->
                        <div class="popup-buttons">
                            <button type="button" id="cancelChangePassword" class="cancel-btn">Cancel</button>
                            <button type="submit" id="confirmChangePassword" class="confirm-btn">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="title-line-container profile-section">
            <h2>{{ __('messages.Invoices') }}</h2>
            <hr class="title-line-blue">
        </div>

        <div class="reservations active-reservations">
            @if ($orders->isEmpty())
                <p>{{ __('messages.No active orders at the moment.') }}</p>
            @else
                @foreach ($orders as $order)
                <div class="reservation-item">
                    <img src="{{ $order->image_url ?? asset('images/defaultOrder.jpg') }}" alt="Order {{ $order->id }}">
                    <div class="reservation-info">
                        <div>
                            <!-- Icone e data -->
                            <p><img src="{{ asset('images/datahotel.png') }}" class="icon">{{ __('Date') }}: {{ $order->date }}</p>
                    
                            <!-- Icone e Payment Method -->
                            <p><img src="{{ asset('images/profilepagamento.png') }}" class="icon">{{ __('Payment Method') }}: {{ $order->payment_method }}</p>
                    
                            <!-- Icone e Total -->
                            <p><img src="{{ asset('images/totalprofile.png') }}" class="icon">{{ __('Total') }}: ${{ $order->total }}</p>
                        </div>
                        <div class="buttons-placement">
                            <!-- Botão para exibir os detalhes do pedido -->
                            <button class="details-button-order">
                                {{ __('messages.Details') }}
                            </button>
                        </div>
                    </div>
                    <div class="download-placement">
                        <form
                            action="{{ route('auth.orderDownload', ['id' => $order->id, 'locale' => app()->getLocale()]) }}"
                            method="POST">
                            @csrf
                            <button class="download1-button">
                                {{ __('messages.Download') }} <img src="{{ asset('images/download.png') }}"
                                    class="Dicon">
                            </button>
                        </form>
                    </div>
                    <!-- Popup de detalhes da fatura -->
                    <div class="popupInvoiceDetails" style="display: none;">
                        <br>
                        <span class="popupInvoiceDetailsTitle">Details</span>
                        <div class="popupInvoiceDetailsText">
                            <p><b>Order ID:</b> {{ $order->id }}</p>
                            <p><b>Date:</b> {{ $order->date }}</p>
                            <p><b>Customer Name:</b> {{ $order->user->first_name }} {{ $order->user->last_name }}</p>
                            <p><b>Email:</b> {{ $order->user->email }}</p>
                            <br>
                            <table class="popupInvoiceDetailsTable">
                                <tr>
                                    <th>Item</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                </tr>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->details->name }}</td>
                                        <td>{{ $item->item->item_type }}</td>
                                        @if ($item->item->item_type === 'Ticket')
                                            <td>{{ $item->train_people_count }}</td>
                                        @elseif ($item->item->item_type === 'Activity')
                                            <td>{{ $item->numb_people_activity }}</td>
                                        @elseif ($item->item->item_type === 'Hotel')
                                            <td>{{ $item->numb_people_hotel }}</td>
                                        @endif
                                        <td>${{ number_format($item->details->total_price, 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <br>
                            <p class="popupInvoiceDetailsSubtitle"><b>Payment Information</b></p>
                            <p><b>Method</b>: {{ $order->payment_method }}</p>
                            <br>
                            <p class="popupInvoiceDetailsSubtitle"><b>Billing Information</b></p>
                            <p><b>Billing Country:</b> {{ $order->billing_country }}</p>
                            <p><b>Billing City:</b> {{ $order->billing_city }}</p>
                            <p><b>Billing Address:</b> {{ $order->billing_address }}</p>
                            <p><b>Postal Code:</b> {{ $order->billing_postal_code }}</p>
                        </div>
                        <div class="popupInvoiceDetailsButton">Close</div>
                    </div>
                </div>
                
                @endforeach
            @endif
        </div>

        <div class="title-line-container profile-section">
            <h2>{{ __('messages.Active Reservations') }}</h2>
            <hr class="title-line-orange">
        </div>

        <!-- Reservas Ativas -->
        <div class="reservations active-reservations">
            <!-- Exibir reservas ativas -->
            @if ($activeReservations->isEmpty())
                <p>{{ __('messages.No active reservations at the moment.') }}</p>
            @else
                @foreach ($activeReservations as $reservation)
                    @if ($reservation->details->type === 'Hotel')
                        <div class="reservation-item">
                            <img src="{{ $reservation->details->images[0]->url }}"
                                alt="{{ $reservation->details->name }}">
                            <div class="reservation-info">
                                <div>
                                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                        {{ $reservation->details->name }}</h3>
                                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                        {{ $reservation->reservation_date_hotel_checkin . '->' . $reservation->reservation_date_hotel_checkout }}
                                    </p>
                                </div>

                                <div class="buttons-placement">
                                    <a href="{{ route('auth.hotelDetail', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        class="details-button">
                                        {{ __('messages.Details') }}
                                    </a>

                                    <!-- Botão para cancelar a reserva -->
                                    <form
                                        action="{{ route('auth.reservation.cancel', ['order_id' => $reservation->order->id, 'item_id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="cancel-button">
                                            {{ __('messages.Cancel') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif ($reservation->details->type === 'Activity')
                        <div class="reservation-item">
                            <img src="{{ $reservation->details->images[0]->url ?? asset('images/atividade1.png') }}"
                                alt="{{ $reservation->details->name }}">
                            <div class="reservation-info">
                                <div>
                                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                        {{ $reservation->details->name }}</h3>
                                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                        {{ $reservation->date_activity }}
                                    </p>
                                </div>

                                <div class="buttons-placement">
                                    <a href="{{ route('auth.tourDetail', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        class="details-button">
                                        {{ __('messages.Details') }}
                                    </a>

                                    <!-- Botão para cancelar a reserva -->
                                    <form
                                        action="{{ route('auth.reservation.cancel', ['order_id' => $reservation->order->id, 'item_id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="cancel-button">
                                            {{ __('messages.Cancel') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="reservation-item">
                            <img src="{{ asset('images/trainTicket.jpg') }}"
                                alt="{{ $reservation->details->name }}">
                            <div class="reservation-info">
                                <div>
                                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                        {{ $reservation->details->name }}</h3>
                                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                        {{ $reservation->details->departure_hour }}</p>
                                </div>

                                <div class="buttons-placement">
                                    <!-- Botão para detalhes da reserva -->
                                    <a class="details-button" id="show-popup">
                                        {{ __('messages.Details') }}
                                    </a>

                                    <!-- Botão para cancelar a reserva -->
                                    <form
                                        action="{{ route('auth.reservation.cancel', ['order_id' => $reservation->order->id, 'item_id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="cancel-button">
                                            {{ __('messages.Cancel') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Popup -->
                        <div id="popup-overlay"></div>
                        <div id="popup">
                            <img src="/images/trainTicket.jpg" class="train-image" alt="Train Image">

                            <div class="flexbox-container">
                                <div class="box1">
                                    <div class="details">
                                        <h1>{{ $reservation->details->name }}</h1>
                                        <span>&#x1F465;&#xFE0E;&nbsp;&nbsp;<b>{{ $reservation->details->quantity }}</b></span>
                                        <br>
                                        <span>&#x1F552;&#xFE0E;&nbsp;&nbsp;<b>{{ $reservation->details->departure_hour }}
                                                -> {{ $reservation->details->arrival_hour }}</b></span>
                                    </div>
                                </div>
                                <div class="box2">
                                    <img src="/images/qrCode.png" class="qrCodeImage" alt="QR Code">
                                </div>
                            </div>

                            <div class="timetable-container">
                                <table class="timetable">
                                    <thead>
                                        <tr>
                                            <th>Service</th>
                                            <th>Departure</th>
                                            <th>Arrival</th>
                                            <th>Train</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $reservation->details->train_id }}</td>
                                            <td>{{ $reservation->details->departure_hour }}</td>
                                            <td>{{ $reservation->details->arrival_hour }}</td>
                                            <td>{{ $reservation->train_type }}</td>
                                            <td>{{ $reservation->details->total_price }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button id="close-popup" class="close-button">Close</button>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="title-line-container profile-section">
            <h2>{{ __('messages.Reservation History') }}</h2>
            <hr class="title-line-blue">
        </div>

        <!-- Histórico de Reservas -->
        <div class="reservations history">
            <!-- Exibir histórico de reservas -->
            @if ($expiredReservations->isEmpty())
                <p>{{ __('messages.No past reservations available.') }}</p>
            @else
                @foreach ($expiredReservations as $reservation)
                    @if ($reservation->details->type === 'Hotel')
                        <div class="reservation-item">
                            <img src="{{ $reservation->details->images[0]->url }}"
                                alt="{{ $reservation->details->name }}">
                            <div class="reservation-info">
                                <div>
                                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                        {{ $reservation->details->name }}</h3>
                                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                        {{ $reservation->reservation_date_hotel_checkin . '->' . $reservation->reservation_date_hotel_checkout }}
                                    </p>
                                </div>

                                <div class="buttons-placement">
                                    <a href="{{ route('auth.hotelDetail', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        class="details-button">
                                        {{ __('messages.Details') }}
                                    </a>
                                    <form
                                        action="{{ route('hotel.hotel', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="book-again-button">
                                            {{ __('messages.Book Again') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif ($reservation->details->type === 'Activity')
                        <div class="reservation-item">
                            <img src="{{ $reservation->details->images[0]->url ?? asset('images/atividade1.png') }}"
                                alt="{{ $reservation->details->name }}">
                            <div class="reservation-info">
                                <div>
                                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                        {{ $reservation->details->name }}</h3>
                                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                        {{ $reservation->date_activity }}
                                    </p>
                                </div>

                                <div class="buttons-placement">
                                    <a href="{{ route('auth.tourDetail', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        class="details-button">
                                        {{ __('messages.Details') }}
                                    </a>
                                    <form
                                        action="{{ route('tour.tour', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="book-again-button">
                                            {{ __('messages.Book Again') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="reservation-item">
                            <img src="{{ asset('images/trainTicket.jpg') }}"
                                alt="{{ $reservation->details->name }}">
                            <div class="reservation-info">
                                <div>
                                    <h3><img src="{{ asset('images/iconehotel.png') }}" class="icon">
                                        {{ $reservation->details->name }}</h3>
                                    <p><img src="{{ asset('images/datahotel.png') }}" class="icon">
                                        {{ $reservation->details->departure_hour }}
                                    </p>
                                </div>

                                <div class="buttons-placement">
                                    <a class="details-button" id="show-popup">
                                        {{ __('messages.Details') }}
                                    </a>
                                    <!-- Botão para reservar novamente -->
                                    <form
                                        action="{{ route('auth.hotel.hotel', ['id' => $reservation->details->id, 'locale' => app()->getLocale()]) }}"
                                        method="GET">
                                        @csrf
                                        <button type="submit" class="book-again-button">
                                            {{ __('messages.Book Again') }}
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Popup -->
                            <div id="popup-overlay"></div>
                            <div id="popup">
                                <img src="/images/trainTicket.jpg" class="train-image" alt="Train Image">

                                <div class="flexbox-container">
                                    <div class="box1">
                                        <div class="details">
                                            <h1>{{ $reservation->details->name }}</h1>
                                            <span>&#x1F465;&#xFE0E;&nbsp;&nbsp;<b>{{ $reservation->details->quantity }}</b></span>
                                            <br>
                                            <span>&#x1F552;&#xFE0E;&nbsp;&nbsp;<b>{{ $reservation->details->departure_hour }}
                                                    -> {{ $reservation->details->arrival_hour }}</b></span>
                                        </div>
                                    </div>
                                    <div class="box2">
                                        <img src="/images/qrCode.png" class="qrCodeImage" alt="QR Code">
                                    </div>
                                </div>

                                <div class="timetable-container">
                                    <table class="timetable">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Departure</th>
                                                <th>Arrival</th>
                                                <th>Train</th>
                                                <th>Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{ $reservation->details->train_id }}</td>
                                                <td>{{ $reservation->details->departure_hour }}</td>
                                                <td>{{ $reservation->details->arrival_hour }}</td>
                                                <td>{{ $reservation->train_type }}</td>
                                                <td>{{ $reservation->details->total_price }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <button id="close-popup" class="close-button">Close</button>
                            </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>



    <x-footer /> <!-- Componente de Rodapé -->
	<script>
	const appUrl = "{{ config('app.url') }}";
	</script>
</body>

</html>
