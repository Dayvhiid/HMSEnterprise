<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Vitals Result</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar', ['showErrors' => false])

    <div class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7eef3] px-10 py-3">
          <div class="flex items-center gap-4 text-[#0e161b]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_6_535)">
                  <path
                    fill-rule="evenodd"
                    clip-rule="evenodd"
                    d="M47.2426 24L24 47.2426L0.757355 24L24 0.757355L47.2426 24ZM12.2426 21H35.7574L24 9.24264L12.2426 21Z"
                    fill="currentColor"
                  ></path>
                </g>
                <defs>
                  <clipPath id="clip0_6_535"><rect width="48" height="48" fill="white"></rect></clipPath>
                </defs>
              </svg>
            </div>
            <h2 class="text-[#0e161b] text-lg font-bold leading-tight tracking-[-0.015em]">VisionCare</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="{{ route('doctors.treatment') }}">Treatment Plan</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="{{ route('search.vitals') }} ">Vitals Records</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href=" {{ route('search.treatment') }} ">Treatment Records</a>
            </div>
            <button
              class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 bg-[#e7eef3] text-[#0e161b] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
            >
              <div class="text-[#0e161b]" data-icon="Bell" data-size="20px" data-weight="regular">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                  <path
                    d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"
                  ></path>
                </svg>
              </div>
            </button>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCd66TkKE4yQEUeRqSVBW8CdLE1h51zw9j71ozd-zDzNE2ljkG_4UK9xu-nF7lhbBLP2PaNEVVLPpyTlODE9aneXhL3_xw5W8w-wlB_umaybwJGpB0vt7U3Dc7JSdM-Btxa44gw9Y1TXwkcseOP_PLWgrlA-nckMUiYcgqtKJb6wCl57aMtBDn2Rn7VoU9IzmcSBBPpP9_5Xt74L07Tyk8tnkmltNwdRX2FZncD2P9qQdgjwBMrXQnBQCUlDhA4Y0x7NdeFykzuBoY");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="px-4 py-3">
              <label class="flex flex-col min-w-40 h-12 w-full">
                <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
                  <div
                    class="text-[#4e7a97] flex border-none bg-[#e7eef3] items-center justify-center pl-4 rounded-l-lg border-r-0"
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
                    placeholder="Search by Patient ID"
                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border-none bg-[#e7eef3] focus:border-none h-full placeholder:text-[#4e7a97] px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                    value=""
                  />
                </div>
              </label>
            </div>
       
            @if (session('success'))
              <div class="mx-4 mt-2 rounded-lg bg-green-100 p-3 text-sm text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('info'))
              <div class="mx-4 mt-2 rounded-lg bg-amber-100 p-3 text-sm text-amber-900">{{ session('info') }}</div>
            @endif
            @if ($errors->any())
              <div class="mx-4 mt-2 rounded-lg bg-red-100 p-3 text-sm text-red-800">
                <p class="font-bold">The changes were not saved:</p>
                <ul class="list-disc pl-5">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            @if ($visits->isNotEmpty())
              <p class="px-4 pt-2 text-[#4e7a97] text-sm">Change any value in a visit and click <strong>Save changes to this visit</strong>. Each visit saves separately.</p>
            @endif
            <p class="px-4 pt-3 text-[#4e7a97] text-sm">
              Patient {{ $patientCode }}: {{ $visits->count() }} {{ \Illuminate\Support\Str::plural('visit', $visits->count()) }}, newest first
            </p>
            @forelse ($visits as $visit)
              @php
                $combinedResult = $visit['vital'];
                $leftEye = $visit['vital2']; // left-eye subjective refraction and final RX for this visit
              @endphp
            <form method="POST" action="{{ route('vitals.update', $combinedResult) }}" class="vitals-card-form mx-4 my-6 rounded-xl border-2 border-[#d0dee7] bg-white pb-4">
              @csrf
              @method('PUT')
              <div class="flex flex-wrap items-center justify-between gap-3 rounded-t-xl border-b border-[#d0dee7] bg-[#e7eef3] px-4 py-3">
                <div>
                  <p class="text-[#0e161b] text-lg font-bold leading-tight">Visit: {{ $combinedResult->created_at->format('F j, Y g:i A') }}</p>
                  @if ($combinedResult->updated_at && $combinedResult->updated_at->gt($combinedResult->created_at))
                    <p class="text-[#4e7a97] text-xs pt-1">Edited on {{ $combinedResult->updated_at->format('F j, Y g:i A') }}</p>
                  @endif
                </div>
                <div class="flex items-center gap-3">
                  <a href="{{ route('vitals.prescription', $combinedResult) }}" target="_blank" class="text-sm text-[#1993e5] underline">Print spectacle Rx</a>
                  <a href="{{ route('vitals.edit', $combinedResult) }}" class="text-sm text-[#1993e5] underline">Open in full form</a>
                  <button type="submit" class="vitals-card-save flex items-center justify-center rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold"><span>Save changes to this visit</span></button>
                </div>
              </div>
                
         
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Case History</h2>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea name="cc"
                  placeholder="Chief Complaint (C/C)"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] min-h-36 placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >{{ $combinedResult->cc }}</textarea>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea name="pohx"
                  placeholder="Present Ocular History (PoHx)"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] min-h-36 placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >{{ $combinedResult->pohx }}</textarea>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea name="lee"
                  placeholder="Past Ocular History (PfoHx)"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] min-h-36 placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >{{ $combinedResult->lee }}</textarea>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea name="pmhx"
                  placeholder="Lifestyle and Exposure Events (LEE)"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] min-h-36 placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >{{ $combinedResult->pmhx }}</textarea>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <textarea name="pfohx"
                  placeholder="Past Medical History (PmHx)"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] min-h-36 placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >{{ $combinedResult->pfohx }}</textarea>
              </label>
            </div>
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Visual Examination</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Unaided</th>
                      <th class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Pin Hole
                      </th>
                      <th class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Near V/A
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODunaided" value="{{ $combinedResult->odunaided }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODpinhole" value="{{ $combinedResult->odpinhole }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODnearVA" value="{{ $combinedResult->odaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSunaided" value="{{ $combinedResult->osunaided }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSpinhole" value="{{ $combinedResult->ospinhole }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSnearVA" value="{{ $combinedResult->osaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-120{display: none;}}
                @container(max-width:240px){.table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-240{display: none;}}
                @container(max-width:360px){.table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-360{display: none;}}
                @container(max-width:480px){.table-ed93db9d-8d40-4a89-8594-a3c6ef716f33-column-480{display: none;}}
              </style>
            </div>
               <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Lensometry</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
              {{-- <div>
                   <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 mt-[30px]">Visual Examination</h2>
              </div> --}}
              {{-- Lensometry --}}
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Spherical
                      </th>
                      <th class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Cylindrical
                      </th>
                      <th class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Axis</th>
                      <th class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Visual Acuity
                      </th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODSPH" value="{{ $combinedResult->lodsph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODCYL" value="{{ $combinedResult->lodcyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODAXIS" value="{{ $combinedResult->lodaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ODVA" value="{{ $combinedResult->lodva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                     
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSSPH" value="{{ $combinedResult->lossph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSCYL" value="{{ $combinedResult->loscyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSAXIS" value="{{ $combinedResult->losaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="OSVA" value="{{ $combinedResult->losva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                   
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">ADD</td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ADDSPH" value="{{ $combinedResult->addsph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ADDCYL" value="{{ $combinedResult->addcyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ADDAXIS" value="{{ $combinedResult->addaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="ADDVA" value="{{ $combinedResult->addva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-120{display: none;}}
                @container(max-width:240px){.table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-240{display: none;}}
                @container(max-width:360px){.table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-360{display: none;}}
                @container(max-width:480px){.table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-480{display: none;}}
                @container(max-width:600px){.table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-600{display: none;}}
                @container(max-width:720px){.table-0ff4604b-733a-4828-be83-9f4a384d75a3-column-720{display: none;}}
              </style>
            </div>
              <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Auto-Refraction</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Spherical
                      </th>
                      <th class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Cylindrical
                      </th>
                      <th class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Axis</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="arodsph" value="{{ $combinedResult->arodsphere }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="arodcyl" value="{{ $combinedResult->arodcyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="arodaxis" value="{{ $combinedResult->arodaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="arosph" value="{{ $combinedResult->arossphere }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="aroscyl" value="{{ $combinedResult->aroscyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="arosaxis" value="{{ $combinedResult->arosaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-120{display: none;}}
                @container(max-width:240px){.table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-240{display: none;}}
                @container(max-width:360px){.table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-360{display: none;}}
                @container(max-width:480px){.table-3e1aa050-7954-44d8-94a8-b2590c05fc7d-column-480{display: none;}}
              </style>
              <p class="px-4 pt-3 text-sm text-[#0e161b]">
                <span class="font-medium">P.D. (Pupillary Distance):</span>
                <input name="arpd" type="number" step="any" min="40" max="85" value="{{ $combinedResult->arpd }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0 inline-block max-w-[120px]" /> mm
              </p>
            </div>
              <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Retinoscope</h2>
            <div class="px-4 py-3 @container">
                {{-- Retinoscope --}}
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Spherical
                      </th>
                      <th class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Cylindrical
                      </th>
                      <th class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Axis</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="rodsph" value="{{ $combinedResult->rodsph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="rodcyl" value="{{ $combinedResult->rodcyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="rodaxis" value="{{ $combinedResult->rodaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="rossph" value="{{ $combinedResult->rossph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="roscyl" value="{{ $combinedResult->roscyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="rosaxis" value="{{ $combinedResult->rosaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-120{display: none;}}
                @container(max-width:240px){.table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-240{display: none;}}
                @container(max-width:360px){.table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-360{display: none;}}
                @container(max-width:480px){.table-41c02972-1f93-4d83-95a0-81b214e4b82d-column-480{display: none;}}
              </style>
            </div>
            {{-- Subjective Refraction --}}
              <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Subjective Refraction</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Spherical
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Cylindrical
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Axis</th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Visual Acuity
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Addition
                      </th>
                       <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Near V/A
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srodsph" value="{{ $combinedResult->srodsphere }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srodcyl" value="{{ $combinedResult->srodcyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srodaxis" value="{{ $combinedResult->srodaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srodva" value="{{ $combinedResult->srodva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                       <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srodadd" value="{{ $combinedResult->srodadd }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                        <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srodnva" value="{{ $combinedResult->srodnva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srosph" value="{{ $leftEye?->srosphere }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="sroscyl" value="{{ $leftEye?->sroscyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srosaxis" value="{{ $leftEye?->srosaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srosva" value="{{ $leftEye?->srosva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                       <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srosadd" value="{{ $leftEye?->srosadd }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                        <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="srosnva" value="{{ $leftEye?->srosnva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120{display: none;}}
                @container(max-width:240px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240{display: none;}}
                @container(max-width:360px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360{display: none;}}
                @container(max-width:480px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480{display: none;}}
                @container(max-width:600px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600{display: none;}}
              </style>
            </div>

            {{-- Final RX --}}
              <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Finax RX</h2>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Spherical
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Cylindrical
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Axis</th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Visual Acuity
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Addition
                      </th>
                       <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Near V/A
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fodsph" value="{{ $combinedResult->fodsph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fodcyl" value="{{ $combinedResult->fodcyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fodaxis" value="{{ $combinedResult->fodaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fodva" value="{{ $combinedResult->fodva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                       <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fodadd" value="{{ $combinedResult->fodadd }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                        <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fodnva" value="{{ $combinedResult->fodnva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fossph" value="{{ $leftEye?->fossph }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="foscyl" value="{{ $leftEye?->foscyl }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fosaxis" value="{{ $leftEye?->fosaxis }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fosva" value="{{ $leftEye?->fosva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                       <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fosadd" value="{{ $leftEye?->fosadd }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                        <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="fosnva" value="{{ $leftEye?->fosnva }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

              {{-- IOP --}}
               <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">IOP</h2>
              <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        CCT
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        NCT
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Right Eye
                      </td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="odccct" value="{{ $combinedResult->odccct }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="odnct" value="{{ $combinedResult->odnct }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Left Eye</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="oscct" value="{{ $combinedResult->oscct }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="osnct" value="{{ $combinedResult->osnct }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      
                    </tr>
                  </tbody>
                </table>
              </div>
              <p class="pt-3 text-sm text-[#0e161b]">
                <span class="font-medium">IOP taken:</span>
                <input name="iop_taken_at" type="datetime-local" value="{{ $combinedResult->iop_taken_at?->format('Y-m-d\TH:i') }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0 inline-block max-w-[240px]" />
              </p>
            </div>

              {{-- External Examination And Internal Examination --}}
               <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">External Examination And Internal Examination</h2>
              <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal"></th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Right Eye
                      </th>
                      <th class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Left Eye
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Eyelid
                      </td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="eyelidod" value="{{ $combinedResult->eyelidod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="eyelidos" value="{{ $combinedResult->eyelidos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Conjuctiva</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="conjuctivaod" value="{{ $combinedResult->conjuctivaod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="conjuctivaos" value="{{ $combinedResult->conjuctivaos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Cornea</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="corneaod" value="{{ $combinedResult->corneaod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="corneaos" value="{{ $combinedResult->corneaos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Pupil</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="pupilod" value="{{ $combinedResult->pupilod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="pupilos" value="{{ $combinedResult->pupilos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Iris</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="irisod" value="{{ $combinedResult->irisod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="irisos" value="{{ $combinedResult->irisos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Lens</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="lensod" value="{{ $combinedResult->lensod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="lensos" value="{{ $combinedResult->lensos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Virtreous</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="vitreousod" value="{{ $combinedResult->vitreousod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="vitreousos" value="{{ $combinedResult->vitreousos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">C/D Ratio</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="cdratiood" value="{{ $combinedResult->cdratiood }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="cdratioos" value="{{ $combinedResult->cdratioos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                    </tr>
                      <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Macula</td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="macularod" value="{{ $combinedResult->macularod }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                      <td class="table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"><input name="maculaos" value="{{ $combinedResult->maculaos }}" class="w-full min-w-[80px] rounded-md border border-[#d0dee7] bg-white px-2 py-1 text-sm text-[#0e161b] focus:border-[#1993e5] focus:ring-0" /></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-120{display: none;}}
                @container(max-width:240px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-240{display: none;}}
                @container(max-width:360px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-360{display: none;}}
                @container(max-width:480px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-480{display: none;}}
                @container(max-width:600px){.table-ae47780c-e688-4c02-9f3e-0f37f1371680-column-600{display: none;}}
              </style>
            </div>
              <div class="flex justify-end px-4 pt-4">
                <button type="submit" class="vitals-card-save flex items-center justify-center rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold"><span>Save changes to this visit</span></button>
              </div>
            </form>
            @empty
              <p class="px-4 py-6 text-[#4e7a97] text-sm">No vitals recorded for this patient.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
      <script>
      (function () {
        var dirty = false;
        document.querySelectorAll('.vitals-card-form').forEach(function (form) {
          // Enter in a single-line field moves to the next field instead of saving the visit.
          form.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' || event.target.tagName !== 'INPUT') {
              return;
            }
            event.preventDefault();
            var fields = Array.prototype.filter.call(form.elements, function (el) {
              return (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') && el.type !== 'hidden' && !el.disabled;
            });
            var next = fields[fields.indexOf(event.target) + 1];
            if (next) {
              next.focus();
            }
          });
          form.addEventListener('input', function () { dirty = true; });
          // Lock this card's Save buttons after the first click so a double click can't save twice.
          form.addEventListener('submit', function () {
            dirty = false;
            form.querySelectorAll('.vitals-card-save').forEach(function (button) {
              button.disabled = true;
              button.classList.add('opacity-60', 'cursor-not-allowed');
              button.querySelector('span').textContent = 'Saving…';
            });
          });
        });
        // Warn before leaving the page with edits that were not saved.
        window.addEventListener('beforeunload', function (event) {
          if (dirty) {
            event.preventDefault();
            event.returnValue = '';
          }
        });
      })();
    </script>
  </body>
</html>