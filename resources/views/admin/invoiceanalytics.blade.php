<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900"
    />

    <title>Invoice Analytics Over 6 Months Period</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
@include('partials.session-bar')
    <div class="relative flex size-full min-h-screen flex-col bg-slate-50 group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#e7edf3] px-10 py-3">
          <div class="flex items-center gap-4 text-[#0e141b]">
            <div class="size-4">
              <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M4 42.4379C4 42.4379 14.0962 36.0744 24 41.1692C35.0664 46.8624 44 42.2078 44 42.2078L44 7.01134C44 7.01134 35.068 11.6577 24.0031 5.96913C14.0971 0.876274 4 7.27094 4 7.27094L4 42.4379Z"
                  fill="currentColor"
                ></path>
              </svg>
            </div>
            <h2 class="text-[#0e141b] text-lg font-bold leading-tight tracking-[-0.015em]">Invoice.</h2>
          </div>
          <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
              <a class="text-[#0e141b] text-sm font-medium leading-normal" href="/admin/dashboard">Dashboard</a>
              <a class="text-[#0e141b] text-sm font-medium leading-normal" href="/inventory/analytics">Inventory Analytics</a>
              <a class="text-[#0e141b] text-sm font-medium leading-normal" href="/admin/demographics">Patient Demographics</a>
              <a class="text-[#0e141b] text-sm font-medium leading-normal" href="/admin/staff">Staff Management</a>
            </div>
            <div class="flex gap-2">
              {{-- <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 bg-[#1980e6] text-slate-50 text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">New Invoice</span>
              </button> --}}
              <button
                class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 bg-[#e7edf3] text-[#0e141b] gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-2.5"
              >
                <div class="text-[#0e141b]" data-icon="Bell" data-size="20px" data-weight="regular">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                    <path
                      d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"
                    ></path>
                  </svg>
                </div>
              </button>
            </div>
          </div>
        </header>
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-3">
                <p class="text-[#0e141b] text-4xl font-black leading-tight tracking-[-0.033em]">Invoicing</p>
                <p class="text-[#4e7397] text-base font-normal leading-normal">Get insights on your sales and customers.</p>
              </div>
            </div>
            <h2 class="text-[#0e141b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Overview</h2>
            <div class="flex flex-wrap gap-4 p-4">
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#d0dbe7]">
                <p class="text-[#0e141b] text-base font-medium leading-normal"  >Net revenue (after discounts)</p>
                <p class="text-[#0e141b] tracking-light text-2xl font-bold leading-tight" > ₦{{ number_format($totalRevenue) }} </p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#d0dbe7]">
                <p class="text-[#0e141b] text-base font-medium leading-normal">Average invoice value</p>
                <p class="text-[#0e141b] tracking-light text-2xl font-bold leading-tight"> ₦{{ number_format($averageInvoiceValue) }} </p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#d0dbe7]">
                <p class="text-[#0e141b] text-base font-medium leading-normal">Total invoices</p>
                <p class="text-[#0e141b] tracking-light text-2xl font-bold leading-tight"> {{ number_format($totalInvoices) }}</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#d0dbe7]">
                <p class="text-[#0e141b] text-base font-medium leading-normal">Total products sold</p>
                <p class="text-[#0e141b] tracking-light text-2xl font-bold leading-tight">  {{ number_format($totalProductsSold) }}</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#d0dbe7]">
                <p class="text-[#0e141b] text-base font-medium leading-normal">Discounts given</p>
                <p class="text-[#0e141b] tracking-light text-2xl font-bold leading-tight"> ₦{{ number_format($discountImpact) }} <span class="text-sm font-normal text-[#4e7397]">of ₦{{ number_format($grossSales) }} gross sales</span></p>
              </div>
            </div>
            <h2 class="text-[#0e141b] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Product Insights</h2>
            <div class="flex flex-wrap gap-4 px-4 py-6">
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#d0dbe7] p-6">
               
                    <p class="text-[#0e141b] text-base font-medium leading-normal">Top 5 selling products by quantity</p>
                    <div class="grid min-h-[180px] gap-x-4 gap-y-6 grid-cols-[auto_1fr] items-center py-3">
                        @foreach($topProductsByQuantity as $product)
                            <p class="text-[#4e7397] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                {{ $product['product_name'] }}
                            </p>
                            <div class="h-full flex-1">
                                <div class="border-[#4e7397] bg-[#e7edf3] border-r-2 h-full"
                                    style="width: {{ $product['percentage'] }}%;">
                                </div>
                            </div>
                        @endforeach
              {{-- </div> --}}
</div>

              </div>
              <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#d0dbe7] p-6">
                    <p class="text-[#0e141b] text-base font-medium leading-normal">Top 5 selling products by revenue</p>
                    <div class="grid min-h-[180px] gap-x-4 gap-y-6 grid-cols-[auto_1fr] items-center py-3">
                        @foreach($topProductsByRevenue as $product)
                            <p class="text-[#4e7397] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                {{ $product['product_name'] }}
                            </p>
                            <div class="h-full flex-1">
                                <div class="border-[#4e7397] bg-[#e7edf3] border-r-2 h-full"
                                    style="width: {{ $product['percentage'] }}%;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
                <!-- Quantity Chart -->
    {{-- <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#d0dbe7] p-6">
        <p class="text-[#0e141b] text-base font-medium leading-normal">Quantity sold over time</p>
        <div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
            <div class="relative h-[148px] w-full"> <!-- Added wrapper div -->
                <canvas id="quantityChart"></canvas>
            </div>
            <div class="flex justify-around">
                @foreach(array_slice($dates, -7) as $date) <!-- Show last 7 months -->
                    <p class="text-[#4e7397] text-[13px] font-bold leading-normal tracking-[0.015em]">
                        {{ \Carbon\Carbon::parse($date)->format('M') }}
                    </p>
                @endforeach
            </div>
        </div>
    </div> --}}

    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#d0dbe7] p-6">
    <p class="text-[#0e141b] text-base font-medium leading-normal">Quantity sold over time</p>
    <div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
        
         <!-- Added wrapper div -->
            <canvas id="quantityChart"></canvas>
        
        <div class="flex justify-around">
            @foreach(array_slice($dates, -7) as $date) <!-- Show last 7 months -->
                <p class="text-[#4e7397] text-[13px] font-bold leading-normal tracking-[0.015em]">
                    {{ \Carbon\Carbon::parse($date)->format('M') }}
                </p>
            @endforeach
        </div>
    </div>
</div>
<!-- Revenue over time -->
    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#d0dbe7] p-6">
        <p class="text-[#0e141b] text-base font-medium leading-normal">Revenue over time</p>
        <div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
            <canvas id="revenueChart" height="148"></canvas>
            <div class="flex justify-around">
                @foreach($dates as $date)
                    <p class="text-[#4e7397] text-[13px] font-bold leading-normal tracking-[0.015em]">
                        {{ \Carbon\Carbon::parse($date)->format('M') }}
                    </p>
                @endforeach
            </div>
        </div>
    </div> 
</div>

              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    
  </body>
</html>


{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    function createGradient(ctx, chartArea) {
        if (!chartArea) return '#e7edf3';
        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
        gradient.addColorStop(0, '#e7edf3');
        gradient.addColorStop(1, '#e7edf300');
        return gradient;
    }

    // Quantity Chart
    const quantityCtx = document.getElementById('quantityChart')?.getContext('2d');
    if (quantityCtx) {
        new Chart(quantityCtx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    data: @json($dailyQuantities),
                    borderColor: '#000000',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        return createGradient(ctx, chartArea);
                    },
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { display: false }, x: { display: false } }
            }
        });
    }

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart')?.getContext('2d');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    data: @json($dailyRevenues),
                    borderColor: '#4e7397',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        return createGradient(ctx, chartArea);
                    },
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { display: false } },
                scales: { y: { display: false }, x: { display: false } }
            }
        });
    }
});
</script> --}}

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dates = {!! json_encode($dates) !!};
        const dailyQuantities = {!! json_encode($dailyQuantities) !!};

        const ctx = document.getElementById('quantityChart').getContext('2d');

        const quantityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Quantity Sold',
                    data: dailyQuantities,
                    fill: true,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.3,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    x: {
                        display: true // Hide full X axis labels as you show only last 7 months below
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                interaction: {
                    mode: 'nearest',
                    intersect: false,
                }
            }
        });
    });
</script> 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dates = {!! json_encode($dates) !!};
        const dailyRevenues = {!! json_encode($dailyRevenues) !!};

        const ctx = document.getElementById('revenueChart').getContext('2d');

        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Revenue',
                    data: dailyRevenues,
                    fill: true,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true, // important for height control
                scales: {
                    x: {
                        display: false // hide x-axis labels as you display months below
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue ($)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                return `$${context.formattedValue}`;
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'nearest',
                    intersect: false,
                }
            }
        });
    });
</script>