<html>

<head>
    <meta charset="utf-8" />
    <link crossorigin="" href="https://fonts.gstatic.com/" rel="preconnect" />
    <link as="style"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Lexend%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
        onload="this.rel='stylesheet'" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <title>Optician Index Page</title>
    <link href="data:image/x-icon;base64," rel="icon" type="image/x-icon" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
</head>

<body class="bg-white" style='font-family: Lexend, "Noto Sans", sans-serif;'>
    <div class="relative flex size-full min-h-screen flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <header
                class="flex items-center justify-between whitespace-nowrap border-b border-solid border-gray-200 px-10 py-4 shadow-sm">
                <div class="flex items-center gap-3 text-slate-800">
                    <svg class="size-7 text-[#1993e5]" fill="none" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2"></path>
                        <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></path>
                        <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2"></path>
                    </svg>
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-slate-900">Optician Index Page</h1>
                </div>
                       <nav class="flex items-center gap-8">
                                <a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200"
                        href=" {{ route('optician.records') }}">Optician Record</a>
                    <a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200"
                        href=" {{ route('optician.list') }} ">Optician Record List</a>
                    <a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200"
                        href=" {{ route('optician.find') }}">Optician Record Search</a>
                    <a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200"
                        href=" {{ route('search.treatment') }}">Treatment Record</a>
                    <a class="text-sm font-medium text-slate-700 hover:text-[#1993e5] transition-colors duration-200"
                        href="{{ route('admin2.lens') }}">Lens</a>
                </nav>
            </header>
            <main class="flex-1 bg-slate-50 px-10 py-8">
                    <h2 class="text-2xl font-bold text-slate-800 mb-6">Patient Notifications</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                   @foreach ($notifications as $notification)
                        <div class="rounded-lg border border-gray-200 bg-white shadow-md p-6 hover:shadow-lg transition-shadow duration-200">
                            <div class="flex items-start gap-4">
                                <div class="size-16 rounded-full bg-center bg-no-repeat bg-cover border border-gray-200 shadow-sm flex-shrink-0"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCRH2DFNkpUiBX198iz1URgxJjwoNNy3vmppbmW84ca7CsLActnFIXeQrVmF2YLrQG4f-GYYrurmgk67GSKQMqLCJnxm_wEYBuqumkgMvGthY6aBLa9x0U1vtxols04R3EmrDfEdsKCNsPTtguYFFiuynYvtDkYCUbhN15Qj757j8vgtg6GFKOw3pf6kXMFsAv2J-BMyQyhLtCjYtYPWeuFKNecyGUCAWs3COUlKqLR1SC3QH99SVXXF68uj23dXzrXfgrHVj1bakFp");'>
                                </div>
                                <div class="flex-grow">
                                    @if ($notification->message === \App\Models\Notification::RETURNING_PATIENT)
                                    <p class="text-xs font-medium text-[#16a34a] mb-1">Returning Patient</p>
                                    @else
                                    <p class="text-xs font-medium text-[#1993e5] mb-1">New Patient</p>
                                    @endif
                                    <h3 class="text-lg font-semibold text-slate-800 mb-1">{{ $notification->patient_name }}</h3>
                                    <p class="text-xs text-slate-500">{{ $notification->message }}</p>
                                    <p class="text-xs text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                                    <div class="flex items-center gap-1">
                                        <p class="text-xs text-slate-500">{{ $notification->pid }}</p>
                                        <button onclick="copyPid(this, '{{ $notification->pid }}')" 
                                                class="text-gray-400 hover:text-gray-600 focus:outline-none transition-colors duration-200"
                                                title="Copy PID">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach
                    </div>

                <script>
                    function copyPid(buttonElement, pid) {
                        navigator.clipboard.writeText(pid).then(function() {
                            // Visual feedback - change icon color temporarily
                            const icon = buttonElement.querySelector('svg');
                            icon.style.stroke = '#10B981'; // Green color
                            setTimeout(() => {
                                icon.style.stroke = ''; // Reset to default after 1 second
                            }, 1000);
                        }).catch(function(err) {
                            console.error('Could not copy text: ', err);
                        });
                    }
                </script>
            </main>
        </div>
    </div>

</body>

</html>
