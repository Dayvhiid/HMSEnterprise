{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>{{ config('clinic.product_name') }}</title>
</head>
<body>
   
            @csrf
            @method('PUT') <!-- Tell Laravel this is a PUT request -->
        <table class="table">
            <thead class="thead-dark">
              <tr>
               
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Full Name</th>
                <th scope="col">P.I.D</th>
                <th scope="col">Gender</th>
                <th scope="col">Phone</th>
                <th scope="col">Street</th>
                <th scope="col">Occupation</th>
                <th scope="col">Age</th>
                 <th scope="col">Date</th>
              </tr>
            </thead>
               <tbody>
           @foreach($users as $user)
            <form action="{{ route('users.update', $user->id) }}" method="POST">
              @csrf
              @method('PUT') 

            <tr>
              <td><input type="text" class="form-control" name="first_name" value="{{$user->first_name}}"></td>
              <td><input type="text" class="form-control" name="last_name" value="{{$user->last_name}}"></td>
               <td><input type="text" class="form-control" name="fullname" value="{{$user->fullname}}"></td> 
              <td><input type="text" class="form-control" name="patient_id" value="{{$user->patient_id}}"></td>
              <td><input type="text" class="form-control" name="gender" value="{{$user->gender}}"></td>
              <td><input type="text" class="form-control" name="phone" value="{{$user->phone}}"></td>
              <td><input type="text" class="form-control" name="street" value="{{$user->street}}"></td>
              <td><input type="text" class="form-control" name="occupation" value="{{$user->occupation}}"></td>
              @php
    $age = $user->date;
    $isTwoDigitNumber = is_numeric($age) && strlen(trim($age)) == 2;
@endphp
              <td><input type="text"  name="age"  value="{{ $isTwoDigitNumber ? $age : number_format(\Carbon\Carbon::parse($age)->diffInYears(\Carbon\Carbon::now()), 0) }}"></td>
           
              <td><input type="text" class="form-control" name="datee" value="{{$user->datee}}"></td>
              <td><button type="submit" class="btn btn-success">Update</button></td>

            </tr>
           @endforeach
            </tbody>
          </table>              
    </form>
</body>
</html> --}}



<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Patient Information</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar')
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f5] px-10 py-3">
          <div class="flex items-center gap-4 text-[#111418]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4 42.4379C4 42.4379 14.0962 36.0744 24 41.1692C35.0664 46.8624 44 42.2078 44 42.2078L44 7.01134C44 7.01134 35.068 11.6577 24.0031 5.96913C14.0971 0.876274 4 7.27094 4 7.27094L4 42.4379Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#111418] text-lg font-bold leading-tight tracking-[-0.015em]">Patient Infromation</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            {{-- <div class="flex items-center gap-9">
              <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Dashboard</a>
              <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Schedule</a>
              <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Clients</a>
              <a class="text-[#111418] text-sm font-medium leading-normal" href="#">Billing</a>
            </div> --}}
            <button
              class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 bg-[#f0f2f5] text-[#111418] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
            >
              <div class="text-[#111418]" data-icon="Bell" data-size="20px" data-weight="regular">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                  <path
                    d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"
                  ></path>
                </svg>
              </div>
            </button>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuD7yJ3aVjwtv0o63CrhQDkateCKxG_4UwLO0a1a7OrvCtoU5C8l59d0h47g9xT5Cx6Uw2Wp_qzZJh3rSa2SKGTMP_-T4xGeUmTT5cO3Bn3p4zV8AsDmQbxbtWb5GZMH4BhBeS2WG2R3-OKh5SYwJANPM8at80aJjD4qc8fU-97qAjRRAWI9KnaykB2XSRXxnYRST8NhvQ_GU8zpMDHdVEvaDI7GD0ux-x7T-RE64F2FnlBtlTiNxGVp92xqICkA4uKMUojrcw_VEC4");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight min-w-72">Clients</p></div>
            <div class="px-4 py-3">
              <label class="flex flex-col min-w-40 h-12 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                  <div
                    class="text-[#60758a] flex border-none bg-[#f0f2f5] items-center justify-center pl-4 rounded-l-lg border-r-0"
                    data-icon="MagnifyingGlass"
                    data-size="24px"
                    data-weight="regular"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z"
                      ></path>
                    </svg>
                  </div>
                  <input
                    placeholder="Search clients"
                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border-none bg-[#f0f2f5] focus:border-none h-full placeholder:text-[#60758a] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                    value=""
                  />
                </div>
              </label>
            </div>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#dbe0e6] bg-white">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-white">
                      <th class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-120 px-4 py-3 text-left text-[#111418] w-[400px] text-sm font-medium leading-normal">Name</th>
                      <th class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-240 px-4 py-3 text-left text-[#111418] w-[400px] text-sm font-medium leading-normal">
                        Patient ID
                      </th>
                      <th class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-360 px-4 py-3 text-left text-[#111418] w-[400px] text-sm font-medium leading-normal">Gender</th>
                      <th class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-480 px-4 py-3 text-left text-[#111418] w-60 text-[#60758a] text-sm font-medium leading-normal">
                        Actions
                      </th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach ($users as $user)
                      <tr class="border-t border-t-[#dbe0e6]">
                      <td class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-120 h-[72px] px-4 py-2 w-[400px] text-[#111418] text-sm font-normal leading-normal">
                           @if($user->first_name && $user->last_name)
                            {{ $user->first_name . ' ' . $user->last_name }}
                        @else
                            {{ $user->fullname }}
                        @endif
                      </td>
                      <td class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#60758a] text-sm font-normal leading-normal">  {{ $user->patient_id }} </td>
                      <td class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-360 h-[72px] px-4 py-2 w-[400px] text-[#60758a] text-sm font-normal leading-normal"> {{ $user->gender}}  </td>
                      <td class="table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-480 h-[72px] px-4 py-2 w-60 text-[#60758a] text-sm font-bold leading-normal tracking-[0.015em]">
                            <a href="{{ route('patient.show', $user->id) }}" class="inline-flex items-center gap-1.5 text-blue-600 hover:underline">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                              </svg>
                              View Patient Card
                            </a>
                            <form method="POST" action="{{ route('patient.checkin', $user->id) }}" class="mt-1">
                              @csrf
                              <button type="submit" class="inline-flex items-center gap-1.5 text-green-700 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Check In
                              </button>
                            </form>
                      </td>
                    </tr>
                    @endforeach
                    
                    
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-120{display: none;}}
                @container(max-width:240px){.table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-240{display: none;}}
                @container(max-width:360px){.table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-360{display: none;}}
                @container(max-width:480px){.table-eac3796d-5e32-4c1a-85a7-eac564274ab1-column-480{display: none;}}
              </style>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
