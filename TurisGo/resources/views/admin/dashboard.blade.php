<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
    @vite(['resources/css/dashboard.css', 'resources/css/pagination.css', 'resources/js/jquery-3.7.1.min.js', 'resources/js/dashboard.js'])
</head>
<body>
    <x-header/>
    
    <!-- Header Section -->
    <section class="header">
        <h1>{{ __('messages.Dashboard') }}</h1>
        <p>{{ __('messages.Explore, update, and enhance the TurisGo experience.') }}</p>
    </section>

    <div class="dashboard">
        <div class="left-dashboard-options">
            <h2 class="dashboard-title">
                <div class="icon">
                    <img src="{{ asset('images/dashboard_icon_orange.png') }}" alt="dashboard">
                </div>
                Dashboard
            </h2>
            <div class="left-dashboard">
                <ul>
                    <li><a href="#" id="add-hotel-link"><img src="{{ asset('images/addHotel_icon.png') }} " alt="Add Hotel">Add Hotel</a></li>
                    <li><a href="#" id="add-tour-link"><img src="{{ asset('images/addTour_icon.png') }} " alt="Add Tour">Add Tour</a></li>
                    <li><a href="#" id="edit-item-link"><img src="{{ asset('images/editItem_icon.png') }} " alt="Edit Item">Edit Item</a></li>
                    <li><a href="#" id="delete-item-link"><img src="{{ asset('images/deleteItem_icon.png') }} " alt="Delete Item">Delete Item</a></li>
                    <li><a href="#" id="admin-link"><img src="{{ asset('images/admin_icon.png') }} " alt="Manage Admins">List Admins</a></li>
                </ul>
            </div>
        </div>

        <div class="right-dashboard">
            <div id="add-hotel" class="form-section" style="display: none;">
                <h2>Add New Hotel</h2>
                <form action="#" method="POST">
                    <div class="search-field">
                        <label for="name">Hotel Name</label>
                        <input type="text" placeholder="Hotel Name" required>
                    </div>
                    <div class="search-field">
                        <label for="description">Description</label>
                        <textarea placeholder="Description" required></textarea>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Country">Country</label>
                            <input type="text" placeholder="Country" required>
                        </div>
                        <div class="search-field">
                            <label for="City">City</label>
                            <input type="text" placeholder="City" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Street">Street</label>
                            <input type="text" placeholder="Street" required>
                        </div>
                        <div class="search-field">
                            <label for="zip">Zip-Code</label>
                            <input type="text" placeholder="zip" required>
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
                            </select>
                        </div>
                        <div class="search-field">
                            <label for="Price">Price</label>
                            <input type="number" placeholder="Price" required>
                        </div>
                    </div>
                    <div class="search-field">
                        <label for="rating">Guest Rating</label>
                        <input type="number" id="rating" name="rating" min="1" max="5" step="0.5" placeholder="Guest Rating" required>
                    </div>

                    <div class="flex-container bottom">
                        <div class="coordinates">
                            <div class="search-field">
                                <label for="coordinates">Coordinates</label>
                                <input type="text" id="lat" name="lat"placeholder="Lat" required>
                                <input type="text" id="lon" name="lon"placeholder="Lon" required>
                            </div>
                        </div>
                        <div class="hotel-filters">
                            <div class="search-field"><label for="Filters">Filters</label></div>

                            <div class="hotel-filters-top">
                                <label>
                                {{ __('messages.Breakfast included') }}
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                                </label>
                                <label>
                                    {{ __('messages.Free Wi-Fi') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Parking') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Gym') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                            </div>
                        
                            <div class="hotel-filters-bottom">
                                <label>
                                    {{ __('messages.Pool') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Refundable reservations') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Hotel restaurant') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('messages.Bar') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Drag and Drop Upload Section -->
                    <div class="search-field images">
                        <label for="hotel-images">Upload Hotel Images</label>
                        <div x-data="dataFileDnD()" class="file-upload-area">
                            <div x-ref="dnd" class="drop-area" @click="$refs.fileInput.click()">
                                <!-- O campo de input é ativado ao clicar em qualquer lugar da área -->
                                <input accept="*" type="file" multiple class="file-input" @change="addFiles($event)" 
                                    @dragover="$refs.dnd.classList.add('dragging');" 
                                    @dragleave="$refs.dnd.classList.remove('dragging');" style="display:none;" x-ref="fileInput" />

                                <!-- Mensagem de drag-and-drop -->
                                <div class="drag-message">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="message">Click here or drag your files.</p>
                                </div>
                            </div>
                            
                            <template x-if="files.length > 0">
                                <div class="file-preview">
                                    <template x-for="(_, index) in Array.from({ length: files.length })">
                                        <div class="file-thumbnail" :class="{'dragging': fileDragging == index}" draggable="true" :data-index="index">
                                            <button class="remove-button" type="button" @click="remove(index)">
                                                <svg class="remove-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <button type="submit">Add Hotel</button>
                    </div>
                </form>
            </div>


            <div id="add-tour" class="form-section" style="display: none;">
                <h2>Add New Tour</h2>
                <form action="#" method="POST">
                    <div class="search-field">
                        <label for="name">Tour Name</label>
                        <input type="text" placeholder="Tour Name" required>
                    </div>
                    <div class="search-field">
                        <label for="description">Description</label>
                        <textarea placeholder="Description" required></textarea>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Country">Country</label>
                            <input type="text" placeholder="Country" required>
                        </div>
                        <div class="search-field">
                            <label for="City">City</label>
                            <input type="text" placeholder="City" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Street">Street</label>
                            <input type="text" placeholder="Street" required>
                        </div>
                        <div class="search-field">
                            <label for="zip">Zip-Code</label>
                            <input type="text" placeholder="zip" required>
                        </div>
                    </div>
                    <div class="flex-container">
                        <div class="search-field">
                            <label for="Price">Price</label>
                            <input type="number" placeholder="Price" required>
                        </div>
                        <div class="search-field">
                            <label for="Language">Language</label>
                            <input type="text" placeholder="Language" required>
                        </div>
                    </div>

                    <div class="flex-container bottom">
                        <div class="coordinates">
                            <div class="search-field">
                                <label for="coordinates">Coordinates</label>
                                <input type="text" id="lat" name="lat"placeholder="Lat" required>
                                <input type="text" id="lon" name="lon"placeholder="Lon" required>
                            </div>
                        </div>
                        <div class="tour-filters">
                            <div class="search-field"><label for="Filters">Filters</label></div>
                                <label>
                                {{ __('Cancel anytime') }}
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                                </label>
                                <label>
                                    {{ __('Reserve now pay later') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('Guide') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                                <label>
                                    {{ __('Small Groups') }}
                                    <label class="switch">
                                        <input type="checkbox">
                                        <span class="slider"></span>
                                    </label>
                                </label>
                        </div>
                    </div>

                    <!-- Drag and Drop Upload Section -->
                    <div class="search-field images">
                        <label for="hotel-images">Upload Tour Images</label>
                        <div x-data="dataFileDnD()" class="file-upload-area">
                            <div x-ref="dnd" class="drop-area" @click="$refs.fileInput.click()">
                                <!-- O campo de input é ativado ao clicar em qualquer lugar da área -->
                                <input accept="*" type="file" multiple class="file-input" @change="addFiles($event)" 
                                    @dragover="$refs.dnd.classList.add('dragging');" 
                                    @dragleave="$refs.dnd.classList.remove('dragging');" style="display:none;" x-ref="fileInput" />

                                <!-- Mensagem de drag-and-drop -->
                                <div class="drag-message">
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p class="message">Click here or drag your files.</p>
                                </div>
                            </div>
                            
                            <template x-if="files.length > 0">
                                <div class="file-preview">
                                    <template x-for="(_, index) in Array.from({ length: files.length })">
                                        <div class="file-thumbnail" :class="{'dragging': fileDragging == index}" draggable="true" :data-index="index">
                                            <button class="remove-button" type="button" @click="remove(index)">
                                                <svg class="remove-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
                        <button type="submit">Add Tour</button>
                    </div>
                </form>
            </div>
            
            <div id="delete-item">

                <div id="hotels-section" class="form-section">
                    <h2>Delete Items</h2>

                    <div class="table-container">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Actions</th>
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
                                    <form>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button">Delete</button>
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
                    <h2>Delete Tours</h2>
                    <div class="table-container">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Actions</th>
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
                                        {{ $tour->price_hour }}€/hour
                                    </td>
                                    <td>
                                        <form>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="delete-button">Delete</button>
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
        </div>
    </div>

    <x-footer/>

    <script>
    function dataFileDnD() {
        return {
            files: [],
            fileDragging: null,
            fileDropping: null,
            humanFileSize(size) {
                const i = Math.floor(Math.log(size) / Math.log(1024));
                return (
                    (size / Math.pow(1024, i)).toFixed(2) * 1 +
                    " " +
                    ["B", "kB", "MB", "GB", "TB"][i]
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
    </script>

</body>
</html>