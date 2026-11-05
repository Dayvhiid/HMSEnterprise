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
  <div>
    <form action="{{ route('inventory.store')}}" method="POST">
        @csrf
        @method('POST')
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <p>{{ Session::get('success')}}</p>
            </div>
        @endif
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#"></a>
          {{-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button> --}}
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="{{route('admin2.inventory')}}">Inventory List</a> 
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('admin2.drugs')}}" >Drug</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('admin2.frame')}} ">Frames</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="{{route('admin2.lens')}} ">Lens</a>
              </li>
            </ul>
          </div>
        </nav>
        <table class="table table-bordered" id="table">
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>New Stock</th>
                <th>Name</th>
                <th>Patient Code</th>
                <th>Receipt Number</th>
                <th>Qty In</th>
                <th>Qty Out</th>
                <th>Balance</th>
                <th>Action</th>
            </tr>

            <tr>
                <td><input type="text" name="inputs[0][sn]" placeholder="Enter SN" class="form-control"></td>
                <td><input type="date" name="inputs[0][date]" class="form-control"></td>
                <td><input type="text" name="inputs[0][new_stock]" placeholder="Enter New Stock" class="form-control"></td>
                <td><input type="text" name="inputs[0][name]" placeholder="Enter Name" class="form-control"></td>
                <td><input type="text" name="inputs[0][patient_code]" placeholder="Enter Patient Code" class="form-control"></td>
                <td><input type="text" name="inputs[0][booklet_no]" placeholder="Enter Receipt Number" class="form-control"></td>
                <td><input type="number" name="inputs[0][qty_in]" placeholder="Enter Qty In" class="form-control"></td>
                <td><input type="number" name="inputs[0][qty_out]" placeholder="Enter Qty Out" class="form-control"></td>
                <td><input type="number" name="inputs[0][balance]" placeholder="Enter Balance" class="form-control"></td>
                <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
            </tr>
        </table>

        <button type="submit" class="btn btn-primary col-md-2">Save</button>
    </form>
</div>

<script>
  var rowCounter = 0;

  $('#add').click(function() {
    rowCounter++;

    var newRow = $('<tr>'); // Create the new row element

    // Add cells with input fields for each data point
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][sn]',
      placeholder: 'Enter SN',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'date',
      name: 'inputs[' + rowCounter + '][date]',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][new_stock]',
      placeholder: 'Enter New Stock',
      class: 'form-control'
    })));
    // Add similar code for remaining fields (name, patient code, etc.)
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][name]',
      placeholder: 'Enter Your Name',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][patient_code]',
      placeholder: 'Patient Code',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][booklet_no]',
      placeholder: 'Book reciept Number',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][qty_in]',
      placeholder: 'ENTER QTY IN',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][qty_out]',
      placeholder: 'ENTER QTY OUT',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][balance]',
      placeholder: 'ENTER BALANCE',
      class: 'form-control'
    })));
    newRow.append($('<td>').append($('<button>', {
      type: 'button',
      class: 'btn btn-danger remove-table-row',
      text: 'Remove'
    })));


    newRow.appendTo('#table'); // Add the new row to the table
  });

  // console.log('pressed');

  $(document).on('click', '.remove-table-row', function() {
    $(this).closest('tr').remove();
  });
</script>

</body>
</html>