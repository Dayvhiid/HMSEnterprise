<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Manrope%3Awght%40400%3B500%3B700%3B800&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Treatment Plan</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar')
    <form method="POST" action="{{route('treatment.store')}}">
      @csrf
    <div
      class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden"
      style="--checkbox-tick-svg: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(18,20,23)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z%27/%3e%3c/svg%3e'); --select-button-svg: url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2724px%27 height=%2724px%27 fill=%27rgb(103,117,131)%27 viewBox=%270 0 256 256%27%3e%3cpath d=%27M181.66,170.34a8,8,0,0,1,0,11.32l-48,48a8,8,0,0,1-11.32,0l-48-48a8,8,0,0,1,11.32-11.32L128,212.69l42.34-42.35A8,8,0,0,1,181.66,170.34Zm-96-84.68L128,43.31l42.34,42.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,85.66Z%27%3e%3c/path%3e%3c/svg%3e'); font-family: Manrope, &quot;Noto Sans&quot;, sans-serif;"
    >
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f1f2f4] px-10 py-3">
          <div class="flex items-center gap-4 text-[#121417]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M13.8261 17.4264C16.7203 18.1174 20.2244 18.5217 24 18.5217C27.7756 18.5217 31.2797 18.1174 34.1739 17.4264C36.9144 16.7722 39.9967 15.2331 41.3563 14.1648L24.8486 40.6391C24.4571 41.267 23.5429 41.267 23.1514 40.6391L6.64374 14.1648C8.00331 15.2331 11.0856 16.7722 13.8261 17.4264Z"
                  fill="currentColor"
                ></path>
                <path
                  fill-rule="evenodd"
                  clip-rule="evenodd"
                  d="M39.998 12.236C39.9944 12.2537 39.9875 12.2845 39.9748 12.3294C39.9436 12.4399 39.8949 12.5741 39.8346 12.7175C39.8168 12.7597 39.7989 12.8007 39.7813 12.8398C38.5103 13.7113 35.9788 14.9393 33.7095 15.4811C30.9875 16.131 27.6413 16.5217 24 16.5217C20.3587 16.5217 17.0125 16.131 14.2905 15.4811C12.0012 14.9346 9.44505 13.6897 8.18538 12.8168C8.17384 12.7925 8.16216 12.767 8.15052 12.7408C8.09919 12.6249 8.05721 12.5114 8.02977 12.411C8.00356 12.3152 8.00039 12.2667 8.00004 12.2612C8.00004 12.261 8 12.2607 8.00004 12.2612C8.00004 12.2359 8.0104 11.9233 8.68485 11.3686C9.34546 10.8254 10.4222 10.2469 11.9291 9.72276C14.9242 8.68098 19.1919 8 24 8C28.8081 8 33.0758 8.68098 36.0709 9.72276C37.5778 10.2469 38.6545 10.8254 39.3151 11.3686C39.9006 11.8501 39.9857 12.1489 39.998 12.236ZM4.95178 15.2312L21.4543 41.6973C22.6288 43.5809 25.3712 43.5809 26.5457 41.6973L43.0534 15.223C43.0709 15.1948 43.0878 15.1662 43.104 15.1371L41.3563 14.1648C43.104 15.1371 43.1038 15.1374 43.104 15.1371L43.1051 15.135L43.1065 15.1325L43.1101 15.1261L43.1199 15.1082C43.1276 15.094 43.1377 15.0754 43.1497 15.0527C43.1738 15.0075 43.2062 14.9455 43.244 14.8701C43.319 14.7208 43.4196 14.511 43.5217 14.2683C43.6901 13.8679 44 13.0689 44 12.2609C44 10.5573 43.003 9.22254 41.8558 8.2791C40.6947 7.32427 39.1354 6.55361 37.385 5.94477C33.8654 4.72057 29.133 4 24 4C18.867 4 14.1346 4.72057 10.615 5.94478C8.86463 6.55361 7.30529 7.32428 6.14419 8.27911C4.99695 9.22255 3.99999 10.5573 3.99999 12.2609C3.99999 13.1275 4.29264 13.9078 4.49321 14.3607C4.60375 14.6102 4.71348 14.8196 4.79687 14.9689C4.83898 15.0444 4.87547 15.1065 4.9035 15.1529C4.91754 15.1762 4.92954 15.1957 4.93916 15.2111L4.94662 15.223L4.95178 15.2312ZM35.9868 18.996L24 38.22L12.0131 18.996C12.4661 19.1391 12.9179 19.2658 13.3617 19.3718C16.4281 20.1039 20.0901 20.5217 24 20.5217C27.9099 20.5217 31.5719 20.1039 34.6383 19.3718C35.082 19.2658 35.5339 19.1391 35.9868 18.996Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#121417] text-lg font-bold leading-tight tracking-[-0.015em]">Treatment Plan</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#121417] text-sm font-medium leading-normal" href="/doctors/index">Dashboard</a>
              <a class="text-[#121417] text-sm font-medium leading-normal" href="/search/treatment"> Search Treatment</a>
            
            </div>
            <div
              class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
              style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDcvEOVz5If7L94apMROTk8tX3WW_XlpCHBzyJ1nsMPUM0UHAHjgSnb3-Mrcyu1Wl6M6qY5B6KEuGqGpgugEPrTuiStTNnMj5JCttD23ZOMDfVRCY4uI4pLuQquVBYvg_dNfnyoO7qKwJ_Sr56htZ5AvfoHFh6rx5UQhdvtNXDwAaYJPm5GuazuAZEoHyZIYBd9dgNJx9gVft-37O9EUigfqM-c0Qg41XmaavgY5OkqfiaCCgPE4iLWR2mi8jD2r30xpVjMEKH4sok");'
            ></div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-[512px] max-w-[512px] py-5 max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <p class="text-[#121417] tracking-light text-[32px] font-bold leading-tight min-w-72">Treatment Plan &amp; Lens Prescription</p>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">Patient ID</p>
                <input
                  name="patient_id"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                  required
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">Dosage</p>
                <input
                   name="dosage"
                  placeholder="Enter dosage"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">Duration</p>
                <select
                  name="duration"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 bg-[image:--select-button-svg] placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                >
                      <option>1 Day</option>
                      <option>2 Day</option>
                      <option>3 Day</option>
                      <option>4 Day</option>
                      <option>5 Day</option>
                      <option>6 Day</option>
                      <option>1 week</option>
                      <option>2 weeks</option>
                      <option>3 weeks</option>
                      <option>1 Month</option>
                </select>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">TAB</p>
                <input
                  name="tab"
                  placeholder="Enter TAB"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">GUTT</p>
                <input
                  name="gutt"
                  placeholder="Enter GUTI"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">OC</p>
                <input
                 name="oc" 
                  placeholder="Enter OC"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">SUR</p>
                <input
                 name="sur"
                  placeholder="Enter SUR"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">RTC</p>
                <input
                  name="rtc"
                  placeholder="Enter RTC"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                  value=""
                />
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">Prescription</p>
                <textarea
                 name="prescription"
                  placeholder="Enter prescription details"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] min-h-36 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                ></textarea>
              </label>
            </div>
            <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
              <label class="flex flex-col min-w-40 flex-1">
                <p class="text-[#121417] text-base font-medium leading-normal pb-2">Remarks</p>
                <textarea
                   name="remark"
                  placeholder="Enter any remarks"
                  class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] min-h-36 placeholder:text-[#677583] p-[15px] text-base font-normal leading-normal"
                ></textarea>
              </label>
            </div>
            <h2 class="text-[#121417] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Lens Type</h2>
            <h5>Single Vision Tintable</h5>
            <div class="px-4">
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="singlevision[]"
                  type="checkbox"
                  value="single vision tintable"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Single Vision Tintable Photochromic</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="singlevision[]"
                  type="checkbox"
                  value="single vision tintable photochromic"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Single Vision Transition A/R</p>
              </label>
               <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="singlevision[]"
                  type="checkbox"
                  value="single vision transition A/R"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Single Vision Transition A/R B/C</p>
              </label>
            </div>
            {{-- Bifocal --}}
            <h2>Bifocal Tintable</h2>
            <div class="px-4">
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="bifocal[]"
                  type="checkbox"
                  value="bifocal tintable"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Bifocal transition A/R</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="bifocal[]"
                  type="checkbox"
                  value="bifocal transition A/R"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Bifocal transition A/R B/C</p>
              </label>
            </div>
            {{-- Special Order Single Vision Tintable --}}
            <h2>Special Order Single Vision Vision Tintable</h2>
            <div class="px-4">
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="specialorder[]"
                  type="checkbox"
                  value="Single Order Single vision tintable"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
    
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Special Order Fused Bifocal Tintable</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="specialorder[]"
                  type="checkbox"
                  value="Special Order Fused Bifocal Tintable"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Special Order DTOP Bifocal Tintable</p>
              </label>
               <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="specialorder[]"
                  type="checkbox"
                  value="Special Order DTOP Bifocal Tintable"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Special Order Fused Bifocal A/R</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="specialorder[]"
                  type="checkbox"
                  value="Special Order Fused Bifocal A/R"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Special Order DTOP A/R</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="specialorder[]"
                  type="checkbox"
                  value="Special Order DTOP A/R"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Special Order Fused Bifocal A/R B/C</p>
              </label>
               <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="specialorder[]"
                  type="checkbox"
                  value="Special Order Fused Bifocal A/R B/C"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Special Order DTOP Bifocal A/R B/C</p>
              </label>
              {{-- Invisible --}}
               <h2>Progressive</h2>
               <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="progressive[]"
                  type="checkbox"
                  value="Progressive Tintable"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Progressive Tintable</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="progressive[]"
                  type="checkbox"
                  value="Progressive Tintable A/R"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Progressive Tintable A/R</p>
              </label>
              <label class="flex gap-x-3 py-3 flex-row">
                <input
                  name="progressive[]"
                  type="checkbox"
                  value="Progressive Tintable A/R B/C"
                  class="h-5 w-5 rounded border-[#dde0e4] border-2 bg-transparent text-[#d2e2f3] checked:bg-[#d2e2f3] checked:border-[#d2e2f3] checked:bg-[image:--checkbox-tick-svg] focus:ring-0 focus:ring-offset-0 focus:border-[#dde0e4] focus:outline-none"
                />
                <p class="text-[#121417] text-base font-normal leading-normal">Progressive Tintable A/R B/C</p>
              </label>
            </div>
             <footer class="flex justify-center">
          <div class="flex max-w-[960px] flex-1 flex-col">
            <div class="flex justify-stretch">
              <div class="flex flex-1 gap-3 flex-wrap px-4 py-3 justify-end">
                <button
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#f1f2f4] text-[#121417] text-sm font-bold leading-normal tracking-[0.015em]"
                >
                  <span class="truncate">Cancel</span>
                </button>
                <button
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#d2e2f3] text-[#121417] text-sm font-bold leading-normal tracking-[0.015em]"
                >
                  <span class="truncate">Save</span>
                </button>
              </div>
            </div>
          </div>
        </footer>
            </div>
          </div>
        </div>
        {{-- <footer class="flex justify-center">
          <div class="flex max-w-[960px] flex-1 flex-col">
            <div class="flex justify-stretch">
              <div class="flex flex-1 gap-3 flex-wrap px-4 py-3 justify-end">
                <button
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#f1f2f4] text-[#121417] text-sm font-bold leading-normal tracking-[0.015em]"
                >
                  <span class="truncate">Cancel</span>
                </button>
                <button
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#d2e2f3] text-[#121417] text-sm font-bold leading-normal tracking-[0.015em]"
                >
                  <span class="truncate">Save</span>
                </button>
              </div>
            </div>
          </div>
        </footer> --}}
      </div>
    </div>
    </form>
  </body>
</html>
