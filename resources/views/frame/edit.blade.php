<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('clinic.product_name') }}</title>
    <link rel="stylesheet" href="https://classless.de/classless.css">
</head>
<body>
@include('partials.session-bar', ['showErrors' => false])
    @if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
    @endif
    <h1>Update Frame</h1>
    <form method="post" action="{{route('frame.update', ['frames' => $frames])}}">
        @csrf
        @method('PUT')
       <div>
          <label>Name: </label>
          <input type="text" name="name" placeholder="Enter your name" value="{{$frames->name}}">
       </div>
       <div>
          <label>Price: </label>
          <input type="text" name="price" placeholder="Enter the quantity" value="{{$frames->price}}">
       </div>
       <div>
        <label>Type: </label>
        <input type="text" placeholder="Enter the price" value="{{$frames->special_code}}" readonly>
     </div>
     <div>
        <label>Quantity: </label>
        <input type="text" name="quantity" placeholder="Enter the quantity" value="{{$frames->quantity}}">
     </div>
     <div>
        <input type="submit" value="SUBMIT">
     </div>
    </form>
</body>
</html>