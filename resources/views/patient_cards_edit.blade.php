<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900"
    />
    <title>Edit Patient</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  </head>
  <body>
@include('partials.session-bar')
    <div class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden" style='font-family: "Public Sans", "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <div class="gap-1 px-6 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-80">
            <div class="flex h-full min-h-[700px] flex-col justify-between bg-slate-50 p-4">
              <div class="flex flex-col gap-4">
                <h1 class="text-[#0e161b] text-base font-medium leading-normal">{{ config('clinic.short_name') }}</h1>
                <div class="flex flex-col gap-2">
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#0e161b]" data-icon="House" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M218.83,103.77l-80-75.48a1.14,1.14,0,0,1-.11-.11,16,16,0,0,0-21.53,0l-.11.11L37.17,103.77A16,16,0,0,0,32,115.55V208a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V160h32v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V115.55A16,16,0,0,0,218.83,103.77ZM208,208H160V160a16,16,0,0,0-16-16H112a16,16,0,0,0-16,16v48H48V115.55l.11-.1L128,40l79.9,75.43.11.1Z"></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Dashboard</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-[#e7eef3]">
                    <div class="text-[#0e161b]" data-icon="Users" data-size="24px" data-weight="fill">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M164.47,195.63a8,8,0,0,1-6.7,12.37H10.23a8,8,0,0,1-6.7-12.37,95.83,95.83,0,0,1,47.22-37.71,60,60,0,1,1,66.5,0A95.83,95.83,0,0,1,164.47,195.63Zm87.91-.15a95.87,95.87,0,0,0-47.13-37.56A60,60,0,0,0,144.7,54.59a4,4,0,0,0-1.33,6A75.83,75.83,0,0,1,147,150.53a4,4,0,0,0,1.07,5.53,112.32,112.32,0,0,1,29.85,30.83,23.92,23.92,0,0,1,3.65,16.47,4,4,0,0,0,3.95,4.64h60.3a8,8,0,0,0,7.73-5.93A8.22,8.22,0,0,0,252.38,195.48Z"></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Patients</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#0e161b]" data-icon="Calendar" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M208,32H184V24a8,8,0,0,0-16,0v8H88V24a8,8,0,0,0-16,0v8H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM72,48v8a8,8,0,0,0,16,0V48h80v8a8,8,0,0,0,16,0V48h24V80H48V48ZM208,208H48V96H208V208Zm-96-88v64a8,8,0,0,1-16,0V132.94l-4.42,2.22a8,8,0,0,1-7.16-14.32l16-8A8,8,0,0,1,112,120Zm59.16,30.45L152,176h16a8,8,0,0,1,0,16H136a8,8,0,0,1-6.4-12.8l28.78-38.37A8,8,0,1,0,145.07,132a8,8,0,1,1-13.85-8A24,24,0,0,1,176,136,23.76,23.76,0,0,1,171.16,150.45Z"></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Appointments</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#0e161b]" data-icon="Buildings" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M240,208H224V96a16,16,0,0,0-16-16H144V32a16,16,0,0,0-24.88-13.32L39.12,72A16,16,0,0,0,32,85.34V208H16a8,8,0,0,0,0,16H240a8,8,0,0,0,0-16ZM208,96V208H144V96ZM48,85.34,128,32V208H48ZM112,112v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm-32,0v16a8,8,0,0,1-16,0V112a8,8,0,1,1,16,0Zm0,56v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Zm32,0v16a8,8,0,0,1-16,0V168a8,8,0,0,1,16,0Z"></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Departments</p>
                  </div>
                  <div class="flex items-center gap-3 px-3 py-2">
                    <div class="text-[#0e161b]" data-icon="UsersThree" data-size="24px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M244.8,150.4a8,8,0,0,1-11.2-1.6A51.6,51.6,0,0,0,192,128a8,8,0,0,1-7.37-4.89,8,8,0,0,1,0-6.22A8,8,0,0,1,192,112a24,24,0,1,0-23.24-30,8,8,0,1,1-15.5-4A40,40,0,1,1,219,117.51a67.94,67.94,0,0,1,27.43,21.68A8,8,0,0,1,244.8,150.4ZM190.92,212a8,8,0,1,1-13.84,8,57,57,0,0,0-98.16,0,8,8,0,1,1-13.84-8,72.06,72.06,0,0,1,33.74-29.92,48,48,0,1,1,58.36,0A72.06,72.06,0,0,1,190.92,212ZM128,176a32,32,0,1,0-32-32A32,32,0,0,0,128,176ZM72,120a8,8,0,0,0-8-8A24,24,0,1,1,87.24,82a8,8,0,1,0,15.5-4A40,40,0,1,0,37,117.51,67.94,67.94,0,0,0,9.6,139.19a8,8,0,1,0,12.8,9.61A51.6,51.6,0,0,1,64,128,8,8,0,0,0,72,120Z"></path>
                      </svg>
                    </div>
                    <p class="text-[#0e161b] text-sm font-medium leading-normal">Staff</p>
                  </div>
                </div>
              </div>
              <div class="flex flex-col gap-4">
                <a href="{{ route('patient.show', $user->id) }}"
                  class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#e7eef3] text-[#0e161b] text-sm font-bold leading-normal tracking-[0.015em]"
                >
                  <span class="truncate">Back to Details</span>
                </a>
              </div>
            </div>
          </div>
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-3">
                <p class="text-[#0e161b] tracking-light text-[32px] font-bold leading-tight">Edit Patient Details</p>
                <p class="text-[#4e7a97] text-sm font-normal leading-normal">Update patient information</p>
              </div>
            </div>
            @if(session('success'))
              <div class="px-4 py-3 bg-green-100 text-green-800 text-sm rounded-lg mx-4 mb-4">{{ session('success') }}</div>
            @endif
            <form action="{{ route('patient.update', $user->id) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="p-4 grid grid-cols-2 gap-x-4">
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">First Name</label>
                  <input type="text" name="first_name" value="{{ $user->first_name }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Last Name</label>
                  <input type="text" name="last_name" value="{{ $user->last_name }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Gender</label>
                  <select name="gender" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                  </select>
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Age</label>
                  <input type="text" name="age" value="{{ $user->age }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Address</label>
                  <input type="text" name="street" value="{{ $user->street }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Phone</label>
                  <input type="text" name="phone" value="{{ $user->phone }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Email</label>
                  <input type="email" name="email" value="{{ $user->email }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Occupation</label>
                  <input type="text" name="occupation" value="{{ $user->occupation }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Emergency Contact Name</label>
                  <input type="text" name="emergency_fullname" value="{{ $user->emergency_fullname }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pl-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Emergency Contact Phone</label>
                  <input type="text" name="emergency_phone" value="{{ $user->emergency_phone }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
              </div>
              <h2 class="text-[#0e161b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Current Status</h2>
              <div class="p-4 grid grid-cols-2 gap-x-4">
                <div class="flex flex-col gap-1 border-t border-solid border-t-[#d0dee7] py-4 pr-2">
                  <label class="text-[#4e7a97] text-sm font-normal leading-normal">Last Visit Date</label>
                  <input type="date" name="datee" value="{{ $user->datee }}" class="border border-[#d0dee7] rounded-lg px-3 py-2 text-sm text-[#0e161b] bg-white">
                </div>
              </div>
              <div class="flex px-4 py-4 gap-3">
                <button type="submit" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#1993e5] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]">
                  <span class="truncate">Save Changes</span>
                </button>
                <a href="{{ route('patient.show', $user->id) }}" class="flex min-w-[84px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#e7eef3] text-[#0e161b] text-sm font-bold leading-normal tracking-[0.015em]">
                  <span class="truncate">Cancel</span>
                </a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
