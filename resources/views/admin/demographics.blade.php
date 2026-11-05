<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Demographics</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar')
    <div
      class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden"
      style='--select-button-svg: url(&apos;data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(78,122,151)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e&apos;); font-family: "Public Sans", "Noto Sans", sans-serif;'
    >
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7eef3] px-10 py-3">
          <div class="flex items-center gap-4 text-[#0e161b]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4 42.4379C4 42.4379 14.0962 36.0744 24 41.1692C35.0664 46.8624 44 42.2078 44 42.2078L44 7.01134C44 7.01134 35.068 11.6577 24.0031 5.96913C14.0971 0.876274 4 7.27094 4 7.27094L4 42.4379Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#0e161b] text-lg font-bold leading-tight tracking-[-0.015em]">Admin Panel</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="#">Dashboard</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="#">Patients</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="#">Appointments</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="#">Departments</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="#">Staff</a>
              <a class="text-[#0e161b] text-sm font-medium leading-normal" href="#">Reports</a>
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
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCyhYHqpRq40UJFE_ac9NAODcbcD5BcHD0UUE5lda0R8yQc8dqV0Dbtz0VpB6Xpe-RHveWaKa1YgNMSd57GV919WhHteWzw4nEzt2SxWXdsJPv9tBrVCNpFMhUXM4UZ9xexE_BQjQFBi3D5vejsPFlJsVUZMFG7SJHBPQTp0vEoD61hQdVzwrPL9QdEjHUSbAy7tPl7uKiafRzr2UBIGpwT6kPC3qVYCIsKGpPYo70MJ7DAPbZdhWVuXV73tz3_h3_pwDcr2DZxsbw");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              {{-- <div class="flex min-w-72 flex-col gap-3">
                <p class="text-[#0e161b] tracking-light text-[32px] font-bold leading-tight">Reports</p>
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Generate and view reports on various hospital metrics.</p>
              </div>
            </div>
            <div class="pb-3">
              <div class="flex border-b border-[#d0dee7] px-4 gap-8">
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-[#1993e5] text-[#0e161b] pb-[13px] pt-4" href="#">
                  <p class="text-[#0e161b] text-sm font-bold leading-normal tracking-[0.015em]">Patient Demographics</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7a97] pb-[13px] pt-4" href="#">
                  <p class="text-[#4e7a97] text-sm font-bold leading-normal tracking-[0.015em]">Appointment Statistics</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7a97] pb-[13px] pt-4" href="#">
                  <p class="text-[#4e7a97] text-sm font-bold leading-normal tracking-[0.015em]">Department Performance</p>
                </a>
                <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#4e7a97] pb-[13px] pt-4" href="#">
                  <p class="text-[#4e7a97] text-sm font-bold leading-normal tracking-[0.015em]">Staff Utilization</p>
                </a>
              </div> --}}
            </div>
            <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Patient Demographics</h2>
            {{-- <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <select
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] h-14 bg-[image:--select-button-svg] placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >
                  <option value="one"></option>
                  <option value="two">two</option>
                  <option value="three">three</option>
                </select>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <select
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] h-14 bg-[image:--select-button-svg] placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >
                  <option value="one"></option>
                  <option value="two">two</option>
                  <option value="three">three</option>
                </select>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <select
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e161b] focus:outline-0 focus:ring-0 border border-[#d0dee7] bg-slate-50 focus:border-[#d0dee7] h-14 bg-[image:--select-button-svg] placeholder:text-[#4e7a97] p-[15px] text-base font-normal leading-normal"
                >
                  <option value="one"></option>
                  <option value="two">two</option>
                  <option value="three">three</option>
                </select>
              </label>
            </div>
            <div class="flex px-4 py-3 justify-start">
              <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Generate Report</span>
              </button>
            </div> --}}
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Age Group
                      </th>
                      <th class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Male</th>
                      <th class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Female</th>
                      <th class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">0-18</td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['0-18']['male'] }}   </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['0-18']['female'] }}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['0-18']['female'] +  $ageGroups['0-18']['male'] }}    </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">19-35</td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['19-35']['male'] }}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['19-35']['female'] }}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['19-35']['male'] + $ageGroups['19-35']['female']   }}  </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">36-55</td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['36-55']['male'] }} </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['36-55']['female'] }}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['19-35']['male'] + $ageGroups['19-35']['female'] }}  </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">56-75</td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['56-75']['male'] }} </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">   {{ $ageGroups['56-75']['female'] }} </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['36-55']['male'] + $ageGroups['36-55']['male'] }} </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">75+</td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{ $ageGroups['75+']['male'] }}     </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['75+']['female'] }}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $ageGroups['75+']['male'] + $ageGroups['75+']['female']  }}  </td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">total</td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">  {{  $totals['male']}}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $totals['female'] }}  </td>
                      <td class="table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal"> {{ $totals['male'] + $totals['female']  }}  </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <style>
                          @container(max-width:120px){.table-aed2199f-157d-4358-b272-11c8d1873a7e-column-120{display: none;}}
                @container(max-width:240px){.table-aed2199f-157d-4358-b272-11c8d1873a7e-column-240{display: none;}}
                @container(max-width:360px){.table-aed2199f-157d-4358-b272-11c8d1873a7e-column-360{display: none;}}
                @container(max-width:480px){.table-aed2199f-157d-4358-b272-11c8d1873a7e-column-480{display: none;}}
              </style>
            </div>
            {{-- <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-lg border border-[#d0dee7] bg-slate-50">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-slate-50">
                      <th class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-120 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Insurance Provider
                      </th>
                      <th class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-240 px-4 py-3 text-left text-[#0e161b] w-[400px] text-sm font-medium leading-normal">
                        Number of Patients
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        Blue Shield
                      </td>
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">450</td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">
                        United Healthcare
                      </td>
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">350</td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Aetna</td>
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">200</td>
                    </tr>
                    <tr class="border-t border-t-[#d0dee7]">
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-120 h-[72px] px-4 py-2 w-[400px] text-[#0e161b] text-sm font-normal leading-normal">Other</td>
                      <td class="table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-240 h-[72px] px-4 py-2 w-[400px] text-[#4e7a97] text-sm font-normal leading-normal">150</td>
                    </tr>
                  </tbody>
                </table>
              </div> --}}
              <style>
                          @container(max-width:120px){.table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-120{display: none;}}
                @container(max-width:240px){.table-c82baba0-5e7e-4104-926f-cf34c4d0ab58-column-240{display: none;}}
              </style>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
