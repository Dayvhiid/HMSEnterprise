{{-- Stock: add lenses, several at once. Clinical layout (ADR-005). Posts inputs[n][field] to LensController@store. --}}
<x-layouts.clinical title="Add lenses">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Lenses</h1>
        <p class="text-sm text-slate-600">Add lenses to stock. Add a row per lens, then save them together.</p>
    </div>

    <x-clinical.tabs label="Lenses" :tabs="['Add lenses' => 'admin2.lens', 'Lens list' => 'lens.list']" />

    <form id="lens-entry" method="POST" action="{{ route('lens.store') }}">
        @csrf
        <x-clinical.panel title="Lens details">
            <x-clinical.row-entry name="inputs" add-label="Add another lens" :rows="old('inputs', [])" :columns="[
                'sn' => ['label' => 'SN', 'auto' => 'row', 'class' => 'w-16'],
                'name' => ['label' => 'Lens name', 'class' => 'min-w-[14rem]'],
                'price' => ['label' => 'Price', 'type' => 'number', 'step' => 'any', 'class' => 'w-32'],
                'special_code' => ['label' => 'Code', 'class' => 'min-w-[8rem] font-mono'],
                'quantity' => ['label' => 'Quantity', 'type' => 'number', 'class' => 'w-24'],
            ]" />
            <p class="mt-3 text-xs text-slate-500">Lens name and price are required on every row. Remove empty rows before saving.</p>
        </x-clinical.panel>
    </form>

    <x-slot:actions>
        <a href="{{ route('lens.list') }}" class="btn-secondary">View lens list</a>
        <button type="submit" form="lens-entry" class="btn-primary" data-lock-on-submit>Save lenses</button>
    </x-slot:actions>

    <x-slot:scripts>
        <script>
            document.getElementById('lens-entry').addEventListener('submit', function () {
                var b = document.querySelector('[data-lock-on-submit]'); b.disabled = true; b.textContent = 'Saving…';
            });
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
