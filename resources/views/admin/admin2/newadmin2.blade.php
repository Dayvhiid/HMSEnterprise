<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>{{ config('clinic.product_name') }}</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar', ['showErrors' => false])
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
    <div class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7eef3] px-10 py-3">
          <div class="flex items-center gap-4 text-[#0e161b]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M39.475 21.6262C40.358 21.4363 40.6863 21.5589 40.7581 21.5934C40.7876 21.655 40.8547 21.857 40.8082 22.3336C40.7408 23.0255 40.4502 24.0046 39.8572 25.2301C38.6799 27.6631 36.5085 30.6631 33.5858 33.5858C30.6631 36.5085 27.6632 38.6799 25.2301 39.8572C24.0046 40.4502 23.0255 40.7407 22.3336 40.8082C21.8571 40.8547 21.6551 40.7875 21.5934 40.7581C21.5589 40.6863 21.4363 40.358 21.6262 39.475C21.8562 38.4054 22.4689 36.9657 23.5038 35.2817C24.7575 33.2417 26.5497 30.9744 28.7621 28.762C30.9744 26.5497 33.2417 24.7574 35.2817 23.5037C36.9657 22.4689 38.4054 21.8562 39.475 21.6262ZM4.41189 29.2403L18.7597 43.5881C19.8813 44.7097 21.4027 44.9179 22.7217 44.7893C24.0585 44.659 25.5148 44.1631 26.9723 43.4579C29.9052 42.0387 33.2618 39.5667 36.4142 36.4142C39.5667 33.2618 42.0387 29.9052 43.4579 26.9723C44.1631 25.5148 44.659 24.0585 44.7893 22.7217C44.9179 21.4027 44.7097 19.8813 43.5881 18.7597L29.2403 4.41187C27.8527 3.02428 25.8765 3.02573 24.2861 3.36776C22.6081 3.72863 20.7334 4.58419 18.8396 5.74801C16.4978 7.18716 13.9881 9.18353 11.5858 11.5858C9.18354 13.988 7.18717 16.4978 5.74802 18.8396C4.58421 20.7334 3.72865 22.6081 3.36778 24.2861C3.02574 25.8765 3.02429 27.8527 4.41189 29.2403Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#0e161b] text-lg font-bold leading-tight tracking-[-0.015em]">{{ config('clinic.short_name') }}</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
               <a class="text-[#0e161b] text-sm font-medium leading-normal"  href="{{route('services.index')}}">Services</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal"  href="{{route('admin2.inventory')}}">Inventory List</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="{{route('admin2.drugs')}}" >Drug</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal"  href="{{route('admin2.frame')}}"  >Frame</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal"   href="{{route('admin2.lens')}}">Lens</a>
            </div>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCbb49Pi3NNur_JxgzAGt8BFBZNaRM5Oy-NychuL-ThKXSbxcRuT4h2ot3I4jws9XOEbKSQGHAnPVGfGMmUkXf_eRVe1YOTQVRbd5sd6lW6SqEkVIdpZtxIWctRGgfMVO312hMGw0mSgTxJ9R7bC3eJd_REWwEwEA3EKxvuc5_yrKMkfIcTkRynm7BjANx08RBSgiY9MWrE2vN4J_k9mjaNBoa6d67MESk6pP1_hxlKkq1WX9gcsfNOsF0eE7RYhQmJe1lXvf1id00");'
            ></div>
          </div>
        </header>
        <div class="px-6 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-full flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#0e161b] tracking-light text-[32px] font-bold leading-tight min-w-72">Stock Management</p></div>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-x-auto rounded-xl border border-[#d0dde7] bg-slate-50">
                <table class="flex-1" id="table">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-120 px-4 py-3 text-left text-[#0e161b] w-[170px] text-sm font-medium leading-normal" >Date</th>
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-240 px-4 py-3 text-left text-[#0e161b] w-[160px] text-sm font-medium leading-normal">
                        New Stock
                      </th>
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-360 px-4 py-3 text-left text-[#0e161b] w-[340px] text-sm font-medium leading-normal">
                        Name
                      </th>
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-480 px-4 py-3 text-left text-[#0e161b] w-[200px] text-sm font-medium leading-normal">
                        Patient Code
                      </th>
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-600 px-4 py-3 text-left text-[#0e161b] w-[200px] text-sm font-medium leading-normal">Reciept Number</th>
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-720 px-4 py-3 text-left text-[#0e161b] w-[130px] text-sm font-medium leading-normal">Qty In</th>
                      <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-840 px-4 py-3 text-left text-[#0e161b] w-[130px] text-sm font-medium leading-normal">Qty Out</th>
                       <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-840 px-4 py-3 text-left text-[#0e161b] w-[130px] text-sm font-medium leading-normal">Balance</th>
                        <th class="table-15609774-3410-47a9-be9c-d86617fbc518-column-840 px-4 py-3 text-left text-[#0e161b] w-[120px] text-sm font-medium leading-normal">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dde7]">
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-120 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                            placeholder="Enter Date"
                            name="inputs[0][date]"
                            type="date"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-240 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                          <input
                            placeholder="Enter Stock"
                                name="inputs[0][new_stock]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-360 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                        placeholder="Enter Stock Name"
                            name="inputs[0][name]"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                        value=""
                        />
                      </td>
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-480 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                            placeholder="Enter Patient Code"
                            name="inputs[0][patient_code]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-600 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                            placeholder="Enter Code"
                            name="inputs[0][booklet_no]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-720 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                            placeholder="Enter Quantity in"
                            name="inputs[0][qty_in]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-840 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                            placeholder="Enter Quantity Out"
                            name="inputs[0][qty_out]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                        <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-840 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                         <input
                            placeholder="Enter Balance"
                            name="inputs[0][balance]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                        <td class="table-15609774-3410-47a9-be9c-d86617fbc518-column-840 h-[72px] px-4 py-2 text-[#4d7999] text-sm font-normal leading-normal">
                           <button
                           type="button"
                           name="add"
                            id="add"
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#e7eef3] text-[#0e161b] text-sm font-bold leading-normal tracking-[0.015em]"
                        >
                            <span  class="truncate"  name="add" id="add">Add</span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
        
            <div class="flex px-4 py-3 justify-end">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#1581cf] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span type="submit" class="truncate">Submit</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
</form>
<script>
$(document).ready(function() {
  var rowCounter = 0;

  $(document).on('click', '#add', function() {
    rowCounter++;

    var newRow = $('<tr class="border-t border-t-[#d0dde7]">');

    // Date
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'date',
      name: 'inputs[' + rowCounter + '][date]',
      placeholder: 'Enter Date',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));

    // New Stock
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][new_stock]',
      placeholder: 'Enter Stock',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));

    // Name
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][name]',
      placeholder: 'Enter Name',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));

    // patient code
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][patient_code]',
      placeholder: 'Enter Patient Code',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));
      //Reciept No
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][booklet_no]',
      placeholder: 'Enter Code',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));
      //Qunatity In
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][qty_in]',
      placeholder: 'Enter Quantity In',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));
         //Qunatity out
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][qty_out]',
      placeholder: 'Enter Quantity Out',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));
         //Balance 
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<input>', {
      type: 'text',
      name: 'inputs[' + rowCounter + '][balance]',
      placeholder: 'Enter Balance',
      class: 'form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#111518] focus:outline-0 focus:ring-0 border border-[#d5dce2] bg-gray-50 focus:border-[#d5dce2] h-14 placeholder:text-[#5e7687] px-3 text-base font-normal leading-normal'
    })));

    // Add the remaining cells similarly...

    // Remove button
    newRow.append($('<td class="h-[72px] px-4 py-2">').append($('<button>', {
      type: 'button',
      class: 'remove-table-row flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-red-500 text-white text-sm font-bold leading-normal tracking-[0.015em]',
      text: 'Remove'
    })));

    // Append to the table body (target tbody, not just table)
    $('table tbody').append(newRow);
  });

  // Remove row
  $(document).on('click', '.remove-table-row', function() {
    $(this).closest('tr').remove();
  });
});
</script>
</body>
</html>
