<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Lens</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar')
    <form method="POST" action="{{ route('lens.store') }}">
    @csrf
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f1f2f4] px-10 py-3">
          <div class="flex items-center gap-4 text-[#121416]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4 42.4379C4 42.4379 14.0962 36.0744 24 41.1692C35.0664 46.8624 44 42.2078 44 42.2078L44 7.01134C44 7.01134 35.068 11.6577 24.0031 5.96913C14.0971 0.876274 4 7.27094 4 7.27094L4 42.4379Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#121416] text-lg font-bold leading-tight tracking-[-0.015em]">Lenses</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <button
              class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 bg-[#f1f2f4] text-[#121416] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
            >
              
            </button>
            <nav class="flex items-center gap-8">
                    <a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200"
                        href=" {{ route('lens.list') }} ">Lens List</a>
                </nav>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAodQrXkhRVwSa95Mo5rgyvTwAnPljtqRABiVfcSRJ6uEOT1jw9213JcPRle2-rUrqsrrZL8kQ8YyjESsBlLDdeuu1FzCojabenrVGn-IBnEe2GFp-GdIYHKjsgradkPQaM66M9Cae10ZG3DyUvF2Af3WDiNVg6h5rk8bM8FSRYdE_Zr_KsvHFngHqwrIppGo9O_oeMdsYxcEnVz0JVbZBrLaQld_ITv9LV0QWqoU7oPjY9j7UPFI7MN27qLKGm_GT6xK2fJxx24sxy");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">Enter Lens Details</p></div>
            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-xl border border-[#dde1e3] bg-white">
                <table class="flex-1" id="patientTable">
                  <thead>
                    <tr class="bg-white">
                      <th class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">SN</th>
                      <th class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                         Lens Name
                      </th>
                      <th class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-480 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                        Price
                      </th>
                      <th class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-600 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                        ID
                      </th>
                      <th class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-840 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                        Quantity
                      </th>
                      <th class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-840 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                        Action
                      </th>
                    </tr>
                  </thead>
                  <tbody id="tableBody">
                    <tr class="border-t border-t-[#dde1e3]">
                      <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                        <input
                            type="text"
                            name="inputs[0][sn]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                               <input
                                    type="text"
                                     name="inputs[0][name]"
                                    class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                                    value=""
                                    />
                      </td>
                      <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                            <input
                            type="text"
                            name="inputs[0][price]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                            <input
                            type="text"
                            name="inputs[0][special_code]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                             <input
                            type="text"
                            name="inputs[0][quantity]"
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                            value=""
                            />
                      </td>
                      <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-840 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                        <button type="button" onclick="addNewRow()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                          Add
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div class="flex px-4 py-3 justify-end">
              <button
                type="submit"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#0c7ff2] text-white text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Submit</span>
              </button>
            </div>
               </form>  
              <style>
                          @container(max-width:120px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-120{display: none;}}
                @container(max-width:240px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-240{display: none;}}
                @container(max-width:360px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-360{display: none;}}
                @container(max-width:480px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-480{display: none;}}
                @container(max-width:600px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-600{display: none;}}
                @container(max-width:720px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-720{display: none;}}
                @container(max-width:840px){.table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-840{display: none;}}
              </style>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>


        let rowCount = 1;
      function addNewRow() {
        // Get the table body
        const tableBody = document.getElementById('tableBody');
        
        // Create a new row
        const newRow = document.createElement('tr');
        newRow.className = 'border-t border-t-[#dde1e3]';
        
        // Add cells to the row with the same structure as the existing row
        newRow.innerHTML = `
          <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-120 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
            <input
              type="text"
              name="inputs[${rowCount}][sn]"
              class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
               value="${rowCount + 1}"
            />
          </td>
          <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
            <input
              type="text"
              name="inputs[${rowCount}][name]"
              class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
              value=""
            />
          </td>
          <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
            <input
              type="text"
              name="inputs[${rowCount}][price]"
              class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
              value=""
            />
          </td>
          <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-480 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
            <input
              type="text"
              name="inputs[${rowCount}][special_code]"
              class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
              value=""
            />
          </td>
          <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-600 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
            <input
              type="text"
              name="inputs[${rowCount}][quantity]"
              class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
              value=""
            />
          </td>
          </td>
          <td class="table-bd426a45-3b65-4bc2-a180-0d5449f4261c-column-840 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
            <button onclick="addNewRow()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              Add
            </button>
          </td>
        `;
        
        // Append the new row to the table body
        tableBody.appendChild(newRow);
        rowCount++;
        
      }
    </script>
  </body>
</html>
