{{-- Billing: create an invoice. Clinical layout (ADR-005). Posts to InvoiceController@save exactly as before:
     pid, discount (whole %), inputs[n][name|price|qty]. Item names keep their "(Drug)/(Lens)/(Frame)/(Service)"
     suffix because the server uses it to find the stock item to reduce. The summary uses the server's maths:
     total = subtotal - subtotal x discount / 100. --}}
@php
    $lines = array_values(array_filter((array) old('inputs', []), fn ($row) => is_array($row) && filled($row['name'] ?? null)));
@endphp
<x-layouts.clinical title="New invoice">
    <div>
        <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Billing</h1>
        <p class="text-sm text-slate-600">Bill a patient for drugs, lenses, frames and services. Stock is reduced when the invoice is generated.</p>
    </div>

    <x-clinical.tabs label="Billing" :tabs="['New invoice' => 'generate.show', 'Find invoice' => 'invoice.find']" />

    @if ($errors->any())
        <p class="text-sm font-medium text-red-800">The invoice was not saved. Everything you entered is still here.</p>
    @endif

    <form id="invoice-form" method="POST" action="{{ route('invoice.save') }}" class="grid grid-cols-1 gap-4 lg:grid-cols-3">
        @csrf

        <div class="space-y-4 lg:col-span-2">
            <x-clinical.panel title="Patient">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="relative sm:col-span-2">
                        <label for="pid" class="field-label">Patient</label>
                        <input id="pid" name="pid" value="{{ $pid }}" autocomplete="off" placeholder="Search name, patient ID or phone"
                               role="combobox" aria-expanded="false" aria-controls="patient-options" aria-describedby="patient-help"
                               @class(['field-input', 'border-red-400' => $errors->has('pid')])>
                        <ul id="patient-options" role="listbox" class="absolute left-0 right-0 z-30 mt-1 hidden max-h-72 overflow-auto rounded-md border border-slate-200 bg-white py-1 text-sm shadow-lg"></ul>
                        <p id="patient-help" class="pt-1 text-xs text-slate-500">Pick a registered patient so the receipt shows their details. For a walk-in, just type a name.</p>
                        <div id="patient-badge" @class(['mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 rounded-md border border-sky-200 bg-sky-50 px-3 py-2 text-sm', 'hidden' => ! $patient])>
                            <span class="font-semibold text-slate-900" data-badge="name">{{ $patient ? (trim($patient->first_name.' '.$patient->last_name) ?: $patient->fullname) : '' }}</span>
                            <span class="font-mono text-xs text-slate-600" data-badge="id">{{ $patient?->patient_id }}</span>
                            <span class="text-xs text-slate-600" data-badge="phone">{{ $patient?->phone }}</span>
                        </div>
                    </div>
                    <div>
                        <span class="field-label">Invoice date</span>
                        <p class="rounded-md border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">{{ now()->format('d M Y') }}</p>
                        <p class="pt-1 text-xs text-slate-500">Set automatically when generated.</p>
                    </div>
                </div>
            </x-clinical.panel>

            <section class="rounded-lg border border-slate-200 bg-white shadow-sm" aria-labelledby="items-heading">
                <header class="border-b border-slate-100 px-4 py-3">
                    <h2 id="items-heading" class="text-sm font-semibold uppercase tracking-wide text-slate-600">Invoice items</h2>
                </header>

                {{-- Item entry bar: pick from stock and services; the price comes from the catalogue. --}}
                <div class="grid grid-cols-12 items-end gap-3 border-b border-slate-100 bg-slate-50 p-4">
                    <div class="col-span-12 sm:col-span-6">
                        <label for="item-pick" class="mb-1 block text-xs font-medium text-slate-600">Drug, lens, frame or service</label>
                        <input id="item-pick" list="item-catalogue" autocomplete="off" placeholder="Start typing an item name…" class="field-input">
                        <datalist id="item-catalogue"></datalist>
                        <p id="item-hint" class="min-h-[1rem] pt-1 text-xs text-slate-500" aria-live="polite"></p>
                    </div>
                    <div class="col-span-5 sm:col-span-2">
                        <label for="item-price" class="mb-1 block text-xs font-medium text-slate-600">Price (₦)</label>
                        <input id="item-price" readonly tabindex="-1" placeholder="0.00" class="field-input bg-slate-100 text-right tabular-nums">
                    </div>
                    <div class="col-span-3 sm:col-span-2">
                        <label for="item-qty" class="mb-1 block text-xs font-medium text-slate-600">Qty</label>
                        <input id="item-qty" type="number" min="1" step="1" value="1" class="field-input text-right">
                    </div>
                    <div class="col-span-4 sm:col-span-2">
                        <button type="button" id="item-add" class="inline-flex w-full items-center justify-center rounded-md bg-slate-800 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-900 disabled:cursor-not-allowed disabled:opacity-50" disabled>+ Add</button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="border-b border-slate-200 text-xs font-semibold uppercase tracking-wide text-slate-600">
                            <tr>
                                <th scope="col" class="px-4 py-2.5">Item</th>
                                <th scope="col" class="px-4 py-2.5 text-right">Unit price</th>
                                <th scope="col" class="w-28 px-4 py-2.5 text-right">Qty</th>
                                <th scope="col" class="px-4 py-2.5 text-right">Total</th>
                                <th scope="col" class="w-20 px-4 py-2.5"><span class="sr-only">Remove</span></th>
                            </tr>
                        </thead>
                        <tbody id="invoice-lines" class="divide-y divide-slate-100">
                            @foreach ($lines as $i => $line)
                                <tr data-line>
                                    <td class="px-4 py-2 font-medium text-slate-900">
                                        {{ $line['name'] }}
                                        <input type="hidden" name="inputs[{{ $i }}][name]" value="{{ $line['name'] }}">
                                        @error('inputs.'.$i.'.name')<p class="text-xs text-red-700">{{ $message }}</p>@enderror
                                    </td>
                                    <td class="px-4 py-2 text-right tabular-nums">
                                        <span data-price-text></span>
                                        <input type="hidden" name="inputs[{{ $i }}][price]" value="{{ $line['price'] ?? '' }}" data-price>
                                        @error('inputs.'.$i.'.price')<p class="text-xs text-red-700">{{ $message }}</p>@enderror
                                    </td>
                                    <td class="px-4 py-2 text-right">
                                        <input type="number" name="inputs[{{ $i }}][qty]" value="{{ $line['qty'] ?? 1 }}" min="1" step="1" aria-label="Quantity of {{ $line['name'] }}" data-qty class="field-input w-20 py-1 text-right">
                                        @error('inputs.'.$i.'.qty')<p class="text-xs text-red-700">{{ $message }}</p>@enderror
                                    </td>
                                    <td class="px-4 py-2 text-right font-medium tabular-nums text-slate-900" data-line-total></td>
                                    <td class="px-4 py-2 text-right"><button type="button" data-remove class="text-xs font-medium text-red-700 hover:underline">Remove</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <p id="invoice-empty" @class(['px-4 py-8 text-center text-sm text-slate-500', 'hidden' => count($lines) > 0])>No items yet. Pick an item above and click <strong>+ Add</strong>.</p>
                </div>
            </section>
        </div>

        <aside class="lg:sticky lg:top-[calc(var(--sb-height,0px)+1rem)] lg:self-start">
            <x-clinical.panel title="Payment summary">
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between text-slate-600">
                        <dt>Subtotal</dt>
                        <dd class="font-medium tabular-nums text-slate-900" id="sum-subtotal">₦0.00</dd>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <dt><label for="discount" class="text-slate-600">Discount (%)</label></dt>
                        <dd>
                            <input id="discount" type="number" name="discount" min="0" max="100" step="1" required value="{{ old('discount', 0) }}"
                                   @class(['field-input w-20 py-1 text-right', 'border-red-400' => $errors->has('discount')])>
                        </dd>
                    </div>
                    @error('discount')<p class="text-xs text-red-700">{{ $message }}</p>@enderror
                    <div class="flex justify-between text-slate-600">
                        <dt>Discount amount</dt>
                        <dd class="tabular-nums" id="sum-discount">-₦0.00</dd>
                    </div>
                    <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold text-slate-900">
                        <dt>Total due</dt>
                        <dd class="tabular-nums text-sky-800" id="sum-total">₦0.00</dd>
                    </div>
                </dl>
                <p class="pt-2 text-xs text-slate-500"><span id="sum-count">0 items</span>. No VAT is applied.</p>
                <button type="submit" id="invoice-submit" class="btn-primary mt-4 w-full py-2.5">Generate invoice</button>
                <p class="pt-2 text-xs text-slate-500">Opens the receipt to print. Stock is reduced for each item.</p>
            </x-clinical.panel>
        </aside>
    </form>

    <x-slot:scripts>
        <script>
            (function () {
                var form = document.getElementById('invoice-form');
                var lines = document.getElementById('invoice-lines');
                var pick = document.getElementById('item-pick');
                var priceBox = document.getElementById('item-price');
                var qtyBox = document.getElementById('item-qty');
                var addButton = document.getElementById('item-add');
                var hint = document.getElementById('item-hint');
                var catalogue = {}; // label => item
                var nextIndex = {{ count($lines) }};
                var naira = new Intl.NumberFormat('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                function money(n) { return '₦' + naira.format(n); }
                function num(v) { var n = parseFloat(String(v).replace(/,/g, '')); return isNaN(n) ? 0 : n; }

                // ---- Totals: same maths as InvoiceController@save ----
                function recalc() {
                    var subtotal = 0, count = 0;
                    lines.querySelectorAll('[data-line]').forEach(function (row) {
                        var price = num(row.querySelector('[data-price]').value);
                        var qty = Math.max(0, parseInt(row.querySelector('[data-qty]').value, 10) || 0);
                        row.querySelector('[data-price-text]').textContent = money(price);
                        row.querySelector('[data-line-total]').textContent = money(price * qty);
                        subtotal += price * qty;
                        count++;
                    });
                    var pct = Math.min(100, Math.max(0, parseInt(document.getElementById('discount').value, 10) || 0));
                    var discount = subtotal * pct / 100;
                    document.getElementById('sum-subtotal').textContent = money(subtotal);
                    document.getElementById('sum-discount').textContent = '-' + money(discount);
                    document.getElementById('sum-total').textContent = money(subtotal - discount);
                    document.getElementById('sum-count').textContent = count + (count === 1 ? ' item' : ' items');
                    document.getElementById('invoice-empty').classList.toggle('hidden', count > 0);
                }

                // ---- Item catalogue (drugs, lenses, frames, services) ----
                fetch(@json(url('/items')), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                    .then(function (r) { if (!r.ok) throw new Error('Item list failed (' + r.status + ')'); return r.json(); })
                    .then(function (items) {
                        var list = document.getElementById('item-catalogue');
                        items.forEach(function (item) {
                            catalogue[item.label] = item;
                            var option = document.createElement('option');
                            option.value = item.label;
                            if (item.type !== 'service' && item.quantity !== null && item.quantity !== undefined) {
                                option.label = 'In stock: ' + item.quantity;
                            }
                            list.appendChild(option);
                        });
                    })
                    .catch(function (err) {
                        if (window.console) console.error(err);
                        hint.textContent = 'The item list could not be loaded. Refresh the page to try again.';
                        hint.className = 'min-h-[1rem] pt-1 text-xs text-red-700';
                    });

                function selected() { return catalogue[pick.value] || null; }
                function onPick() {
                    var item = selected();
                    priceBox.value = item ? item.price : '';
                    addButton.disabled = !item;
                    hint.className = 'min-h-[1rem] pt-1 text-xs text-slate-500';
                    if (!item) {
                        hint.textContent = pick.value ? 'Choose an item from the list so its price fills in.' : '';
                    } else if (item.type === 'service') {
                        hint.textContent = 'Service';
                    } else {
                        var stock = parseInt(item.quantity, 10);
                        hint.textContent = isNaN(stock) ? '' : 'In stock: ' + stock + (stock <= 0 ? ' (out of stock; the sale is still recorded)' : '');
                        if (!isNaN(stock) && stock <= 0) hint.className = 'min-h-[1rem] pt-1 text-xs text-amber-700';
                    }
                }
                pick.addEventListener('input', onPick);
                pick.addEventListener('change', onPick);

                function addLine() {
                    var item = selected();
                    if (!item) { onPick(); pick.focus(); return; }
                    var qty = Math.max(1, parseInt(qtyBox.value, 10) || 1);
                    // The same item twice becomes one line with a higher quantity.
                    var existing = Array.prototype.find.call(lines.querySelectorAll('[data-line]'), function (row) {
                        return row.querySelector('input[name$="[name]"]').value === item.label;
                    });
                    if (existing) {
                        var q = existing.querySelector('[data-qty]');
                        q.value = (parseInt(q.value, 10) || 0) + qty;
                    } else {
                        var i = nextIndex++;
                        var row = document.createElement('tr');
                        row.setAttribute('data-line', '');
                        row.innerHTML =
                            '<td class="px-4 py-2 font-medium text-slate-900"><span data-name-text></span><input type="hidden" name="inputs[' + i + '][name]"></td>' +
                            '<td class="px-4 py-2 text-right tabular-nums"><span data-price-text></span><input type="hidden" name="inputs[' + i + '][price]" data-price></td>' +
                            '<td class="px-4 py-2 text-right"><input type="number" name="inputs[' + i + '][qty]" min="1" step="1" data-qty class="field-input w-20 py-1 text-right"></td>' +
                            '<td class="px-4 py-2 text-right font-medium tabular-nums text-slate-900" data-line-total></td>' +
                            '<td class="px-4 py-2 text-right"><button type="button" data-remove class="text-xs font-medium text-red-700 hover:underline">Remove</button></td>';
                        row.querySelector('[data-name-text]').textContent = item.label;
                        row.querySelector('input[name$="[name]"]').value = item.label;
                        row.querySelector('[data-price]').value = item.price;
                        row.querySelector('[data-qty]').value = qty;
                        row.querySelector('[data-qty]').setAttribute('aria-label', 'Quantity of ' + item.label);
                        lines.appendChild(row);
                    }
                    pick.value = ''; priceBox.value = ''; qtyBox.value = 1; addButton.disabled = true; hint.textContent = '';
                    recalc();
                    pick.focus();
                }
                addButton.addEventListener('click', addLine);
                [pick, qtyBox].forEach(function (box) {
                    box.addEventListener('keydown', function (e) { if (e.key === 'Enter') { e.preventDefault(); addLine(); } });
                });

                lines.addEventListener('click', function (e) {
                    if (e.target.closest('[data-remove]')) { e.target.closest('[data-line]').remove(); recalc(); }
                });
                form.addEventListener('input', function (e) { if (e.target.matches('[data-qty], #discount')) recalc(); });

                form.addEventListener('submit', function (e) {
                    if (!lines.querySelector('[data-line]')) {
                        e.preventDefault();
                        hint.textContent = 'Add at least one item to the invoice.';
                        hint.className = 'min-h-[1rem] pt-1 text-xs text-red-700';
                        pick.focus();
                        return;
                    }
                    var b = document.getElementById('invoice-submit'); b.disabled = true; b.textContent = 'Generating…';
                });

                // ---- Patient picker: the universal search, filling pid with the Patient ID ----
                var pid = document.getElementById('pid');
                var options = document.getElementById('patient-options');
                var badge = document.getElementById('patient-badge');
                var searchUrl = @json(route('search.global'));
                var timer = null, seq = 0, results = [], active = -1;
                function closeOptions() { options.classList.add('hidden'); pid.setAttribute('aria-expanded', 'false'); active = -1; }
                function choose(p) {
                    pid.value = p.patient_id;
                    badge.querySelector('[data-badge="name"]').textContent = p.name;
                    badge.querySelector('[data-badge="id"]').textContent = p.patient_id;
                    badge.querySelector('[data-badge="phone"]').textContent = p.phone || '';
                    badge.classList.remove('hidden');
                    closeOptions();
                    pick.focus();
                }
                function highlight(i) {
                    active = i;
                    Array.prototype.forEach.call(options.children, function (li, n) { li.classList.toggle('bg-sky-50', n === i); li.setAttribute('aria-selected', n === i ? 'true' : 'false'); });
                }
                pid.addEventListener('input', function () {
                    badge.classList.add('hidden');
                    clearTimeout(timer);
                    var q = pid.value.trim();
                    if (q.length < 2) { closeOptions(); return; }
                    timer = setTimeout(function () {
                        var mine = ++seq;
                        fetch(searchUrl + '?q=' + encodeURIComponent(q), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                            .then(function (r) { if (!r.ok) throw new Error('Patient search failed (' + r.status + ')'); return r.json(); })
                            .then(function (data) {
                                if (mine !== seq) return;
                                results = data.patients || [];
                                options.innerHTML = '';
                                if (!results.length) { closeOptions(); return; }
                                results.forEach(function (p, n) {
                                    var li = document.createElement('li');
                                    li.setAttribute('role', 'option');
                                    li.className = 'cursor-pointer px-3 py-2 hover:bg-sky-50';
                                    var name = document.createElement('span'); name.className = 'block font-medium text-slate-900'; name.textContent = p.name;
                                    var meta = document.createElement('span'); meta.className = 'block text-xs text-slate-500'; meta.textContent = p.patient_id + (p.phone ? ' · ' + p.phone : '');
                                    li.appendChild(name); li.appendChild(meta);
                                    li.addEventListener('mousedown', function (e) { e.preventDefault(); choose(p); });
                                    options.appendChild(li);
                                });
                                options.classList.remove('hidden');
                                pid.setAttribute('aria-expanded', 'true');
                                highlight(-1);
                            })
                            .catch(function (err) { if (window.console) console.error(err); closeOptions(); });
                    }, 200);
                });
                pid.addEventListener('keydown', function (e) {
                    var open = !options.classList.contains('hidden');
                    if (e.key === 'ArrowDown' && open) { e.preventDefault(); highlight(Math.min(active + 1, results.length - 1)); }
                    else if (e.key === 'ArrowUp' && open) { e.preventDefault(); highlight(Math.max(active - 1, 0)); }
                    else if (e.key === 'Enter') { e.preventDefault(); if (open && results[active]) choose(results[active]); else closeOptions(); }
                    else if (e.key === 'Escape') { closeOptions(); }
                });
                pid.addEventListener('blur', function () { setTimeout(closeOptions, 150); });

                recalc();
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
