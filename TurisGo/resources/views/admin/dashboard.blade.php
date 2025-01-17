<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/dashboard.css', 'resources/css/pagination.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/dashboard.js'])
</head>

<body>
    <x-header />

    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Dashboard') }}</h1>
        <p>{{ __('messages.Explore, update, and enhance the TurisGo experience.') }}</p>
    </section>

    <div class="dashboard">
        <div class="left-dashboard-options">
            <h2 class="dashboard-title">
                <div class="icon">
                    <img src="{{ asset('images/dashboard_icon_orange.png') }}" alt="{{ __('messages.Dashboard') }}">
                </div>
                {{ __('messages.Dashboard') }}
            </h2>
            <div class="left-dashboard">
                <ul>
                    <li><a href="#" id="add-hotel-link"><img src="{{ asset('images/addHotel_icon.png') }} "
                                alt="{{ __('messages.Add Hotel') }}">{{ __('messages.Add Hotel') }}</a></li>
                    <li><a href="#" id="add-tour-link"><img src="{{ asset('images/addTour_icon.png') }} "
                                alt="{{ __('messages.Add Tour') }}">{{ __('messages.Add Tour') }}</a></li>
                    <li><a href="#" id="delete-item-link"><img src="{{ asset('images/deleteItem_icon.png') }} "
                                alt={{ __('messages.Delete Item') }}>{{ __('messages.Delete Item') }}</a></li>
                    <li><a href="#" id="admin-link"><img src="{{ asset('images/admin_icon.png') }} "
                                alt="{{ __('messages.List Admins') }}">List Admins</a></li>
                </ul>
            </div>
        </div>

        <div class="right-dashboard">
            <div id="add-hotel" class="form-section" style="display: none;">
                <h2>{{ __('messages.Add New Hotel') }}</h2>
                @csrf
                <form action="{{ route('auth.admin.addHotel', ['locale' => app()->getLocale()]) }}" method="POST"
                    enctype="multipart/form-data">
                    <div class="search-field">
                        <label for="name">{{ __('messages.Hotel Hotel') }}</label>
                        <input type="text" placeholder="{{ __('messages.Hotel Name') }}" name="name" required>
                    </div>
                    <div class="search-field">
                        <label for="description">{{ __('messages.Description') }}</label>
                        <textarea placeholder="{{ __('messages.Description') }}" name="description" required></textarea>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Country">{{ __('messages.Country') }}</label>
                            <input type="text" name="country" placeholder="{{ __('messages.Country') }}" required>
                        </div>
                        <div class="search-field">
                            <label for="City">{{ __('messages.City') }}</label>
                            <input type="text" name="city" placeholder="{{ __('messages.City') }}" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Street">{{ __('messages.Street') }}</label>
                            <input type="text" name="street" placeholder="{{ __('messages.Street') }}" required>
                        </div>
                        <div class="search-field">
                            <label for="zip">{{ __('messages.ZIP Code') }}</label>
                            <input type="text" name="zip_code" placeholder="{{ __('messages.ZIP Code') }}" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="stars">{{ __('Hotel Stars') }}</label>
                            <select name="stars" id="stars">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="search-field">
                            <label for="Price">{{ __('messages.Price') }}</label>
                            <input type="number" placeholder="{{ __('messages.Price') }}" required>
                        </div>
                    </div>
                    <div class="search-field">
                        <label for="rating">{{ __('messages.Guest Rating') }}</label>
                        <input type="number" id="rating" name="average_guest_rating" min="1" max="5" step="0.5"
                            placeholder="{{ __('messages.Guest Rating') }}" required>
                    </div>

                    <div class="flex-container bottom">
                        <div class="coordinates">
                            <div class="search-field">
                                <label for="coordinates">{{ __('messages.Coordinates') }}</label>
                                <input type="text" id="lat" name="lat" placeholder="{{ __('messages.Latitude') }}" required>
                                <input type="text" id="lon" name="lon" placeholder="{{ __('messages.Longitude') }}" required>
                            </div>
                        </div>
                        <div class="hotel-filters">
                            <div class="search-field"><label for="Filters">{{ __('messages.Filters') }}</label></div>

                            <div class="hotel-filters-top">                                
                                <label>
                                    {{ __('messages.Non smoking rooms') }}
                                    <label class="switch">
                                        <input type="checkbox" name="non_smoking_rooms">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Free Wi-Fi') }}
                                    <label class="switch">
                                        <input type="checkbox" name="free_wifi">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Parking') }}
                                    <label class="switch">
                                        <input type="checkbox" name="parking">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Gym') }}
                                    <label class="switch">
                                        <input type="checkbox" name="gym">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                            </div>

                            <div class="hotel-filters-bottom">
                                <label>
                                    {{ __('messages.Pool') }}
                                    <label class="switch">
                                        <input type="checkbox" name="pool">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Refundable reservations') }}
                                    <label class="switch">
                                        <input type="checkbox" name="refundable_reservations">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Hotel restaurant') }}
                                    <label class="switch">
                                        <input type="checkbox" name="hotel_restaurant">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Bar') }}
                                    <label class="switch">
                                        <input type="checkbox" name="bar">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Drag and Drop Upload Section -->
                    <div class="search-field images">
                        <label for="hotel-images">{{ __('messages.Upload Hotel Images') }}</label>
                        <div x-data="dataFileDnD()" class="file-upload-area">
                            <div x-ref="dnd" class="drop-area" @click="$refs.fileInput.click()">
                                <input accept="*" type="file" multiple class="file-input"
                                    @change="addFiles($event)" @dragover="$refs.dnd.classList.add('dragging');"
                                    @dragleave="$refs.dnd.classList.remove('dragging');" style="display:none;"
                                    x-ref="fileInput" />

                                <div class="drag-message">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="message">{{ __('messages.Click here to add your files.') }}</p>
                                </div>
                            </div>

                            <template x-if="files.length > 0">
                                <div class="file-preview">
                                    <template x-for="(_, index) in Array.from({ length: files.length })">
                                        <div class="file-thumbnail" :class="{ 'dragging': fileDragging == index }"
                                            draggable="true" :data-index="index">
                                            <button class="remove-button" type="button" @click="remove(index)">
                                                <svg class="remove-icon" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <template x-if="files[index].type.includes('image/')">
                                                <img class="file-preview-img" x-bind:src="loadFile(files[index])" />
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="rooms-section">
                        <h3>{{ __('messages.Rooms') }}</h3>
                        <div id="room-container">
                            <!-- Room 1 (Preenchido inicialmente) -->
                            <div class="room-item">
                                <h4>{{ __('messages.Room 1') }}</h4>
                                <div class="search-field">
                                    <label for="room_type">{{ __('messages.Room Type') }}</label>
                                    <input type="text" name="rooms[0][type]" placeholder="{{ __('messages.Room Type') }}" required>
                                </div>
                                <div class="search-field">
                                    <label for="bed_type">{{ __('messages.Bed Type') }}</label>
                                    <input type="text" name="rooms[0][bed_type]" placeholder="{{ __('messages.Bed Type') }}" required>
                                </div>
                                <div class="search-field">
                                    <label for="bed_count">{{ __('messages.Bed Count') }}</label>
                                    <input type="number" name="rooms[0][bed_count]" placeholder="{{ __('messages.Number of Beds') }}"
                                        required>
                                </div>
                                <div class="search-field">
                                    <label for="price_night">{{ __('messages.Price per Night') }}</label>
                                    <input type="number" name="rooms[0][price_night]" placeholder="{{ __('messages.Price per Night') }}"
                                        required>
                                </div>
                                <div class="search-field">
                                    <label for="available">{{ __('messages.Available') }}</label>
                                    <label class="switch">
                                        <input type="checkbox" name="rooms[0][available]" checked>
                                        <span class="slider"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="add-room-btn">{{ __('messages.Add Another Room') }}</button>
                    </div>

                    <div class="add-button">
                        <button type="submit">{{ __('messages.Add Hotel') }}</button>
                    </div>
                </form>
            </div>



            <div id="add-tour" class="form-section" style="display: none;">
                <h2>{{ __('messages.Add New Tour') }}</h2>
                <form action="{{ route('auth.admin.addActivity', ['locale' => app()->getLocale()]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="search-field">
                        <label for="name">{{ __('messages.Tour Name') }}</label>
                        <input type="text" id="name" name="name" placeholder="{{ __('messages.Tour Name') }}" required>
                    </div>
                    <div class="search-field">
                        <label for="description">{{ __('messages.Description') }}</label>
                        <textarea id="description" name="description" placeholder="{{ __('messages.Description') }}" required></textarea>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="country">{{ __('messages.Country') }}</label>
                            <input type="text" id="country" name="country" placeholder="{{ __('messages.Country') }}" required>
                        </div>
                        <div class="search-field">
                            <label for="city">{{ __('messages.City') }}</label>
                            <input type="text" id="city" name="city" placeholder="{{ __('messages.City') }}" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="street">{{ __('messages.Street') }}</label>
                            <input type="text" id="street" name="street" placeholder="{{ __('messages.Street') }}" required>
                        </div>
                        <div class="search-field">
                            <label for="zip">{{ __('messages.ZIP Code') }}</label>
                            <input type="text" id="zip" name="zip_code" placeholder="{{ __('messages.ZIP Code') }}" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="price">{{ __('messages.Price') }}</label>
                            <input type="number" id="price" name="price_hour" placeholder="{{ __('messages.Price') }}" required>
                        </div>
                        <div class="search-field">
                            <label for="language">{{ __('messages.Language') }}</label>
                            <input type="text" id="language" name="language" placeholder="{{ __('messages.Language') }}" required>
                        </div>
                    </div>

                    <div class="flex-container bottom">
                        <div class="coordinates">
                            <div class="search-field">
                                <label for="coordinates">{{ __('messages.Coordinates') }}</label>
                                <input type="text" id="lat" name="lat" placeholder="{{ __('messages.Latitude') }}" required>
                                <input type="text" id="lon" name="lon" placeholder="{{ __('messages.Longitude') }}" required>
                            </div>
                        </div>
                        <div class="tour-filters">
                            <div class="search-field"><label for="filters">{{ __('messages.Filters') }}</label></div>
                            <label>
                                {{ __('messages.Cancel anytime') }}
                                <label class="switch">
                                    <input type="checkbox" id="cancel_anytime" name="cancel_anytime">
                                    <span class="slider"></span>
                                </label>
                            </label>
                            <label>
                                {{ __('messages.Reserve now pay later') }}
                                <label class="switch">
                                    <input type="checkbox" id="reserve_now_pay_later" name="reserve_now_pay_later">
                                    <span class="slider"></span>
                                </label>
                            </label>
                            <label>
                                {{ __('messages.Guide') }}
                                <label class="switch">
                                    <input type="checkbox" id="guide" name="guide">
                                    <span class="slider"></span>
                                </label>
                            </label>
                            <label>
                                {{ __('messages.Small Groups') }}
                                <label class="switch">
                                    <input type="checkbox" id="small_groups" name="small_groups">
                                    <span class="slider"></span>
                                </label>
                            </label>
                        </div>
                    </div>


                    <!-- Drag and Drop Upload Section -->
                    <div class="search-field images">
                        <label for="hotel-images">{{ __('messages.Upload Tour Images') }}</label>
                        <div x-data="dataFileDnD()" class="file-upload-area">
                            <div x-ref="dnd" class="drop-area" @click="$refs.fileInput.click()">
                                <!-- O campo de input é ativado ao clicar em qualquer lugar da área -->
                                <input accept="*" type="file" multiple class="file-input"
                                    @change="addFiles($event)" @dragover="$refs.dnd.classList.add('dragging');"
                                    @dragleave="$refs.dnd.classList.remove('dragging');" style="display:none;"
                                    x-ref="fileInput" />

                                <!-- Mensagem de drag-and-drop -->
                                <div class="drag-message">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="message">{{ __('messages.Click here to add your files.') }}</p>
                                </div>
                            </div>

                            <template x-if="files.length > 0">
                                <div class="file-preview">
                                    <template x-for="(_, index) in Array.from({ length: files.length })">
                                        <div class="file-thumbnail" :class="{ 'dragging': fileDragging == index }"
                                            draggable="true" :data-index="index">
                                            <button class="remove-button" type="button" @click="remove(index)">
                                                <svg class="remove-icon" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <template x-if="files[index].type.includes('image/')">
                                                <img class="file-preview-img" x-bind:src="loadFile(files[index])" />
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>


                    <div class="add-button">
                        <button type="submit">{{ __('messages.Add Tour') }}</button>
                    </div>
                </form>
            </div>

            <div id="delete-item" style="display: none;">

                <div id="hotels-section" class="form-section">
                    <h2>{{ __('messages.Delete Hotels') }}</h2>

                    <div class="table-container">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.Image') }}</th>
                                    <th>{{ __('messages.Name') }}</th>
                                    <th>{{ __('messages.Price') }}</th>
                                    <th>{{ __('messages.Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="hotels-table-body">
                                @foreach ($hotels as $hotel)
                                    <tr>
                                        <td>
                                            <img src="{{ $hotel->item->images[0]->url ?? asset('images/default-hotel.jpg') }}"
                                                alt="{{ $hotel->name }}">
                                        </td>
                                        <td>{{ $hotel->name }}</td>
                                        <td>
                                            @if ($hotel->rooms->isNotEmpty())
                                                {{ $hotel->rooms->first()->price_night }}€
                                            @else
                                                {{ __('messages.No rooms available') }}
                                            @endif
                                        </td>
                                        <td>
                                            <form
                                                action="{{ route('auth.admin.removeItem', ['locale' => app()->getLocale(), 'id' => $hotel->id_item]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="delete-button"
                                                    data-id="{{ $hotel->id_item }}">{{ __('messages.Delete') }}</button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div id="hotels-pagination" class="pagination">
                            {{ $hotels->links('vendor.pagination.custom') }}
                        </div>
                    </div>

                    <div id="tours-section" class="form-section">
                        <h2>{{ __('messages.Delete Tours') }}</h2>
                        <div class="table-container">
                            <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('messages.Image') }}</th>
                                        <th>{{ __('messages.Name') }}</th>
                                        <th>{{ __('messages.Price') }}</th>
                                        <th>{{ __('messages.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="tours-table-body">
                                    @foreach ($tours as $tour)
                                        <tr>
                                            <td>
                                                <img src="{{ $tour->item->images[0]->url ?? asset('images/default-tour.jpg') }}"
                                                    alt="{{ $tour->name }}">
                                            </td>
                                            <td>{{ $tour->name }}</td>
                                            <td>
                                                {{ $tour->price_hour }}{{ __('messages.€/hour') }}
                                            </td>
                                            <td>
                                                <form
                                                    action="{{ route('auth.admin.removeItem', ['id' => $tour->id_item, 'locale' => app()->getLocale()]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="delete-button"
                                                        data-id="{{ $tour->id_item }}">{{ __('messages.Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div id="tours-pagination" class="pagination">
                                {{ $tours->links('vendor.pagination.custom') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div id="list-admins">
                <div id="admins" class="form-section">
                    <h2>{{ __('messages.Admins') }}</h2>
                    <div class="table-container">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.Image') }}</th>
                                    <th>{{ __('messages.Name') }}</th>
                                    <th>{{ __('messages.Username') }}</th>
                                    <th>{{ __('messages.Email') }}</th>
                                    <th>{{ __('messages.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $admin)
                                    <tr>
                                        <td class="user-image">
                                            <div class="image-container">
                                                <img src="{{ file_exists(public_path('storage/' . $admin->image)) ? asset('storage/' . $admin->image) : asset('images/default_user_image.png') }}"
                                                    alt="{{ $admin->first_name }}">
                                            </div>
                                        </td>
                                        <td>{{ $admin->first_name }} {{ $admin->last_name }}</td>
                                        <td>{{ $admin->username }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ __('messages.Admin') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="users" class="form-section">
                    <h2>{{ __('messages.Users') }}</h2>
                    <div class="table-container">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.Image') }}</th>
                                    <th>{{ __('messages.Name') }}</th>
                                    <th>{{ __('messages.Username') }}</th>
                                    <th>{{ __('messages.Email') }}</th>
                                    <th>{{ __('messages.Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="user-image">
                                            <div class="image-container">
                                                <img src="{{ file_exists(public_path('storage/' . $user->image)) ? asset('storage/' . $user->image) : asset('images/default_user_image.png') }}"
                                                    alt="{{ $user->first_name }}">
                                            </div>
                                        </td>
                                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <form
                                                action="{{ route('auth.admin.promoteToAdmin', ['id' => $user->id, 'locale' => app()->getLocale()]) }}"
                                                method="POST" id="promote-form-{{ $user->id }}">
                                                @csrf
                                                <button type="submit" class="btn btn-primary"
                                                    id="promote-button-{{ $user->id }}">Promote</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Train/Bus Tickets Section -->
    @if (session('popup'))
        {!! session('popup') !!}
    @endif
    <x-footer />

    <script>
	const appUrl = "{{ config('app.url') }}";

        function dataFileDnD() {
            return {
                files: [],
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size) {
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " + ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove(index) {
                    let files = [...this.files];
                    files.splice(index, 1);

                    this.files = createFileList(files);
                },
                drop(e) {
                    let removed, add;
                    let files = [...this.files];

                    removed = files.splice(this.fileDragging, 1);
                    files.splice(this.fileDropping, 0, ...removed);

                    this.files = createFileList(files);

                    this.fileDropping = null;
                    this.fileDragging = null;
                },
                dragenter(e) {
                    let targetElem = e.target.closest("[draggable]");

                    this.fileDropping = targetElem.getAttribute("data-index");
                },
                dragstart(e) {
                    this.fileDragging = e.target
                        .closest("[draggable]")
                        .getAttribute("data-index");
                    e.dataTransfer.effectAllowed = "move";
                },
                loadFile(file) {
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);

                    preview.forEach(elem => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // free memory
                        };
                    });

                    return blobUrl;
                },
                addFiles(e) {
                    const files = createFileList([...this.files], [...e.target.files]);
                    this.files = files;
                    this.formData = new FormData();

                    for (let i = 0; i < this.files.length; i++) {
                        this.formData.append("files[]", this.files[i]);
                    }
                }
            };
        }

        let roomIndex = 1;
        document.getElementById('add-room-btn').addEventListener('click', function() {
            const roomContainer = document.getElementById('room-container');
            const newRoom = document.createElement('div');
            newRoom.classList.add('room-item');
            newRoom.innerHTML = `
        <h4>Room ${roomIndex + 1}</h4>
        <div class="search-field">
            <label for="room_type">{{ __('messages.Room Type') }}</label>
            <input type="text" name="rooms[${roomIndex}][type]" placeholder="{{ __('messages.Room Type') }}" required>
        </div>
        <div class="search-field">
            <label for="bed_type">{{ __('messages.Bed Type') }}</label>
            <input type="text" name="rooms[${roomIndex}][bed_type]" placeholder="{{ __('messages.Bed Type') }}" required>
        </div>
        <div class="search-field">
            <label for="bed_count">{{ __('messages.Bed Count') }}</label>
            <input type="number" name="rooms[${roomIndex}][bed_count]" placeholder="{{ __('messages.Number of Beds') }}" required>
        </div>
        <div class="search-field">
            <label for="price_night">{{ __('messages.Price per Night') }}</label>
            <input type="number" name="rooms[${roomIndex}][price_night]" placeholder="{{ __('messages.Price per Night') }}" required>
        </div>
        <div class="search-field">
            <label for="available">{{ __('messages.Available') }}</label>
            <label class="switch">
                <input type="checkbox" name="rooms[${roomIndex}][available]" checked>
                <span class="slider"></span>
            </label>
        </div>
    `;
            roomContainer.appendChild(newRoom);
            roomIndex++;
        });
    </script>

</body>

</html>
