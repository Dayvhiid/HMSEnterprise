
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <title>Document</title>
</head>
<body>
    <div class="container">
      <div class="flex">
        <div>
          <h1 class="font-weight-bold">Generate Invoice</h1>
        </div>
        <div class="search">
          <form action="{{route('invoice.search')}}" type="get">
            <div class="input-group input-group-sm mb-3">
              {{-- <span class="input-group-text" id="inputGroup-sizing-sm">Search Invoice</span> --}}
              <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" placeholder="Enter name to search for invoice" name="query">
              <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
          </form>
        </div>
      </div>
      
        {{-- <a href="{{route('invoice.find')}}">Find Invoice</a> --}}
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <p class="mb-1 fw-bold">The invoice was not saved. Please fix the following and click Generate Invoice again:</p>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{route('invoice.save')}}" method="POST">
            @csrf
            @method('POST')
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Enter Patient Name" aria-label="Recipient's username" aria-describedby="basic-addon2" name="pid" value="{{ old('pid') }}">
                <td><input type="number" name="discount" placeholder="Enter Percentage discounts" class="form-control" value="{{ old('discount') }}" required></td>
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="submit">Generate Invoice</button>
                </div>
            </div>
            <table class="table table-bordered" id="table">
                <tr>
                    <th>Item  Name</th>
                    <th>Price</th>
                    <th>QTY</th>
                    <th>Action</th>
                </tr>

                {{-- <tr>
                    <td><input type="text" name="inputs[0][name]" class="form-control" placeholder="Enter Drug Name"></td>
                    <td><input type="text" name="inputs[0][price]" placeholder="Enter Drug Price" class="form-control"></td>
                    <td><input type="number" name="inputs[0][qty]" placeholder="Enter Quantity" class="form-control"></td>
                    
                    <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                </tr> --}}
                @php($oldInputs = array_values(old('inputs', [[]])) ?: [[]])
                @foreach ($oldInputs as $i => $row)
                <tr>
                    <td><input type="text" name="inputs[{{ $i }}][name]" class="form-control item-name" placeholder="Select Drug / Lens / Frame" value="{{ $row['name'] ?? '' }}"></td>
                    <td><input type="text" name="inputs[{{ $i }}][price]" class="form-control item-price" placeholder="Price" value="{{ $row['price'] ?? '' }}" readonly></td>
                    <td><input type="number" name="inputs[{{ $i }}][qty]" class="form-control item-qty" placeholder="Quantity" min="1" value="{{ $row['qty'] ?? '' }}"></td>
                    @if ($i === 0)
                    <td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td>
                    @else
                    <td><button type="button" class="btn btn-danger remove-table-row">Remove</button></td>
                    @endif
                 </tr>
                @endforeach
            </table>

            {{-- <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email or phone number" name="contact">
              <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-group form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button> --}}
        </form>
    </div>

    <script>

      let itemsData = [];

function enableAutocomplete(input) {
  $(input).autocomplete({
    source: itemsData,
    minLength: 1,
    select: function(event, ui) {
      // ui.item has selected item info
      const row = $(this).closest('tr');
      row.find('.item-name').val(ui.item.label); // show full label (name + type)
      row.find('.item-price').val(ui.item.price);
      row.find('.item-qty').attr('max', ui.item.quantity); // optional: limit max quantity to available stock
      // you can store hidden fields for item id/type if you want later for backend use
      // e.g. $('<input>').attr({type: 'hidden', name: `inputs[${index}][item_id]`, value: ui.item.id}).appendTo(row);
      return false; // prevent default to set only label
    }
  });
}

async function loadItems() {
  try {
    const res = await fetch('/items');
    if (!res.ok) throw new Error('Failed to fetch items');
    itemsData = await res.json();
    // Initialize autocomplete on existing inputs
    $('.item-name').each(function() {
      enableAutocomplete(this);
    });
  } catch (err) {
    alert('Failed to load items for autocomplete');
    console.error(err);
  }
}

loadItems();

// Continue numbering after any rows restored from a failed submit.
var rowCounter = {{ count($oldInputs) - 1 }};

$('#add').click(function() {
  rowCounter++;
  var newRow = $('<tr>');

  newRow.append($('<td>').append($('<input>', {
    type: 'text',
    name: `inputs[${rowCounter}][name]`,
    placeholder: 'Select Drug / Lens / Frame',
    class: 'form-control item-name'
  })));

  newRow.append($('<td>').append($('<input>', {
    type: 'text',
    name: `inputs[${rowCounter}][price]`,
    placeholder: 'Price',
    class: 'form-control item-price',
    readonly: true
  })));

  newRow.append($('<td>').append($('<input>', {
    type: 'number',
    name: `inputs[${rowCounter}][qty]`,
    placeholder: 'Quantity',
    class: 'form-control item-qty',
    min: 1
  })));

  newRow.append($('<td>').append($('<button>', {
    type: 'button',
    class: 'btn btn-danger remove-table-row',
    text: 'Remove'
  })));

  newRow.appendTo('#table');

  // Enable autocomplete on newly added input
  enableAutocomplete(newRow.find('.item-name'));
});

$(document).on('click', '.remove-table-row', function() {
  $(this).closest('tr').remove();
});

  //   </script>

  
  //   <script>
 