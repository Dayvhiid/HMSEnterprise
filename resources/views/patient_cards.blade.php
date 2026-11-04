<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Stitch Design</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
    <div class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden" style='font-family: "Public Sans", "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <div class="gap-1 px-6 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-80">
            <div class="flex h-full min-h-[700px] flex-col justify-between bg-slate-50 p-4">
              <div class="flex flex-col gap-4">
                <a href="{{ route('patient.edit', $user->id) }}"
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]"
                >
                  <span class="truncate">Update Details</span>
                </a>
                <form method="POST" action="{{ route('patient.checkin', $user->id) }}">
                  @csrf
                  <button type="submit"
                    class="flex w-full min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#16a34a] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]"
                  >
                    <span class="truncate">Check In (Returning Patient)</span>
                  </button>
                </form>
                <div class="flex flex-col gap-1">
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#0e161b]" data-icon="Gear" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M128,80a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Zm88-29.84q.06-2.16,0-4.32l14.92-18.64a8,8,0,0,0,1.48-7.06,107.21,107.21,0,0,0-10.88-26.25,8,8,0,0,0-6-3.93l-23.72-2.64q-1.48-1.56-3-3L186,40.54a8,8,0,0,0-3.94-6,107.71,107.71,0,0,0-26.25-10.87,8,8,0,0,0-7.06,1.49L130.16,40Q128,40,125.84,40L107.2,25.11a8,8,0,0,0-7.06-1.48A107.6,107.6,0,0,0,73.89,34.51a8,8,0,0,0-3.93,6L67.32,64.27q-1.56,1.49-3,3L40.54,70a8,8,0,0,0-6,3.94,107.71,107.71,0,0,0-10.87,26.25,8,8,0,0,0,1.49,7.06L40,125.84Q40,128,40,130.16L25.11,148.8a8,8,0,0,0-1.48,7.06,107.21,107.21,0,0,0,10.88,26.25,8,8,0,0,0,6,3.93l23.72,2.64q1.49,1.56,3,3L70,215.46a8,8,0,0,0,3.94,6,107.71,107.71,0,0,0,26.25,10.87,8,8,0,0,0,7.06-1.49L125.84,216q2.16.06,4.32,0l18.64,14.92a8,8,0,0,0,7.06,1.48,107.21,107.21,0,0,0,26.25-10.88,8,8,0,0,0,3.93-6l2.64-23.72q1.56-1.48,3-3L215.46,186a8,8,0,0,0,6-3.94,107.71,107.71,0,0,0,10.87-26.25,8,8,0,0,0-1.49-7.06Zm-16.1-6.5a73.93,73.93,0,0,1,0,8.68,8,8,0,0,0,1.74,5.48l14.19,17.73a91.57,91.57,0,0,1-6.23,15L187,173.11a8,8,0,0,0-5.1,2.64,74.11,74.11,0,0,1-6.14,6.14,8,8,0,0,0-2.64,5.1l-2.51,22.58a91.32,91.32,0,0,1-15,6.23l-17.74-14.19a8,8,0,0,0-5-1.75h-.48a73.93,73.93,0,0,1-8.68,0,8,8,0,0,0-5.48,1.74L100.45,215.8a91.57,91.57,0,0,1-15-6.23L82.89,187a8,8,0,0,0-2.64-5.1,74.11,74.11,0,0,1-6.14-6.14,8,8,0,0,0-5.1-2.64L46.43,170.6a91.32,91.32,0,0,1-6.23-15l14.19-17.74a8,8,0,0,0,1.74-5.48,73.93,73.93,0,0,1,0-8.68,8,8,0,0,0-1.74-5.48L40.2,100.45a91.57,91.57,0,0,1,6.23-15L69,82.89a8,8,0,0,0,5.1-2.64,74.11,74.11,0,0,1,6.14-6.14A8,8,0,0,0,82.89,69L85.4,46.43a91.32,91.32,0,0,1,15-6.23l17.74,14.19a8,8,0,0,0,5.48,1.74,73.93,73.93,0,0,1,8.68,0,8,8,0,0,0,5.48-1.74L155.55,40.2a91.57,91.57,0,0,1,15,6.23L173.11,69a8,8,0,0,0,2.64,5.1,74.11,74.11,0,0,1,6.14,6.14,8,8,0,0,0,5.1,2.64l22.58,2.51a91.32,91.32,0,0,1,6.23,15l-14.19,17.74A8,8,0,0,0,199.87,123.66Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Settings</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#0e161b]" data-icon="Question" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path
                          d="M140,180a12,12,0,1,1-12-12A12,12,0,0,1,140,180ZM128,72c-22.06,0-40,16.15-40,36v4a8,8,0,0,0,16,0v-4c0-11,10.77-20,24-20s24,9,24,20-10.77,20-24,20a8,8,0,0,0-8,8v8a8,8,0,0,0,16,0v-.72c18.24-3.35,32-17.9,32-35.28C168,88.15,150.06,72,128,72Zm104,56A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"
                        ></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Help</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-3">
                <p class="text-[#0e161b] tracking-light text-[32px] font-bold leading-tight">Patient Details</p>
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">View and manage patient information</p>
              </div>
            </div>
            @if (session('success'))
              <div class="mx-4 rounded-lg bg-green-100 p-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('info'))
              <div class="mx-4 rounded-lg bg-amber-100 p-3 text-sm text-amber-800">{{ session('info') }}</div>
            @endif
            <div class="flex p-4 @container">
              <div class="flex w-full flex-col gap-4 @[520px]:flex-row @[520px]:justify-between @[520px]:items-center">
                <div class="flex gap-4">
                  <div
                    class="bg-center bg-no-repeat aspect-square bg-cover rounded-full min-h-32 w-32"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDqpxoiRlac53Ir5fbDeszAtFGDcR8fP3wugzk-R1HY8sDw3gX4jMcsmTDIYW2F1Ek3M26FPc5LX4gJxX71bnOFBHVDV17gkium7uOEIW-QA3H35rnmuSQBFRzW7YNSvAf-FwLttOlXIZ0hUF5MjdFwMcoiXVy7vZktLNRCAxaTbJYbfLs2dtw0BVu6jIBFWSd38FfSLZZHENIy6orENHOyOahGvq1hrPbmEbjxvSRJTUjxa9V4GUq-TrqUg_J7VMPFHytbKKdItt0");'
                  ></div>
                  <div class="flex flex-col justify-center">
                    <p class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em]">     @if($user->first_name && $user->last_name)
                            {{ $user->first_name . ' ' . $user->last_name }}
                        @else
                            {{ $user->fullname }}
                        @endif </p>
                    <p class="text-[#4e7a97] text-base font-normal leading-normal">Patient ID: {{ $user->patient_id }} </p>
                    <p class="text-[#4e7a97] text-base font-normal leading-normal">Date of Birth: 1985-08-15 | Gender: {{ $user->gender }} </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="pb-3">
              {{-- <div class="flex border-b border-[#d0dee7] px-4 gap-8">
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-[#1993e5] text-[#0e161b] pb-[13px] pt-4" href="#">
                  <p class="text-[#0e161b] text-sm font-bold leading-normal tracking-[0.015em]">Overview</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7a97] pb-[13px] pt-4" href="#">
                  <p class="text-[#4e7a97] text-sm font-bold leading-normal tracking-[0.015em]">Medical History</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7a97] pb-[13px] pt-4" href="#">
                  <p class="text-[#4e7a97] text-sm font-bold leading-normal tracking-[0.015em]">Appointments</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7a97] pb-[13px] pt-4" href="#">
                  <p class="text-[#4e7a97] text-sm font-bold leading-normal tracking-[0.015em]">Billing</p>
                </a>
              </div> --}}
            </div>
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Patient Information</h2>
            <div class="p-4 grid grid-cols-2">
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Address</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">  {{ $user->street }}</p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Phone</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal"> {{ $user->phone }} </p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Email</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">  {{ $user->email}}</p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Emergency Contact Name</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">  {{$user->emergency_fullname}} </p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Emergency Contact Phone</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">  {{ $user->emergency_phone }}</p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Occupation</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">  {{ $user->occupation}} </p>
              </div>
              {{-- <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Policy Number</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">HF123456789</p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Primary Care Physician</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">Dr. Olivia Bennett</p>
              </div> --}}
            </div>
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Patient Summary</h2>
            <div class="px-4 pb-4">
              <div class="rounded-lg border border-[#d0dee7] bg-white p-4">
                @if (filled($user->summary))
                  <p class="text-[#0e161b] text-sm font-normal leading-relaxed whitespace-pre-line">{{ $user->summary }}</p>
                @else
                  <p class="text-[#4e7a97] text-sm font-normal italic">No summary yet.</p>
                @endif
                @if ($user->summary_updated_at)
                  <p class="text-[#4e7a97] text-xs font-normal pt-3">
                    Last updated by {{ $user->summary_updated_by }} on {{ $user->summary_updated_at->format('F j, Y \a\t g:i A') }}
                  </p>
                @endif
              </div>
              <form method="POST" action="{{ route('patient.summary.update', $user->id) }}" class="pt-3">
                @csrf
                @method('PUT')
                <label for="summary" class="block text-[#0e161b] text-sm font-medium pb-2">Write or edit the summary</label>
                <textarea id="summary" name="summary" rows="6" maxlength="5000"
                  placeholder="e.g. Diagnosis, ongoing treatment, allergies, follow-up notes..."
                  class="form-textarea w-full rounded-lg border border-[#d0dee7] bg-white text-[#0e161b] text-sm p-3 focus:border-[#1993e5] focus:ring-0">{{ old('summary', $user->summary) }}</textarea>
                @error('summary')
                  <p class="text-sm text-red-600 pt-1">{{ $message }}</p>
                @enderror
                <button type="submit"
                  class="mt-2 flex min-w-[84px] items-center justify-center rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]">
                  Save Summary
                </button>
              </form>
            </div>
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Current Status</h2>
            <div class="p-4 grid grid-cols-2">
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Admission Date</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal"> {{ $user->created_at->format('F j, Y') }} </p>
              </div>
              <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Last Visit</p>
                <p class="text-[#0e161b] text-sm font-normal leading-normal">  {{ $user->datee }} </p>
              </div>
            </div>
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Medical Records</h2>
            <div class="p-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
              @foreach ([
                ['label' => 'Vitals', 'count' => $medicalRecords['vitalsCount'], 'latest' => $medicalRecords['latestVital'], 'route' => 'vitals.get', 'button' => 'View Vitals', 'empty' => 'No vitals recorded',
                 'icon' => 'M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z'],
                ['label' => 'Treatment Plans', 'count' => $medicalRecords['treatmentsCount'], 'latest' => $medicalRecords['latestTreatment'], 'route' => 'search.get', 'button' => 'View Treatment Plan', 'empty' => 'No treatment plans recorded',
                 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z'],
              ] as $record)
                <div class="flex flex-col gap-3 rounded-lg border border-[#d0dee7] bg-slate-50 p-4">
                  <div class="flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 text-[#1993e5]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                      <path stroke-linecap="round" stroke-linejoin="round" d="{{ $record['icon'] }}" />
                    </svg>
                    <div>
                      <p class="text-[#0e161b] text-base font-bold leading-normal">{{ $record['label'] }} ({{ $record['count'] }})</p>
                      <p class="text-[#4e7a97] text-sm font-normal leading-normal">
                        @if ($record['latest'])
                          Latest: {{ \Carbon\Carbon::parse($record['latest'])->format('F j, Y') }}
                        @else
                          {{ $record['empty'] }}
                        @endif
                      </p>
                    </div>
                  </div>
                  @if ($record['count'] > 0)
                    <a href="{{ route($record['route'], ['query' => $user->patient_id]) }}"
                      class="flex items-center justify-center rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]">
                      {{ $record['button'] }}
                    </a>
                  @endif
                </div>
              @endforeach
            </div>
            {{-- <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Recent Appointments</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Date</th>
                      <th class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Time</th>
                      <th class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Doctor</th>
                      <th class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Department
                      </th>
                      <th class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-600 px-4 py-3 text-left text-[#0e161b] w-60 text-sm font-medium leading-normal">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-120 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        2024-07-22
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">10:00 AM</td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        Dr. Olivia Bennett
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        Cardiology
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-600 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-8 px-4 bg-[#e7eef3] text-[#0e161b] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Completed</span>
                        </button>
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-120 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        2024-07-25
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">2:00 PM</td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        Dr. Liam Carter
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        Neurology
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-600 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-8 px-4 bg-[#e7eef3] text-[#0e161b] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Scheduled</span>
                        </button>
                      </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-120 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        2024-07-28
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">11:00 AM</td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        Dr. Ava Harper
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">
                        Dermatology
                      </td>
                      <td class="table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-600 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                        <button
                          class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-8 px-4 bg-[#e7eef3] text-[#0e161b] text-sm font-medium leading-normal w-full"
                        >
                          <span class="truncate">Scheduled</span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div> --}}
              <style>
                          @container(max-width:120px){.table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-120{display: none;}}
                @container(max-width:240px){.table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-240{display: none;}}
                @container(max-width:360px){.table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-360{display: none;}}
                @container(max-width:480px){.table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-480{display: none;}}
                @container(max-width:600px){.table-622cb277-e7cc-47f2-a7f0-782c30f10d93-column-600{display: none;}}
              </style>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
