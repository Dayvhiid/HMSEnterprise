{{-- An editable exam table: one row per eye (or structure), one input per measurement.
     $columns: column headings. $rows: [row label => [input name => current value, ...], ...]
     Inputs render as name="..." value="..." so field names stay identical to the original forms. --}}
@props(['title', 'columns', 'rows'])
<fieldset class="min-w-0">
    <legend class="mb-2 text-sm font-semibold text-slate-800">{{ $title }}</legend>
    <div class="overflow-x-auto rounded-md border border-slate-200">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                <tr>
                    <th scope="col" class="w-28 px-3 py-2 font-semibold"><span class="sr-only">Eye</span></th>
                    @foreach ($columns as $column)
                        <th scope="col" class="px-2 py-2 font-semibold">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($rows as $label => $inputs)
                    <tr>
                        <th scope="row" class="whitespace-nowrap px-3 py-1.5 font-medium text-slate-700">{{ $label }}</th>
                        @foreach ($inputs as $name => $value)
                            <td class="px-2 py-1.5">
                                <input name="{{ $name }}" value="{{ $value }}" aria-label="{{ $label }} {{ $columns[$loop->index] ?? '' }}" class="field-input min-w-[5rem] py-1.5" />
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $slot }}
</fieldset>
