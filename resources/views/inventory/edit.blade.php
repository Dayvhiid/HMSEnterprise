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
    <h1>Update Drug</h1>
    <form method="post" action="{{route('doctors.update', ['drugs' => $drug])}}">
        @csrf
        @method('PUT')
       <div>
          <label>Name: </label>
          <input type="text" name="name" placeholder="Enter your name" value="{{$drug->name}}">
       </div>
       <div>
          <label>Price: </label>
          <input type="text" name="price" placeholder="Enter the quantity" value="{{$drug->price}}">
       </div>
       <div>
        <label>Type: </label>
        <input type="text" placeholder="Enter the price" value="{{$drug->drug_type}}" readonly>
     </div>
     <div>
        <label>Quantity: </label>
        <input type="text" placeholder="Enter the price" value="{{$drug->quantity}}" readonly>
     </div>
     {{-- <div>
        <label>Description: </label>
        <input type="text" name="description" placeholder="Enter the description" value="{{$product->description}}">
     </div> --}}
     <div>
        <input type="submit" value="SUBMIT">
     </div>
    </form>
</body>
</html>