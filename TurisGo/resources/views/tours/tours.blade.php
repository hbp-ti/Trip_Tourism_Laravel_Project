<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TurisGo</title>
    @vite(['resources/css/tours.css', 'resources/js/jquery-3.7.1.min.js'])
</head>

<body>
    <x-header />
    <!-- Header Section -->
    <section class="header">
        <h1>Tours</h1>
        <p>Explore Our Tours & Activities</p>
    </section>
    <!-- About Us Section -->

    <div class="title-line-container tours-section">
        <h2>Exclusive tour packages</h2>
        <hr class="title-line-orange">
    </div>

    <div class="title-line-container tours-section">
        <h2>Tours</h2>
        <hr class="title-line-blue">
    </div>

    <div class="title-line-container tours-section">
        <h2>Activities</h2>
        <hr class="title-line-orange-big">
    </div>

    <x-footer/>
</body>

</html>