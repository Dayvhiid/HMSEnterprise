{{-- Stock: lens list, searchable and paged, with edit and delete. Clinical layout (ADR-005). --}}
<x-layouts.clinical title="Lens list">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Lenses</h1>
            <p class="text-sm text-slate-600">Lenses in stock, A–Z. Search by name or code.</p>
        </div>
        <a href="{{ route('admin2.lens') }}" class="btn-primary">+ Add lenses</a>
    </div>

    <x-clinical.tabs label="Lenses" :tabs="['Add lenses' => 'admin2.lens', 'Lens list' => 'lens.list']" />

    <form method="GET" action="{{ route('lens.list') }}" role="search" class="flex flex-wrap items-center gap-3 rounded-lg border border-slate-200 bg-white p-3 shadow-sm">
        <label for="lens-query" class="sr-only">Search lenses</label>
        <input id="lens-query" name="query" type="search" value="{{ $query }}" autofocus placeholder="Lens name or code" class="field-input max-w-md flex-1">
        <button type="submit" class="btn-secondary">Search</button>
        @if ($query !== '')
            <a href="{{ route('lens.list') }}" class="text-sm font-medium text-sky-700 hover:underline">Clear</a>
        @endif
    </form>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
        @if ($lens->isEmpty())
            <div class="px-6 py-12 text-center">
                <p class="text-sm font-medium text-slate-900">{{ $query !== '' ? 'No lenses match “'.$query.'”.' : 'No lenses in stock yet.' }}</p>
                <p class="mt-1 text-sm text-slate-600"><a href="{{ route('admin2.lens') }}" class="font-medium text-sky-700 hover:underline">Add lenses</a></p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <tr>
                            <th scope="col" class="px-4 py-2.5">Lens name</th>
                            <th scope="col" class="px-4 py-2.5">Code</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Price</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Quantity</th>
                            <th scope="col" class="px-4 py-2.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @foreach ($lens as $len)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-2.5 font-medium text-slate-900">{{ $len->name }}</td>
                                <td class="whitespace-nowrap px-4 py-2.5 font-mono text-xs">{{ filled($len->special_code) ? $len->special_code : '-' }}</td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right tabular-nums">{{ is_numeric($len->price) ? number_format((float) $len->price, 2) : $len->price }}</td>
                                <td class="whitespace-nowrap px-4 py-2.5 text-right tabular-nums">
                                    @if (is_numeric($len->quantity) && (int) $len->quantity <= 0)
                                        <span class="rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-800">Out of stock</span>
                                    @else
                                        {{ filled($len->quantity) ? $len->quantity : '-' }}
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-2.5">
                                    <div class="flex items-center justify-end gap-3">
                                        <a href="{{ route('lens.edit', ['len' => $len]) }}" class="font-medium text-sky-700 hover:underline">Edit</a>
                                        <form method="POST" action="{{ route('lens.delete', ['len' => $len]) }}"
                                              onsubmit="return confirm({{ \Illuminate\Support\Js::from('Delete '.$len->name.' from the lens list? This cannot be undone.') }});">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-medium text-red-700 hover:underline">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <x-clinical.pager :paginator="$lens" noun="lens" />
        @endif
    </div>
</x-layouts.clinical>
