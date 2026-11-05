<style>
    .select-wrapper {
      position: relative;
    }
    .select-styled {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      cursor: pointer;
    }
    .select-styled:after {
      content: "";
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      width: 0;
      height: 0;
      border-left: 5px solid transparent;
      border-right: 5px solid transparent;
      border-bottom: 8px solid #ccc;
    }
    .select-options {
      display: none;
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background-color: #fff;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .select-options.active {
      display: block;
    }
    /* Option Styling */
    .select-options li {
      padding: 10px;
      /* Add hover effect for better UX */
      transition: background-color 0.2s ease;
    }
    .select-options li:hover {
      background-color: #f1f1f1;
    }
    .select-options li:last-child {
      border-bottom: none;
    }
    ul li{
      list-style: none;
    }
    a{
      text-decoration: none;
    }
</style>
</style>
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
    <form action="{{route('doctors.store')}}" method="POST">
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
        <ul>
          <li><a href="{{ route('admin2.druglist') }}">Drug List</a></li>
        </ul>
            <table class="table table-bordered" id="table">
                <tr>
                    <th>SN</th>
                    <th>Drug  Name</th>
                    <th>Price</th>
                    <th>ID</th>
                    <th>Quantity</th>
                    <th>Drug Type</th>
                    <th>Action</th>
                </tr>

                <tr>
                    <td><input type="text" name="inputs[0][sn]" placeholder="Enter SN" class="form-control"></td>
                    <td><input type="text" name="inputs[0][name]" class="form-control" placeholder="Enter Drug Name"></td>
                    <td><input type="text" name="inputs[0][price]" placeholder="Enter Drug Price" class="form-control"></td>
                    <td><input type="text" name="inputs[0][special_code]" placeholder="Enter Unique Code" class="form-control"></td>
                    <td><input type="text" name="inputs[0][quantity]" placeholder="Quantity" class="form-control"></td>
                    <td>
                     <div class="select-wrapper">
                      <select class="select-styled" name="inputs[0][drug_type]">
                        <option value="">Select an Option</option>
                        <option value="eye_drop">Eye Drop</option>
                        <option value="tablet">Tablet</option>
                      </select>
                     </div>                   
                    </td>
                    <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                </tr>
            </table>
            <button type="submit" class="btn btn-primary col-md-2">Save</button>
    </form>      

   

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
            type: 'text',
            name: 'inputs[' + rowCounter + '][name]',
            placeholder: 'Enter Drug Name',
            class: 'form-control'
          })));
          newRow.append($('<td>').append($('<input>', {
            type: 'text',
            name: 'inputs[' + rowCounter + '][price]',
            placeholder: 'Enter Drug Price',
            class: 'form-control'
          })));
          // Add similar code for remaining fields (name, patient code, etc.)
          newRow.append($('<td>').append($('<input>', {
            type: 'text',
            name: 'inputs[' + rowCounter + '][special_code]',
            placeholder: 'Enter Unique Code',
            class: 'form-control'
          })));
          newRow.append($('<td>').append($('<input>', {
            type: 'text',
            name: 'inputs[' + rowCounter + '][quantity]',
            placeholder: 'Quantity',
            class: 'form-control'
          })));
          newRow.append($('<td>').append($('<select>', {
  class: 'select-styled',
  name: 'inputs[' + rowCounter + '][drug_type]'  // Assuming 'type' for option selection
}).append($('<option>', {
  value: '',
  text: 'Select an Option'
})).append($('<option>', {
  value: 'eye_drop',
  text: 'Eye Drop'
})).append($('<option>', {
  value: 'tablet',
  text: 'Tablet'
}))));
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