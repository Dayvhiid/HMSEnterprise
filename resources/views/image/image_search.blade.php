<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Image</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        
        .container {
            max-width: 400px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }
        
        input[type="text"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        button[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #34C759; /* green */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #FFC107; /* orange */
        }
        
        .error {
            color: #FFA07A; /* yellow */
            font-weight: 600;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
@include('partials.session-bar')
    <div class="container">
        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif
        
        <form action="{{ route('images.search.result') }}" method="POST">
            @csrf
            <label for="name">Enter Patient ID:</label>
            <input type="text" name="name" id="name" required><br><br>

            <button type="submit">Search</button>
        </form>
    </div>
</body>
</html>