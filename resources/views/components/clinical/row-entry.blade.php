{{-- Enter several records at once: one table row per record, with Add row / Remove.
     $name:    the array the form posts, e.g. "patients" => patients[0][date], patients[1][date] ...
     $columns: [field => ['label' => ..., 'type' => 'text'|'date'|'number', 'default' => ..., 'auto' => 'row'|'today', 'class' => ...]]
               auto=row fills the row number; auto=today fills today's date in new rows.
     $rows:    rows to show first (old input after a failed save); one empty row when none. --}}
@props(['name', 'columns', 'rows' => [], 'addLabel' => 'Add row'])
@php
    // Keep the posted keys so validation errors (e.g. patients.3.date) land on the right row.
    $rows = $rows ?: [[]];
    $nextIndex = max(array_map('intval', array_keys($rows))) + 1;
    $default = function (array $column, int $index) {
        return match ($column['auto'] ?? null) {
            'row' => $index + 1,
            'today' => now()->toDateString(),
            default => $column['default'] ?? '',
        };
    };
@endphp
<div data-row-entry="{{ $name }}" data-next-index="{{ $nextIndex }}">
    <div class="overflow-x-auto rounded-md border border-slate-200">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                    @foreach ($columns as $column)
                        <th scope="col" class="px-2 py-2">{{ $column['label'] }}</th>
                    @endforeach
                    <th scope="col" class="w-10 px-2 py-2"><span class="sr-only">Remove</span></th>
                </tr>
            </thead>
            <tbody data-rows class="divide-y divide-slate-100">
                @foreach ($rows as $index => $row)
                    <tr data-row>
                        @foreach ($columns as $field => $column)
                            <td class="px-2 py-1.5">
                                <input type="{{ $column['type'] ?? 'text' }}" name="{{ $name }}[{{ $index }}][{{ $field }}]" value="{{ $row[$field] ?? $default($column, $loop->parent->index) }}" aria-label="{{ $column['label'] }}, row {{ $loop->parent->iteration }}"
                                       @if (($column['type'] ?? '') === 'number') min="0" step="{{ $column['step'] ?? '1' }}" @endif
                                       @class(['field-input py-1.5', $column['class'] ?? 'min-w-[8rem]', 'border-red-400' => $errors->has($name.'.'.$index.'.'.$field)])>
                                @error($name.'.'.$index.'.'.$field)<p class="pt-0.5 text-xs text-red-700">{{ $message }}</p>@enderror
                            </td>
                        @endforeach
                        <td class="px-2 py-1.5 text-right">
                            <button type="button" data-remove-row class="rounded-md px-2 py-1 text-slate-400 hover:bg-red-50 hover:text-red-700" title="Remove this row" aria-label="Remove row {{ $loop->iteration }}">&times;</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <button type="button" data-add-row class="btn-secondary mt-3">+ {{ $addLabel }}</button>

    {{-- Blank row copied by "Add row"; __N__ becomes the row index, __ROW__ the row number. --}}
    <template data-row-template>
        <tr data-row>
            @foreach ($columns as $field => $column)
                <td class="px-2 py-1.5">
                    <input type="{{ $column['type'] ?? 'text' }}" name="{{ $name }}[__N__][{{ $field }}]" value="{{ ($column['auto'] ?? null) === 'row' ? '__ROW__' : (($column['auto'] ?? null) === 'today' ? now()->toDateString() : ($column['default'] ?? '')) }}"
                           aria-label="{{ $column['label'] }}, row __ROW__"
                           @if (($column['type'] ?? '') === 'number') min="0" step="{{ $column['step'] ?? '1' }}" @endif
                           class="field-input py-1.5 {{ $column['class'] ?? 'min-w-[8rem]' }}">
                </td>
            @endforeach
            <td class="px-2 py-1.5 text-right">
                <button type="button" data-remove-row class="rounded-md px-2 py-1 text-slate-400 hover:bg-red-50 hover:text-red-700" title="Remove this row" aria-label="Remove row __ROW__">&times;</button>
            </td>
        </tr>
    </template>
</div>
<script>
    (function () {
        var box = document.currentScript.previousElementSibling;
        var body = box.querySelector('[data-rows]');
        var template = box.querySelector('[data-row-template]').innerHTML;
        // Indexes only need to be unique, so keep counting up even after rows are removed.
        var next = parseInt(box.getAttribute('data-next-index'), 10) || 0;

        box.querySelector('[data-add-row]').addEventListener('click', function () {
            var visible = body.querySelectorAll('[data-row]').length;
            var html = template.replace(/__N__/g, String(next)).replace(/__ROW__/g, String(visible + 1));
            body.insertAdjacentHTML('beforeend', html);
            next++;
            var inputs = body.lastElementChild.querySelectorAll('input');
            if (inputs.length) (inputs[1] || inputs[0]).focus();
        });

        body.addEventListener('click', function (event) {
            var button = event.target.closest('[data-remove-row]');
            if (!button) return;
            if (body.querySelectorAll('[data-row]').length === 1) {
                // Keep one row to type in; just clear it.
                button.closest('[data-row]').querySelectorAll('input').forEach(function (i) { if (!/\[sn\]$/.test(i.name)) i.value = ''; });
                return;
            }
            button.closest('[data-row]').remove();
        });
    })();
</script>
