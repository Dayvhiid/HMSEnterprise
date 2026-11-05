<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&display=swap">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
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
        
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        
        label {
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
        }
        
        input[type="text"], input[type="file"] {
            width: 100%;
            height: 40px;
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        
        input[type="file"] {
            padding: 10px 0;
        }
        
        button[type="submit"] {
            width: 100%;
            height: 40px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        button[type="submit"]:hover {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
@include('partials.session-bar')
    <div class="container">
        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="title">Enter Patient ID:</label>
            <input type="text" name="title" id="title" required><br><br>

            <label for="image">Choose an image:</label>
            <input type="file" name="image" id="image" required><br><br>

            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>