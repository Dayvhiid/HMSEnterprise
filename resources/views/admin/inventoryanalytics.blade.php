<!DOCTYPE html>
<html>
  <head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link
      rel="stylesheet"
      as="style"
      onload="this.rel='stylesheet'"
      href="https://fonts.googleapis.com/css2?display=swap&amp;family=Noto+Sans:wght@400;500;700;900&amp;family=Work+Sans:wght@400;500;700;900"
    />

    <title>Inventory Analytics</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
@include('partials.session-bar')
    <div class="relative flex size-full min-h-screen flex-col bg-white overflow-x-hidden" style='font-family: "Work Sans", "Noto Sans", sans-serif;'>
      <div class="layout-container flex h-full grow flex-col">
        <div class="gap-1 px-6 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col w-80">
            <div class="flex h-full min-h-[700px] flex-col justify-between bg-white p-4">
              <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                  <a class="flex items-center gap-3 px-3 py-2 text-[#111418] text-sm font-medium" href="/admin/dashboard">Dashboard</a>
                  <a class="flex items-center gap-3 px-3 py-2 text-[#111418] text-sm font-medium" href="/invoice/analytics">Invoice Analytics</a>
                  <a class="flex items-center gap-3 px-3 py-2 text-[#111418] text-sm font-medium" href="/admin/demographics">Patient Demographics</a>
                  <a class="flex items-center gap-3 px-3 py-2 text-[#111418] text-sm font-medium" href="/admin/staff">Staff Management</a>
                  <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-[#f0f2f4] text-[#111418] text-sm font-medium">Inventory Analytics</div>
                </div>
              </div>
            </div>
          </div>

          <div class="layout-content-container flex flex-col max-w-[1080px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-2">
                <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight">Inventory Analytics</p>
                <p class="text-[#637588] text-sm font-normal leading-normal">Operational stock visibility with movement and consumption signals.</p>
              </div>
            </div>

            <div class="flex flex-wrap gap-4 p-4">
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#dce0e5]">
                <p class="text-[#111418] text-base font-medium">Total SKUs</p>
                <p class="text-[#111418] text-2xl font-bold">{{ number_format($summary['totals']['total']) }}</p>
                <p class="text-[#637588] text-xs">Drugs {{ $summary['totals']['drugs'] }}, Frames {{ $summary['totals']['frames'] }}, Lenses {{ $summary['totals']['lenses'] }}</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#dce0e5]">
                <p class="text-[#111418] text-base font-medium">Current Inventory Value</p>
                <p class="text-[#111418] text-2xl font-bold">N{{ number_format($summary['values']['total']) }}</p>
                <p class="text-[#637588] text-xs">Drugs N{{ number_format($summary['values']['drugs']) }}, Frames N{{ number_format($summary['values']['frames']) }}, Lenses N{{ number_format($summary['values']['lenses']) }}</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#dce0e5]">
                <p class="text-[#111418] text-base font-medium">Low Stock</p>
                <p class="text-[#111418] text-2xl font-bold">{{ $summary['lowStock']['total'] }}</p>
                <p class="text-[#637588] text-xs">Critical: {{ $kpis['critical_low_stock'] }} (threshold {{ $threshold }})</p>
              </div>
            </div>

            <div class="flex flex-wrap gap-4 p-4">
              <div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-5 border border-[#dce0e5] bg-[#f8fbff]">
                <p class="text-[#111418] text-sm font-medium">Inbound Units (30d)</p>
                <p class="text-[#111418] text-2xl font-bold">{{ number_format($kpis['inbound_units']) }}</p>
              </div>
              <div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-5 border border-[#dce0e5] bg-[#fff9f6]">
                <p class="text-[#111418] text-sm font-medium">Outbound Units (30d)</p>
                <p class="text-[#111418] text-2xl font-bold">{{ number_format($kpis['outbound_units']) }}</p>
              </div>
              <div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-5 border border-[#dce0e5] bg-[#f8fff8]">
                <p class="text-[#111418] text-sm font-medium">Net Units (30d)</p>
                <p class="text-[#111418] text-2xl font-bold">{{ number_format($kpis['net_units']) }}</p>
              </div>
              <div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-5 border border-[#dce0e5] bg-[#f7f7ff]">
                <p class="text-[#111418] text-sm font-medium">Restock Entries (30d)</p>
                <p class="text-[#111418] text-2xl font-bold">{{ number_format($kpis['restock_entries']) }}</p>
              </div>
            </div>

            <h2 class="text-[#111418] text-[22px] font-bold px-4 pb-2 pt-4">Net Stock Movement (Last 30 Days)</h2>
            <div class="px-4 py-3">
              <div class="rounded-xl border border-[#dce0e5] bg-white p-6">
                <canvas id="movementChart" height="120"></canvas>
              </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
              <div class="rounded-xl border border-[#dce0e5] bg-white p-4">
                <h3 class="text-[#111418] text-lg font-bold pb-3">Top Consumed Items (from invoices, 30d)</h3>
                <table class="w-full">
                  <thead>
                    <tr class="border-b border-[#e7edf3]">
                      <th class="text-left py-2 text-sm text-[#637588]">Item</th>
                      <th class="text-right py-2 text-sm text-[#637588]">Units Sold</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($topConsumedRows as $row)
                      <tr class="border-b border-[#f2f4f7]">
                        <td class="py-2 text-sm text-[#111418]">{{ $row['name'] }}</td>
                        <td class="py-2 text-sm text-right text-[#111418]">{{ number_format($row['qty']) }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="2" class="py-8 text-center text-sm text-[#637588]">No consumption data in the selected period.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <div class="rounded-xl border border-[#dce0e5] bg-white p-4">
                <h3 class="text-[#111418] text-lg font-bold pb-3">Recent Inventory Movements</h3>
                <table class="w-full">
                  <thead>
                    <tr class="border-b border-[#e7edf3]">
                      <th class="text-left py-2 text-sm text-[#637588]">Date</th>
                      <th class="text-left py-2 text-sm text-[#637588]">Item</th>
                      <th class="text-right py-2 text-sm text-[#637588]">In</th>
                      <th class="text-right py-2 text-sm text-[#637588]">Out</th>
                      <th class="text-right py-2 text-sm text-[#637588]">Balance</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($recentMovements as $row)
                      <tr class="border-b border-[#f2f4f7]">
                        <td class="py-2 text-sm text-[#111418]">{{ $row['date'] }}</td>
                        <td class="py-2 text-sm text-[#111418]">{{ $row['name'] }}</td>
                        <td class="py-2 text-sm text-right text-emerald-700">{{ number_format($row['qty_in']) }}</td>
                        <td class="py-2 text-sm text-right text-rose-700">{{ number_format($row['qty_out']) }}</td>
                        <td class="py-2 text-sm text-right text-[#111418]">{{ number_format($row['balance']) }}</td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="py-8 text-center text-sm text-[#637588]">No movement rows found.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>

            <h2 class="text-[#111418] text-[22px] font-bold px-4 pb-2 pt-4">Low Stock Items</h2>
            <div class="px-4 py-3">
              <div class="rounded-xl border border-[#dce0e5] bg-white overflow-x-auto">
                <table class="w-full min-w-[900px]">
                  <thead>
                    <tr class="border-b border-[#e7edf3]">
                      <th class="text-left px-4 py-3 text-sm text-[#637588]">Type</th>
                      <th class="text-left px-4 py-3 text-sm text-[#637588]">SKU</th>
                      <th class="text-left px-4 py-3 text-sm text-[#637588]">Item</th>
                      <th class="text-left px-4 py-3 text-sm text-[#637588]">Code</th>
                      <th class="text-right px-4 py-3 text-sm text-[#637588]">Qty</th>
                      <th class="text-right px-4 py-3 text-sm text-[#637588]">Reorder Qty</th>
                      <th class="text-right px-4 py-3 text-sm text-[#637588]">Unit Price</th>
                      <th class="text-right px-4 py-3 text-sm text-[#637588]">Stock Value</th>
                      <th class="text-left px-4 py-3 text-sm text-[#637588]">Severity</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($lowStockItems as $item)
                      <tr class="border-b border-[#f2f4f7]">
                        <td class="px-4 py-2 text-sm text-[#111418]">{{ $item['type'] }}</td>
                        <td class="px-4 py-2 text-sm text-[#111418]">{{ $item['sn'] ?: '-' }}</td>
                        <td class="px-4 py-2 text-sm text-[#111418]">{{ $item['name'] }}</td>
                        <td class="px-4 py-2 text-sm text-[#637588]">{{ $item['special_code'] ?: '-' }}</td>
                        <td class="px-4 py-2 text-sm text-right text-[#111418]">{{ number_format($item['quantity']) }}</td>
                        <td class="px-4 py-2 text-sm text-right text-[#111418]">{{ number_format($item['reorder_qty']) }}</td>
                        <td class="px-4 py-2 text-sm text-right text-[#111418]">N{{ number_format($item['price'], 2) }}</td>
                        <td class="px-4 py-2 text-sm text-right text-[#111418]">N{{ number_format($item['value'], 2) }}</td>
                        <td class="px-4 py-2 text-sm">
                          @if($item['severity'] === 'critical')
                            <span class="inline-block rounded-full px-2 py-1 text-xs font-semibold bg-rose-100 text-rose-700">Critical</span>
                          @else
                            <span class="inline-block rounded-full px-2 py-1 text-xs font-semibold bg-amber-100 text-amber-700">Warning</span>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="9" class="px-4 py-10 text-center text-sm text-[#637588]">No low stock items for the current threshold.</td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      const movementCtx = document.getElementById('movementChart').getContext('2d');
      new Chart(movementCtx, {
        type: 'line',
        data: {
          labels: {!! json_encode($chart['labels']) !!},
          datasets: [
            {
              label: 'Net Movement',
              data: {!! json_encode($chart['net']) !!},
              borderColor: '#2563eb',
              backgroundColor: 'rgba(37, 99, 235, 0.12)',
              fill: true,
              tension: 0.3,
              pointRadius: 2
            },
            {
              label: 'Inbound',
              data: {!! json_encode($chart['inbound']) !!},
              borderColor: '#059669',
              backgroundColor: 'transparent',
              fill: false,
              tension: 0.25,
              pointRadius: 1
            },
            {
              label: 'Outbound',
              data: {!! json_encode($chart['outbound']) !!},
              borderColor: '#dc2626',
              backgroundColor: 'transparent',
              fill: false,
              tension: 0.25,
              pointRadius: 1
            }
          ]
        },
        options: {
          responsive: true,
          maintainAspectRatio: true,
          scales: {
            y: {
              beginAtZero: true,
              title: {
                display: true,
                text: 'Units'
              }
            }
          }
        }
      });
    </script>
  </body>
</html>
