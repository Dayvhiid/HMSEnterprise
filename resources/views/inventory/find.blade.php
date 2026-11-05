<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <title>{{ config('clinic.product_name') }}</title>
</head>
<body>
@include('partials.session-bar')
    <div class="container">
      @if(session()->has('success'))
      <div>
        {{ session('success')}}
      </div>
    @endif
        <form action="{{route('inventory.find', ['drugs' => $drugs])}}" type="get">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="query">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Type</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
               @foreach($drugs as $drug)
               <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td><input type="text" class="form-control" name="name" value="{{$drug->name}}"></td>
                  <td><input type="text" class="form-control" name="price" value="{{$drug->price}}"></td>
                  <td><input type="text" class="form-control" name="drug_type" value="{{$drug->drug_type}}"></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
               @endforeach
              </table>              
        </form>
        <form action="{{route('invoice.save')}}"  method="POST" >
          @csrf
          @method('POST')
          <div class="container">
                <label>Generate Invoice</label>
          </div>
        </form>
    </div>
    
    
</body>
</html>