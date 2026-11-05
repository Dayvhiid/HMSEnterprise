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
        {{-- <nav class="navbar navbar-light bg-light">
            <form class="form-inline">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </nav> --}}
        <form action="">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">SN</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">ID</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($lens as $len)
                  <tr>
                    {{-- <th scope="row">1</th> --}}
                    <td> <input type="text" class="form-control" name="name" value="{{$len->id}}" readonly></td>
                    <td> <input type="text" class="form-control" name="price" value="{{$len->name}}" readonly></td>
                    <td> <input type="text" class="form-control" name="price" value="{{$len->price}}" readonly></td>
                    <td> <input type="text" class="form-control" name="price" value="{{$len->special_code}}" readonly></td>
                    <td> <input type="text" class="form-control" name="quantity" value="{{$len->quantity}}" readonly></td>
                    <td> <a href="{{route('lens.edit', ['len' => $len])}}">Edit</a></td>
                    <td>
                      <form action="{{route('lens.delete', ['len' => $len ])}}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">Delete</button>
                      </form>
                    </td>
                  </tr>
                  @endforeach
                  {{ $lens->links('pagination::bootstrap-4') }}
              </table>
        </form>
    </div>
</body>
</html>