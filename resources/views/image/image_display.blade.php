<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            color: #34C759;
            text-align: center;
        }

        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
            background-color: #FFC107;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .image-container:hover {
            background-color: #FFA07A;
        }

        .image-item {
            text-align: center;
        }

        .image-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
@include('partials.session-bar')
    <div class="container">
        {{-- <h2>Image Gallery</h2> --}}
        <div class="image-container">
            @foreach($images as $image)
                <div class="image-item">
                    <h3>{{ $image->title }}</h3>
                    <img src="{{ route('images.file', $image) }}" alt="{{ $image->title }}">
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
