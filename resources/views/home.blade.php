<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @include('toast')

    <br>
    <br>
    <center>
        <h1> Car Listing Items </h1>
    </center>

    <div class="container mt-4">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @if($carListings->isEmpty())
            <div class="text-center">
                <p>No car listings available.</p>
            </div>
            @else
            @foreach($carListings as $carListing)
            <div class="col">
                <div class="card h-100">
                    <img src="{{ asset($carListing['listing_img1']) }}" class="card-img-top" alt="Car Image">
                    <div class="card-body">
                        <h5 class="card-title">{{ $carListing['listing_title'] }}</h5>
                        <p class="card-text">{{ $carListing['listing_desc'] }}</p>

                        <!-- Additional Details -->
                        <ul class="list-unstyled">
                            <li>Year: {{ $carListing['listing_year'] }}</li>
                            <li>Price: {{ $carListing['listing_price'] }}</li>
                            <li>Features: {{ $carListing['features_gear'] }}, {{ $carListing['features_speed'] }}, ...
                            </li>
                            <!-- Add other details as needed -->
                        </ul>
                    </div>

                    <!-- Delete Button -->
                    <div class="card-footer">
                        <form action="{{ route('car.delete', ['id' => $carListing['id']]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <!-- <form action="{{ route('car.delete', ['id' => $carListing['id']]) }}" method="POST">
        csrf
        method('DELETE')
        <button type="submit">Delete</button>
    </form> -->
</body>

</html>