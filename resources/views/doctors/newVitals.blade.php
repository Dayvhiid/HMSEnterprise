<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Manrope%3Awght%40400%3B500%3B700%3B800&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" />

    <title>Vitals Page</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>

<body>
@include('partials.session-bar', ['showErrors' => false])
@php
    // $vital and $prefill are only set when editing a saved visit (VitalsController::edit).
    $editing = isset($vital);
    $prefill = $prefill ?? [];
    $v = fn (string $name) => old($name, $prefill[$name] ?? '');
@endphp
<form method="post" action="{{ $editing ? route('vitals.update', $vital) : route('vitals.store') }}" id="vitals-form">
   @csrf
  @method($editing ? 'PUT' : 'POST')
  @unless ($editing)
    {{-- One-time token: lets the server ignore a second submit of this same form. --}}
    <input type="hidden" name="form_token" value="{{ old('form_token', (string) \Illuminate\Support\Str::uuid()) }}" />
  @endunless
  @if ($editing)
    <div class="mx-4 mt-4 rounded-lg bg-amber-100 p-3 text-sm text-amber-900">
      Editing the visit of <strong>{{ $vital->created_at->format('F j, Y g:i A') }}</strong> for patient
      <strong>{{ $vital->patient_code }}</strong>. Saving updates this visit; it does not create a new one.
    </div>
  @endif
  @if ($errors->any())
    <div class="mx-4 mt-4 rounded-lg bg-red-100 p-3 text-sm text-red-800">
      <p class="font-bold">The vitals were not saved. Please fix the following and click Save again (everything you typed is still here):</p>
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden"
        style='font-family: Manrope, "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            <header
                class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f1f2f4] px-10 py-3">
                <div class="flex items-center gap-4 text-[#121416]">
                    <div class="size-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M24 4C25.7818 14.2173 33.7827 22.2182 44 24C33.7827 25.7818 25.7818 33.7827 24 44C22.2182 33.7827 14.2173 25.7818 4 24C14.2173 22.2182 22.2182 14.2173 24 4Z"
                                fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em]">Diagnosis Vitals</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        <a class="text-[#121416] text-sm font-medium leading-normal" href="{{route('doctors.treatment')}}">Treatment Plan</a>
                        <a class="text-[#121416] text-sm font-medium leading-normal" href="{{route('search.vitals')}}">Vitals Records</a>
                        <a class="text-[#121416] text-sm font-medium leading-normal" href="{{route('search.treatment')}}">Treatment
                            Records</a>
                    </div>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuALqV6KVgC3KmPbR3PqTj9vqWq9mAJsFvuld_8sqAHKtIpkCvl4MypJ8opVVByUUSdDxutaXZSY2LTweD_wfUqExHS-A4rYD2zgzpLnkgzPzSNUDKBHb6tK0UyFjrSHsxDGaSQsRAc4H06taDnKqVfn7nvtOYqeJNXMIwpbbNoMrpKeSzISAOIXndhRqf54MXYAS9Tk54T3XJb8YAQLfeTeVVXDhhWyU12OyL84o_ayO9rqxYB8NoA8M1a6e9d_mTNLw-PdPiekDhQ");'>
                    </div>
                </div>
            </header>
            <div class="px-40 flex flex-1 justify-center py-5">
                <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
                    <div class="flex flex-wrap justify-between gap-3 p-4">
                        <p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">
                            Comprehensive Eye Examination</p>
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Patient Identification</h3>
                    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col min-w-40 flex-1">
                            <p class="text-[#121416] text-base font-medium leading-normal pb-2">Patient ID</p>
                            <input placeholder="Enter Patient ID"
                               name="patient_code" @if ($editing) readonly @endif value="{{ $v('patient_code') }}"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                        </label>
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Medical History</h3>
                    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col min-w-40 flex-1">
                            <p class="text-[#121416] text-base font-medium leading-normal pb-2">CC</p>
                            <textarea placeholder="Chief Complaint"
                                 name="cc"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] min-h-36 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal">{{ $v('cc') }}</textarea>
                        </label>
                    </div>
                    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col min-w-40 flex-1">
                            <p class="text-[#121416] text-base font-medium leading-normal pb-2">POHX</p>
                            <textarea placeholder="Past Ocular History"
                                 name="pohx"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] min-h-36 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal">{{ $v('pohx') }}</textarea>
                        </label>
                    </div>
                    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col min-w-40 flex-1">
                            <p class="text-[#121416] text-base font-medium leading-normal pb-2">LEE</p>
                            <textarea placeholder="Last Eye Exam"
                                 name="lee"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] min-h-36 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal">{{ $v('lee') }}</textarea>
                        </label>
                    </div>
                    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col min-w-40 flex-1">
                            <p class="text-[#121416] text-base font-medium leading-normal pb-2">PmHx</p>
                            <textarea placeholder="Past Medical History"
                                    name="pmhx"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] min-h-36 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal">{{ $v('pmhx') }}</textarea>
                        </label>
                    </div>
                    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                        <label class="flex flex-col min-w-40 flex-1">
                            <p class="text-[#121416] text-base font-medium leading-normal pb-2">PfoHx</p>
                            <textarea placeholder="Past Family Ocular History"
                                    name="pfohx"
                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] min-h-36 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal">{{ $v('pfohx') }}</textarea>
                        </label>
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Visual
                        Activity</h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th></th>
                                        <th
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            Unaided</th>
                                        <th
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            Pinhole</th>
                                        <th
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-360 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            Near V/A</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                        <td class="text-[#121416] text-base font-medium leading-normal pb-2">OD:</td>
                                        <td
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input name="ODunaided" value="{{ $v('ODunaided') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                        <td
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input name="ODpinhole" value="{{ $v('ODpinhole') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                        <td
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input name="ODnearVA" value="{{ $v('ODnearVA') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                    </tr>
                                    <tr class="border-t border-t-[#dde0e3]">
                                        <td class="text-[#121416] text-base font-medium leading-normal pb-2">OS:</td>
                                        <td
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input name="OSunaided" value="{{ $v('OSunaided') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                        <td
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input name="OSpinhole" value="{{ $v('OSpinhole') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                        <td
                                            class="table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input name="OSnearVA" value="{{ $v('OSnearVA') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px)

                                {
                                .table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px)

                                {
                                .table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-240 {
                                    display: none;
                                }
                            }

                            @container(max-width:360px)

                                {
                                .table-84efdf4d-6f29-4998-ac96-b8ff6bc2af6d-column-360 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Lensometry</h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            SPH</th>
                                         <th
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            CYL</th>
                                         <th
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            AXIS</th>
                                         <th
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            VA</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OD:</H1>
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                               name="ODSPH" value="{{ $v('ODSPH') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ODCYL" value="{{ $v('ODCYL') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ODAXIS" value="{{ $v('ODAXIS') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ODVA" value="{{ $v('ODVA') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal" />
                                        </td>
                                    </tr>
                                    
                                     <tr class="border-t border-t-[#dde0e3]">
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td> 
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="OSSPH" value="{{ $v('OSSPH') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="OSCYL" value="{{ $v('OSCYL') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                 name="OSAXIS" value="{{ $v('OSAXIS') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="OSVA" value="{{ $v('OSVA') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                />
                                        </td>
                                    </tr>


                                     <tr class="border-t border-t-[#dde0e3]">
                                            <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ADDSPH" value="{{ $v('ADDSPH') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ADDCYL" value="{{ $v('ADDCYL') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ADDAXIS" value="{{ $v('ADDAXIS') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="ADDVA" value="{{ $v('ADDVA') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px)

                                {
                                .table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px)

                                {
                                .table-813d7553-8f69-4f0b-b043-f2a935dc8386-column-240 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Auto-Refraction</h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            SPHERE</th>
                                        <th
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            CYL</th>
                                        <th
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            AXIS</th>        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OD:</H1>
                                        </td>
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="arodsph" value="{{ $v('arodsph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="arodcyl" value="{{ $v('arodcyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="arodaxis" value="{{ $v('arodaxis') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>

                                     <tr class="border-t border-t-[#dde0e3]">
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td>
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                 name="arosph" value="{{ $v('arosph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="aroscyl" value="{{ $v('aroscyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="arosaxis" value="{{ $v('arosaxis') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                   
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px)

                                {
                                .table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px)

                                {
                                .table-92717181-a147-4ddb-adb4-6625d5f172ab-column-240 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>
                    <div class="px-4 py-3">
                        <label for="arpd" class="block text-[#121416] text-base font-medium leading-normal pb-2">
                            P.D. (Pupillary Distance, mm)</label>
                        <input id="arpd" name="arpd" value="{{ $v('arpd') }}" type="number" step="any" min="40" max="85" placeholder="e.g. 62"
                            class="form-input flex w-full max-w-[240px] min-w-0 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] px-3 text-base font-normal leading-normal" />
                        @error('arpd')
                            <p class="text-sm text-red-600 pt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Retinoscope</h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            SPHERE</th>
                                        <th
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            CYL</th>
                                        <th
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            AXIS</th>        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                        <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OD:</H1>
                                        </td>
                                        <td
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="rodsph" value="{{ $v('rodsph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                         <td
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                              <input 
                                                 name="rodcyl" value="{{ $v('rodcyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                         <td
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input        
                                                 name="rodaxis" value="{{ $v('rodaxis') }}"                                
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                    <tr class="border-t border-t-[#dde0e3]">
                                         <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td>
                                        <td
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="rossph" value="{{ $v('rossph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                         <td
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                              <input 
                                                 name="roscyl" value="{{ $v('roscyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                         <td
                                            class="table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input  
                                                 name="rosaxis" value="{{ $v('rosaxis') }}"                                      
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px)

                                {
                                .table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px)

                                {
                                .table-bbcba2a0-62a2-4c7e-a50d-2ba8ff3dc7f1-column-240 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Subjective Refraction</h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            SPH
                                        </th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            CYL</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            AXIS</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            VA</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            ADD</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            NVA</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OD:</H1>
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="srodsph" value="{{ $v('srodsph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                               name="srodcyl" value="{{ $v('srodcyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="srodaxis" value="{{ $v('srodaxis') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                 name="srodva" value="{{ $v('srodva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                              <input 
                                                name="srodadd" value="{{ $v('srodadd') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="srodnva" value="{{ $v('srodnva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>

                                    <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="srosph" value="{{ $v('srosph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="sroscyl" value="{{ $v('sroscyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="srosaxis" value="{{ $v('srosaxis') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="srosva" value="{{ $v('srosva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                              <input 
                                                 name="srosadd" value="{{ $v('srosadd') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="srosnva" value="{{ $v('srosnva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px)

                                {
                                .table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px)

                                {
                                .table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 {
                                    display: none;
                                }
                            }

                            @container(max-width:360px)

                                {
                                .table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 {
                                    display: none;
                                }
                            }

                            @container(max-width:480px)

                                {
                                .table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>

                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">
                        Final RX</h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            SPH
                                        </th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            CYL</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            AXIS</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            VA</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            ADD</th>
                                        <th
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            NVA</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OD:</H1>
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="fodsph" value="{{ $v('fodsph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                               name="fodcyl" value="{{ $v('fodcyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="fodaxis" value="{{ $v('fodaxis') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                 name="fodva" value="{{ $v('fodva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                              <input 
                                                name="fodadd" value="{{ $v('fodadd') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="fodnva" value="{{ $v('fodnva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>

                                    <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="fossph" value="{{ $v('fossph') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                             <input 
                                                name="foscyl" value="{{ $v('foscyl') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="fosaxis" value="{{ $v('fosaxis') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="fosva" value="{{ $v('fosva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                              <input 
                                                 name="fosadd" value="{{ $v('fosadd') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-be3808f4-ae65-4348-847f-97c6c2c80b35-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                            <input 
                                                name="fosnva" value="{{ $v('fosnva') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                
                                </tbody>
                            </table>
                        </div>
                    <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">IOP
                    </h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            NCT</th>
                                         <th
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            CCT</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OD:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input
                                               name="odnct" value="{{ $v('odnct') }}"                                 
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                             
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                          name="odccct" value="{{ $v('odccct') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>

                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>OS:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                                name="osnct" value="{{ $v('osnct') }}"                               
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                                name="oscct" value="{{ $v('oscct') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="pt-3">
                            <label for="iop_taken_at" class="block text-[#121416] text-base font-medium leading-normal pb-2">
                                Date &amp; time IOP was taken</label>
                            <div class="flex items-center gap-2">
                                <input id="iop_taken_at" name="iop_taken_at" type="datetime-local" value="{{ $v('iop_taken_at') }}"
                                    class="form-input flex w-full max-w-[280px] min-w-0 rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 px-3 text-base font-normal leading-normal" />
                                <button type="button" id="iop-now"
                                    class="flex items-center justify-center rounded-xl h-14 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-bold">Now</button>
                            </div>
                            @error('iop_taken_at')
                                <p class="text-sm text-red-600 pt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <h3 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">External Examination And Internal Examination
                    </h3>
                    <div class="px-4 py-3 @container">
                        <div class="flex overflow-hidden rounded-xl border border-[#dde0e3] bg-white">
                            <table class="flex-1">
                                <thead>
                                    <tr class="bg-white">
                                        <th
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            </th>
                                        <th
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            OD</th>
                                         <th
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                            OS</th>    
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Eyelid:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input
                                               name="eyelidod" value="{{ $v('eyelidod') }}"                                 
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                           
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                            name="eyelidos" value="{{ $v('eyelidos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>

                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Conjuctiva:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                              name="conjuctivaod" value="{{ $v('conjuctivaod') }}"                            
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                            name="conjuctivaos" value="{{ $v('conjuctivaos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>

                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Cornea:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                               name="corneaod" value="{{ $v('corneaod') }}"                            
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                                name="corneaos" value="{{ $v('corneaos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Pupil:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                                 name="pupilod" value="{{ $v('pupilod') }}"                             
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                                name="pupilos" value="{{ $v('pupilos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Iris:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                               name="irisod" value="{{ $v('irisod') }}"                            
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                                name="irisos" value="{{ $v('irisos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Lens:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                              name="lensod" value="{{ $v('lensod') }}"                          
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                               name="lensos" value="{{ $v('lensos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Virtreous:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                                name="vitreousod" value="{{ $v('vitreousod') }}"                       
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                                name="vitreousos" value="{{ $v('vitreousos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>C/D Ratio:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                               name="cdratiood" value="{{ $v('cdratiood') }}"                               
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                               name="cdratioos" value="{{ $v('cdratioos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                     <tr class="border-t border-t-[#dde0e3]">
                                          <td
                                            class="table-92717181-a147-4ddb-adb4-6625d5f172ab-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal"><H1>Macula:</H1>
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                         <input  
                                                  name="macularod" value="{{ $v('macularod') }}"                            
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                        <td
                                            class="table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7581] text-sm font-normal leading-normal">
                                          <input 
                                                 name="maculaos" value="{{ $v('maculaos') }}"
                                                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121416] focus:outline-0 focus:ring-0 border border-[#dde0e3] bg-white focus:border-[#dde0e3] h-14 placeholder:text-[#6a7581] p-[15px] text-base font-normal leading-normal"
                                                 />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <style>
                            @container(max-width:120px)

                                {
                                .table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-120 {
                                    display: none;
                                }
                            }

                            @container(max-width:240px)

                                {
                                .table-2a0821a5-4bd2-415b-9ea6-35dff5cd1bb2-column-240 {
                                    display: none;
                                }
                            }
                        </style>
                    </div>

                    
                    <div class="flex px-4 py-3 justify-end">
                        <button type="submit" id="vitals-save" data-label="{{ $editing ? 'Save Changes' : 'Save' }}"
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-[#5e92c9] text-white text-sm font-bold leading-normal tracking-[0.015em]">
                            <span class="truncate">{{ $editing ? 'Save Changes' : 'Save' }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    (function () {
        var form = document.getElementById('vitals-form');
        var saveButton = document.getElementById('vitals-save');

        // Pressing Enter in a single-line field used to submit (save) the whole exam half-finished.
        // Now Enter moves to the next field instead; only the Save button saves. Enter still adds new lines in text boxes.
        form.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' || event.target.tagName !== 'INPUT') {
                return;
            }
            event.preventDefault();
            var fields = Array.prototype.filter.call(form.elements, function (el) {
                return (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') && el.type !== 'hidden' && !el.disabled && !el.readOnly;
            });
            var next = fields[fields.indexOf(event.target) + 1];
            if (next) {
                next.focus();
            }
        });

        // "Now" fills the IOP time from this computer's clock (local time, to the minute).
        document.getElementById('iop-now').addEventListener('click', function () {
            var now = new Date();
            var pad = function (n) { return String(n).padStart(2, '0'); };
            document.getElementById('iop_taken_at').value = now.getFullYear() + '-' + pad(now.getMonth() + 1) + '-' + pad(now.getDate())
                + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
        });

        // Lock the Save button after the first click so a double click can't save twice.
        form.addEventListener('submit', function () {
            saveButton.disabled = true;
            saveButton.classList.add('opacity-60', 'cursor-not-allowed');
            saveButton.querySelector('span').textContent = 'Saving…';
        });

        // If the browser restores this page from history (Back button), unlock the button again.
        // The one-time form token still stops the same exam being saved a second time.
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                saveButton.disabled = false;
                saveButton.classList.remove('opacity-60', 'cursor-not-allowed');
                saveButton.querySelector('span').textContent = saveButton.dataset.label;
            }
        });
    })();
</script>    
</body>

</html>
