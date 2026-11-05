{{-- <style>
  .W-sidebar{
    height: 60vh;
  }
  ul li{
    margin-bottom: 10vh;
  }
  /* General styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  color: #333; /* Adjust text color for better contrast */
}

h1 {
  font-size: 2rem;
  margin-bottom: 1rem;
  text-align: center;
}

table {
  width: 100%; /* Ensure table fills container */
  border-collapse: collapse;
}

th, td {
  padding: 0.5rem 1rem;
  border: 1px solid #ddd;
  text-align: left; /* Align content to the left */
}

th {
  background-color: #f2f2f2;
  font-weight: bold;
}

/* Navigation bar styles (using Bootstrap classes) */
.navbar-brand {
  font-weight: bold;
  color: #007bff; /* Brand color */
}

.nav-link {
  color: #333; /* Adjust link color for better contrast */
  margin-right: 1rem; /* Add some spacing between links */
}

.nav-link:hover {
  color: #007bff; /* Highlight on hover */
}

/* Appointments table styling */
.appointments {
  padding: 1rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  margin-top: 2rem; /* Add some margin for better separation */
}

.btn-primary {
  background-color: #007bff; /* Primary button color */
  border-color: #007bff;
  color: white;
}

.btn-primary:hover {
  background-color: #0069d9; /* Adjust hover color slightly darker */
  border-color: #0069d9;
}
.complaint-text {
  width: 200px; /* Adjust as needed */
  overflow: hidden;
 
  text-overflow: ellipsis;

  white-space: nowrap;
}



@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;800&display=swap');

:root {
  --primary-red: hsl(1, 90%, 64%);
  --primary-blue: hsl(219, 85%, 26%);

  --neutral-white: hsl(0, 0%, 100%);
  --neutral-very-light-grayish-blue: hsl(210, 60%, 98%);
  --neutral-light-grayish-blue-1: hsl(211, 68%, 94%);
  --neutral-light-grayish-blue-2: hsl(205, 33%, 90%);
  --neutral-dark-grayish-blue: hsl(219, 12%, 42%);
  --neutral-very-dark-blue: hsl(224, 21%, 14%);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 16px;
  color: var(--neutral-very-dark-blue);
}

.container {
  width: 1440px;
  margin: 0px auto;
  background: white;
  border: 1px solid var(--neutral-very-light-grayish-blue);
}

.attribution {
  margin: 50px auto 5px;
}

.app {
  width: 700px;
  margin: 50px auto;
  background: var(--neutral-white);
  border-radius: 20px;
  padding: 15px 25px;
}

.app .header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  height: 50px;
}

.header h2 {
  font-size: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
}

.header h2 .title {
  font-size: 20px;
}

.header h2 .unread-notification-number {
  text-align: center;
  background: var(--primary-blue);
  color: var(--neutral-white);
  width: 25px;
  height: 20px;
  font-size: 14px;
  border-radius: 5px;
}

.header p {
  color: var(--neutral-dark-grayish-blue);
  cursor: pointer;
}

.header p:hover {
  color: var(--primary-blue);
}

.app .body {
  margin-top: 15px;
}

.body .notification {
  background: var(--neutral-very-light-grayish-blue);
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  padding: 15px;
  border-radius: 10px;
  cursor: pointer;
  transition: all .3s ease-in-out;
  margin: 10px 0px;
}

.body .notification:hover {
  background: var(--neutral-light-grayish-blue-1);
}

.notification-click {
  animation: notification-click .5s ease-in-out forwards;
}

@keyframes notification-click {
  0% {
    background: var(--neutral-light-grayish-blue-1);
  }

  50% {
    background: var(--neutral-light-grayish-blue-2);
  }

  100% {
    background: none;
  }
}

.notification .avatar {
  width: 8%;
}

.notification .avatar img {
  width: 100%;
}

.notification .text {
  width: 92%;
}

.text .text-top p {
  color: var(--neutral-dark-grayish-blue);
}

.text .text-top p .profil-name {
  font-weight: 800;
}

.text .text-top p b {
  color: var(--neutral-dark-grayish-blue);
  display: inline-block;
}

.text .text-top p .unread-dot {
  display: inline-block;
  width: 10px;
  height: 10px;
  margin: 0px 0px 1px 7px;
  border-radius: 50%;
  background: var(--primary-red);
}

.text .text-bottom {
  color: rgba(94, 103, 120, .5);
}

.text .text-top p .b-blue {
  color: var(--primary-blue);
}

.notification.readed {
  background: none;
}

.notification.private-message .avatar {
  align-self: start;
}

.notification.private-message .avatar {
  align-self: start;
}

.notification.readed .text-bottom p {
  color: var(--neutral-dark-grayish-blue);
  padding: 20px;
  border: 1px solid var(--neutral-light-grayish-blue-2);
  margin-top: 10px;
}

.notification.readed .text p b {
  display: inline;
}

.notification.picture .avatar {
  width: 8%;
}

.notification.picture .text {
  width: 84%;
}

.notification.picture .commented-picture {
  width: 8%;
}

.notification.picture .commented-picture img {
  width: 100%;
}

/* responsive */
@media screen and (max-width: 375px) {
  * {
    font-size: 14px;
  }

  .container {
    width: 375px;
  }

  .app {
    width: 375px;
    margin: 0 auto;
    padding: 15px 15px;
  }

  .notification .avatar {
    width: 15%;
  }

  .notification .text {
    width: 85%;
  }

  .notification.readed .text-bottom p {
    font-size: 13px;
  }

  .notification.picture .avatar {
    width: 15%;
  }

  .notification.picture .text {
    width: 70%;
  }

  .notification.picture .commented-picture {
    width: 15%;
  }
}


/* Responsiveness */
@media (max-width: 768px) {
  .navbar-nav {
    flex-direction: column; /* Stack links vertically on smaller screens */
    align-items: center;
    margin-top: 1rem; /* Add some top margin for better layout */
  }

  .nav-link {
    margin-right: 0; /* Remove horizontal spacing on smaller screens */
  }

  table {
    font-size: 0.8rem; /* Adjust font size for better readability */
  }

  h1 {
    font-size: 1.5rem; /* Adjust heading size for smaller screens */
  }
}

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylsheet" href="css/doctorsIndex.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <title>{{ config('clinic.product_name') }}</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">Doctors</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link" href="{{route('pages.register')}}">Home</a>
              <a class="nav-link" href="{{route('search.treatment')}}">Search Treatment</a>
              <a class="nav-link" href="{{route('search.vitals')}}">Search Vitals</a>
              <a class="nav-link" href="{{ route('doctors.vitals')}}">Vitals</a>
              <a class="nav-link" href="{{route('doctors.treatment')}}">Treatment Plan</a>
              <a class="nav-link" href="{{route('calender')}}">Patient Management</a>
              <a class="nav-link" href="{{route('images.search')}}">Case Files</a>
            </div>
          </div>
        </div>
      </nav>
           
        <div class="appointments">
          <h1>Booking Appointment</h1>
          <table>
            <tr>
              <th>Name</th>
              <th>Date</th>
              <th>Time</th>
              <th>Compaints</th>
              <th>Confirm appointment status</th>
              {{-- <th>Confirm appointment status</th> --}}
              </tr>
            {{-- @forelse ($appointments as $appointment)
              <tr>
                <td>{{ $appointment->name }}</td>
                <td>{{ $appointment->date }}</td>
                <td>{{ $appointment->time }}</td>            
                  <td data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $appointment->complaints }}">
                    {{ $appointment->complaints  }} </td>
                <td>
                  <a href="{{route('sms.page', ['sms' => $appointment])}}">Send Sms</a>
                </td>
                {{-- <td>
                  <a href="{{route('newSMS', ['sms' => $appointment])}}">Send Sms 2</a>
                </td> --}}
                {{-- <td> <a href="{{route('frame.edit', ['frames' => $frame])}}">Edit</a></td> --}}
                </tr>
            {{-- @empty
              <tr><td colspan="4">No appointments found.</td></tr>
            @endforelse
          </table>
        </div>
      <!DOCTYPE html>
<html lang="en"> --}} --}}

{{--  --}}

  <!-- Feel free to remove these styles or customise in your own stylesheet ?? -->
  <style>
    .attribution {
      font-size: 11px;
      text-align: center;
    }

    .attribution a {
      color: hsl(228, 45%, 44%);
    }
  </style>

<body>
  <div class="container">
    <div class="app">
      <div class="header">
        <h2><span class="title">Notifications</span> <span class="unread-notification-number">3</span></h2>
      </div>
      <div class="body">
        @foreach ($notifications as $notification)
<div class="notification {{ $notification->status === 'unread' ? 'unreaded' : '' }}">
    <div class="avatar">
        {{-- <img src="{{ asset($notification->avatar) }}" alt="User Avatar"> --}}
    </div>
    <div class="text">
        <div class="text-top">
            <p>
                <span class="profil-name">{{ $notification->patient_name }}</span> 
                {{ $notification->message }}  <br>
                 <b>Patient ID<b> : {{ $notification->pid }}
                @if ($notification->status === 'unread')
                <span class="unread-dot"></span>
                @endif
            </p>
        </div>
        <div class="text-bottom"> {{ $notification->created_at->diffForHumans() }} </div>

    </div>
</div>
@endforeach

       
  </div>
  <script src="script.js"></script>
</body>

</html>

      <script>
        function reloadPage() {
    setInterval(function() {
        location.reload(); // Reload the current page
    }, 30000); // 120000 ms = 2 minutes
}

// Call the function to start reloading
reloadPage();

      </script>
      
</body>
</html> --}}



<html><head>
<meta charset="utf-8"/>
<link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect"/>
<link as="style" href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" onload="this.rel='stylesheet'" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<title>{{ config('clinic.product_name') }}</title>
<link href="data:image/x-icon;base64," rel="icon" type="image/x-icon"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>
<body class="bg-white" style='font-family: Lexend, "Noto Sans", sans-serif;'>
<div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 px-10 py-4 shadow-sm">
<div class="flex items-center gap-3 text-slate-800">
<svg class="size-7 text-[#1993e5]" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
<path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M2 17L12 22L22 17" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
<path d="M2 12L12 17L22 12" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
</svg>
<h1 class="text-xl font-bold leading-tight tracking-tight text-slate-900">MediConnect</h1>
</div>
<nav class="flex items-center gap-8">
<a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200" href="#">Doctors</a>
<a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200" href="#">Home</a>
<a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200" href="#">Search</a>
<a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200" href="#">Vitals</a>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border border-gray-200 shadow-sm" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDnoRkCLE4bExTFjpCm8IS1EzT7i6pY7T47r832KqIfnz_zq8OBwroxbH5-S1p0VEHOKuzsRqEF1iRrzjJ5Ezv5IBTWz7oZS3XOuKVPNBtcGqx7FNOrpoUSHjombGa3pgm9eTIe_Ph2e6HpWrgAp_-aduzAPFMRFB8nmcHKQNfySdNBODRzj_tnQcbktxOwwzhvbypsBsOM88wnleIOoy-dENzW-ThGjt8H9NyzV59I6otvvr4CP3XNz8Rmh8gNErZijlR6TMRDvHmI");'></div>
</nav>
</header>
<main class="flex-1 bg-slate-50 px-10 py-8">
<div class="mx-auto max-w-6xl">
<h2 class="text-3xl font-bold text-slate-800 mb-8">Booking Appointment</h2>
<div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-md mb-12 @container">
<table class="w-full">
<thead class="bg-slate-100">
<tr>
<th class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-120 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Name</th>
<th class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Date</th>
<th class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Time</th>
<th class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">
                      Complaints
                    </th>
<th class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-600 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-600">Action</th>
</tr>
</thead>
<tbody class="divide-y divide-gray-200">
<tr class="hover:bg-slate-50 transition-colors duration-150">
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-120 px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                      Sophia Clark
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      2024-03-15
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 px-6 py-4 whitespace-nowrap text-sm text-slate-600">10:00 AM</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 px-6 py-4 whitespace-nowrap text-sm text-slate-600">Headache</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-600 px-6 py-4 whitespace-nowrap text-sm">
<button class="inline-flex items-center gap-2 rounded-md bg-[#1993e5] px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#137abd] focus:outline-none focus:ring-2 focus:ring-[#1993e5] focus:ring-offset-2 transition-colors duration-200">
<span class="material-icons text-sm">sms</span> Send SMS
                      </button>
</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors duration-150">
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-120 px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                      Ethan Carter
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      2024-03-15
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 px-6 py-4 whitespace-nowrap text-sm text-slate-600">11:00 AM</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 px-6 py-4 whitespace-nowrap text-sm text-slate-600">Fever</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-600 px-6 py-4 whitespace-nowrap text-sm">
<button class="inline-flex items-center gap-2 rounded-md bg-[#1993e5] px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#137abd] focus:outline-none focus:ring-2 focus:ring-[#1993e5] focus:ring-offset-2 transition-colors duration-200">
<span class="material-icons text-sm">sms</span> Send SMS
                      </button>
</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors duration-150">
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-120 px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                      Olivia Bennett
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      2024-03-15
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 px-6 py-4 whitespace-nowrap text-sm text-slate-600">12:00 PM</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 px-6 py-4 whitespace-nowrap text-sm text-slate-600">Cough</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-600 px-6 py-4 whitespace-nowrap text-sm">
<button class="inline-flex items-center gap-2 rounded-md bg-[#1993e5] px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#137abd] focus:outline-none focus:ring-2 focus:ring-[#1993e5] focus:ring-offset-2 transition-colors duration-200">
<span class="material-icons text-sm">sms</span> Send SMS
                      </button>
</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors duration-150">
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-120 px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                      Liam Foster
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      2024-03-15
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 px-6 py-4 whitespace-nowrap text-sm text-slate-600">01:00 PM</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      Sore Throat
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-600 px-6 py-4 whitespace-nowrap text-sm">
<button class="inline-flex items-center gap-2 rounded-md bg-[#1993e5] px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#137abd] focus:outline-none focus:ring-2 focus:ring-[#1993e5] focus:ring-offset-2 transition-colors duration-200">
<span class="material-icons text-sm">sms</span> Send SMS
                      </button>
</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors duration-150">
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-120 px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                      Ava Harper
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      2024-03-15
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 px-6 py-4 whitespace-nowrap text-sm text-slate-600">02:00 PM</td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                      Body Aches
                    </td>
<td class="table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-600 px-6 py-4 whitespace-nowrap text-sm">
<button class="inline-flex items-center gap-2 rounded-md bg-[#1993e5] px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-[#137abd] focus:outline-none focus:ring-2 focus:ring-[#1993e5] focus:ring-offset-2 transition-colors duration-200">
<span class="material-icons text-sm">sms</span> Send SMS
                      </button>
</td>
</tr>
</tbody>
</table>
<style>
                @container (max-width:640px) {
                  .table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-240,
                  .table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-360 { display: none; }
                }
                @container (max-width:768px) {
                  .table-6918ea61-2ff9-470b-9d8c-fa491184ef0a-column-480 { display: none; }
                }
              </style>
</div>
<h2 class="text-2xl font-bold text-slate-800 mb-6">New Patient Registrations</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="rounded-lg border border-gray-200 bg-white shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
<div class="flex items-start gap-4">
<div class="size-16 rounded-full bg-center bg-no-repeat bg-cover border border-gray-200 shadow-sm flex-shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCRH2DFNkpUiBX198iz1URgxJjwoNNy3vmppbmW84ca7CsLActnFIXeQrVmF2YLrQG4f-GYYrurmgk67GSKQMqLCJnxm_wEYBuqumkgMvGthY6aBLa9x0U1vtxols04R3EmrDfEdsKCNsPTtguYFFiuynYvtDkYCUbhN15Qj757j8vgtg6GFKOw3pf6kXMFsAv2J-BMyQyhLtCjYtYPWeuFKNecyGUCAWs3COUlKqLR1SC3QH99SVXXF68uj23dXzrXfgrHVj1bakFp");'></div>
<div class="flex-grow">
<p class="text-xs font-medium text-[#1993e5] mb-1">New Patient</p>
<h3 class="text-lg font-semibold text-slate-800 mb-1">Isabella Rossi</h3>
<p class="text-xs text-slate-500">ID: 1234567890</p>
<p class="text-xs text-slate-500">Registered at 09:00 AM</p>
</div>
</div>
</div>
<div class="rounded-lg border border-gray-200 bg-white shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
<div class="flex items-start gap-4">
<div class="size-16 rounded-full bg-center bg-no-repeat bg-cover border border-gray-200 shadow-sm flex-shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuByYQB2OzSsDdih6-COK66F5PBRcYjmLVN_kMNOl4qnH8sqLtHRrRsGJVQ2FboG9IrAgZfpoTnBcTsDob-qEd8nq0A7UdWnAAwQjaWbAHktk5DEflAcH30TF3bvepljpAagIr-hl_4nLt-pxTr0Y882uZuyZYgqxnDGuOhJ5MFMTpmrLHk5D_oA-DDcYi8zx6VaqIkAEYNVoG_KKP68EgjVAs7oMrTfrocZgqPLDyTXY6xdDNjdo1rTdg1i0ihoaazrvnTrNNyYEZBF");'></div>
<div class="flex-grow">
<p class="text-xs font-medium text-[#1993e5] mb-1">New Patient</p>
<h3 class="text-lg font-semibold text-slate-800 mb-1">Noah Parker</h3>
<p class="text-xs text-slate-500">ID: 9876543210</p>
<p class="text-xs text-slate-500">Registered at 09:15 AM</p>
</div>
</div>
</div>
<div class="rounded-lg border border-gray-200 bg-white shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
<div class="flex items-start gap-4">
<div class="size-16 rounded-full bg-center bg-no-repeat bg-cover border border-gray-200 shadow-sm flex-shrink-0" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPF2_0D9708vSnxbXT1l5gqYVW4k4lTxIJo04zVa5Q0ScACnChHmlWvs7oz6hepRjjNq7YKZv1dLRX1jk4u4hmyZ_l55HCQ4RbqgInH2bjNO33uKogIJEYztsJo685DF_dGbya49pGQncSTtsAl3dbsRTJX2GvoJf9Sw8HF_of9O1XntOciNelNIwUEm14SIhfY7AMYOH0KUW3PSXzV3hpleQ45zh0Rc1dmCcWKcr8SPs_3dOO4mA3ANtAnl9zD1oaOctMYMbbSVDU");'></div>
<div class="flex-grow">
<p class="text-xs font-medium text-[#1993e5] mb-1">New Patient</p>
<h3 class="text-lg font-semibold text-slate-800 mb-1">Chloe Evans</h3>
<p class="text-xs text-slate-500">ID: 4567891230</p>
<p class="text-xs text-slate-500">Registered at 09:30 AM</p>
</div>
</div>
</div>
</div>
</div>
</main>
</div>
</div>

</body></html>

