<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Patient Form</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900&amp;family=Public+Sans%3Awght%40400%3B500%3B700%3B900" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>

<body class="bg-white" style='font-family: "Public Sans", "Noto Sans", sans-serif;'>
@include('partials.session-bar')
    <div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">

            <!-- Navbar -->
            <header
                class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f1f3f4] px-10 py-3">
                <div class="flex items-center gap-4 text-[#121516]">
                    <div class="size-20 flex items-center justify-center rounded-full">
                        <img class="logo" src="/icons/logo.png" alt="logo">
                    </div>
                    <h2 class="text-[#121516] text-lg font-bold">Register Patients</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        <a class="text-sm font-medium text-[#121516]" href="{{ route('generate.show') }}">Invoice</a>
                        <a class="text-sm font-medium text-[#121516]" href="{{ route('public.records') }}">Records</a>
                        <a class="text-sm font-medium text-[#121516]" href="/doctors/index">Doctors Portal</a>
                        <a class="text-sm font-medium text-[#121516]" href="{{ route('optician.index') }}">Opticianry</a>
                        <a class="text-sm font-medium text-[#121516]" href="{{ route('admin.admin2') }}">Admin 2</a>
                        <a class="text-sm font-medium text-[#121516]" href="{{ route('image.upload') }}">Case File Upload</a>
                                                <a class="text-sm font-medium text-[#121516]" href="/images/search">View Case File</a>
                    </div>
                </div>
            </header>

            <!-- Form Section -->
            <div class="px-10 flex flex-1 justify-center py-5">
                <div class="w-full max-w-2xl bg-white shadow-md rounded-xl p-8">

                    @if(session()->has('success'))
                        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    @php
                        $random_number = rand(1, 1000);
                        $currentDate = date('m/Y');
                        $patientID = $random_number."/".$currentDate;
                    @endphp

                    <h1 class="text-2xl font-bold text-[#121516] mb-6">New Patient</h1>

                    <form method="POST" action="{{ route('pages.store') }}">
                        @csrf
                        @method('POST')

                        <!-- First + Last Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">First Name</label>
                                <input type="text" name="firstname" placeholder="Enter First Name" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Last Name</label>
                                <input type="text" name="lastname" placeholder="Enter Last Name" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                        </div>

                        <!-- DOB + Gender -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Date of Birth</label>
                                <input type="date" name="dob" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Gender</label>
                                <select name="radio" required
                                    class="form-select w-full rounded-xl border border-gray-300 h-12 px-3">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>

                        <!-- Phone + Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Phone</label>
                                <input type="tel" name="phone" placeholder="Enter Phone Number" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email</label>
                                <input type="email" name="email" placeholder="Enter Email" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Street</label>
                            <input type="text" name="street" placeholder="Enter your street address" required
                                class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">City</label>
                                <input type="text" name="city" placeholder="Enter Your City" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">State</label>
                                <input type="text" name="state" placeholder="Enter Your State" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                        </div>

                        <!-- Occupation -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Occupation</label>
                            <input type="text" name="occupation" placeholder="Enter your occupation" required
                                class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                        </div>

                        <!-- Emergency Contact -->
                        <h2 class="text-lg font-bold mt-6 mb-4">Emergency Contact</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Full Name</label>
                                <input type="text" name="efn" placeholder="Enter Full Name" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Relationship</label>
                                <input type="text" name="erel" placeholder="Enter Relationship" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Phone</label>
                                <input type="tel" name="epn" placeholder="Enter Phone Number" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email</label>
                                <input type="email" name="ee" placeholder="Enter Email" required
                                    class="form-input w-full rounded-xl border border-gray-300 h-12 px-3" />
                            </div>
                        </div>

                        <!-- Patient ID -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2">Patient ID</label>
                            <input type="text" name="pid" value="{{ $patientID }}" 
                                class="form-input w-full rounded-xl border border-gray-300 h-12 px-3 bg-gray-100 cursor-not-allowed" />
                        </div>

                        <!-- Submit -->
                        <div class="flex justify-center">
                            <button type="submit"
                                class="px-6 py-3 rounded-xl bg-blue-500 text-white font-bold hover:bg-blue-600">
                                Register Patient
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
