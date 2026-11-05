{{-- Optician: enter dispensing records, several at once. Clinical layout (ADR-005).
     Posts patients[n][field] to OpticianController@store, as before. --}}
<x-layouts.clinical title="New dispensing records">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight text-slate-900">Dispensing</h1>
            <p class="text-sm text-slate-600">Record spectacles dispensed. Add a row per patient, then save them together.</p>
        </div>
    </div>

    <x-clinical.tabs label="Dispensing" :tabs="['New records' => 'optician.records', 'Records list' => 'optician.list']" />

    <form id="optician-records" method="POST" action="{{ route('optician.store') }}">
        @csrf
        <x-clinical.panel title="Patient details">
            <x-clinical.row-entry name="patients" add-label="Add another patient" :rows="old('patients', [])" :columns="[
                'date' => ['label' => 'Date', 'type' => 'date', 'auto' => 'today', 'class' => 'w-40'],
                'patient_id' => ['label' => 'Patient ID', 'class' => 'min-w-[9rem] font-mono'],
                'patient_name' => ['label' => 'Patient name', 'class' => 'min-w-[12rem]'],
                'power' => ['label' => 'Power'],
                'frame_type' => ['label' => 'Frame type'],
                'qty' => ['label' => 'Qty', 'type' => 'number', 'class' => 'w-20'],
            ]" />
            <p class="mt-3 text-xs text-slate-500">Type the Patient ID and the name fills in. Date and patient name are required on every row; remove empty rows before saving.</p>
        </x-clinical.panel>
    </form>

    <x-slot:actions>
        <a href="{{ route('optician.list') }}" class="btn-secondary">View records</a>
        <button type="submit" form="optician-records" class="btn-primary" data-lock-on-submit>Save records</button>
    </x-slot:actions>

    <x-slot:scripts>
        <script>
            (function () {
                var form = document.getElementById('optician-records');
                var lookupUrl = @json(route('search.global'));

                form.addEventListener('submit', function () {
                    var b = document.querySelector('[data-lock-on-submit]'); b.disabled = true; b.textContent = 'Saving…';
                });

                // Patient ID -> name: look the ID up with the universal search and fill the name if it matches exactly.
                form.addEventListener('change', function (event) {
                    var idBox = event.target;
                    if (!/\[patient_id\]$/.test(idBox.name)) return;
                    var id = idBox.value.trim();
                    var nameBox = form.elements[idBox.name.replace(/\[patient_id\]$/, '[patient_name]')];
                    idBox.setCustomValidity('');
                    if (!id || !nameBox) return;
                    fetch(lookupUrl + '?q=' + encodeURIComponent(id), { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
                        .then(function (r) { if (!r.ok) throw new Error('Patient lookup failed (' + r.status + ')'); return r.json(); })
                        .then(function (data) {
                            var match = (data.patients || []).filter(function (p) { return p.patient_id === id; })[0];
                            if (match) {
                                if (!nameBox.value) nameBox.value = match.name;
                            } else {
                                idBox.setCustomValidity('No registered patient has this ID.');
                                idBox.reportValidity();
                            }
                        })
                        .catch(function (err) { if (window.console) console.error(err); });
                });
            })();
        </script>
    </x-slot:scripts>
</x-layouts.clinical>
