<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>{{ config('clinic.product_name') }}</title>
</head>
<body>
  @if($errors->any())
  <ul>
      @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
      @endforeach
  </ul>
  @endif
  <div class="container">
    <form  action="{{route('pages.update', ['record' => $data])}}" method="POST">
      @csrf
      @method('PUT')
      <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">First Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputEmail" value="{{ $data->first_name }}" name="first_name">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Last Name</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->last_name }}" name="last_name">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Gender</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->gender }}" name="gender">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Phone</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->phone }}" name="phone">
        </div>
      </div>
      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->email }}" name="email">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Street</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->street }}" name="street">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">State</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->state }}" name="state">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Occupation</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->occupation }}" name="occupation">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Emergency Contact</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->emergency_phone }}" name="emergency_phone">
        </div>
      </div>

      <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">PatientID</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="inputPassword3" value="{{ $data->patient_id }}" name="pid">
        </div>
      </div>
      
      {{-- <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-success">Save</button>
        </div>
      </div> --}}

      
      <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </div>

    </form>
    <form action="{{route('pages.delete', ['record' => $data] )}}" method="post">
      @csrf
      @method('delete')
      <div class="form-group row">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </form>
  </div>
</body>
</html>