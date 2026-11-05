<style>
    #signup{
      margin-top: -2%;
      margin-left: 2%;
    }
  </style>
  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>{{ config('clinic.product_name') }}</title>
      {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"> --}}
      {{-- <link rel="stylesheet" href="https://classless.de/classless.css"> --}}
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </head>
  <body>
  <title>SignUp</title>
  <div class="container">
      <form class="px-4 py-3" method="POST" action="{{ route('register.check')}}">   
        @csrf
        @method('POST')   
        <div class="form-group">
          <label for="exampleDropdownFormEmail1">Name</label>
          <input type="text" class="form-control" id="exampleDropdownFormEmail1" placeholder="Enter your name" name="name">
        </div>
        <div class="form-group">
          <label for="exampleDropdownFormPassword1">Password</label>
          <input type="password" class="form-control" id="exampleDropdownFormPassword1" placeholder="Password" name="password">
        </div>
        <div class="form-check">
          <input type="checkbox" class="form-check-input" id="dropdownCheck">
          <label class="form-check-label" for="dropdownCheck">
            Remember me
          </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
      </form>
     {{-- <div>
      <button type="button" class="btn btn-primary" id="signup" onclick="location.href='{{route('register.signup') }}'">Sign Up</button>
     </div> --}}
    </div>
  </body>
  </html>