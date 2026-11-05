{{-- Floating jump bar for long forms: stays under the top bar / patient banner while scrolling,
     jumps to a section on click and highlights the section currently in view.
     $sections: [element id => label]. Each id must exist on the page (e.g. <x-clinical.panel id="...">). --}}
@props(['sections'])
<nav aria-label="Jump to section" data-section-bar
     class="no-print sticky top-[calc(var(--sb-height,0px)+var(--banner-height,0px)+0.5rem)] z-20 flex flex-wrap gap-1.5 rounded-lg border border-slate-200 bg-white/95 p-1.5 shadow-sm backdrop-blur">
    @foreach ($sections as $anchor => $label)
        <a href="#{{ $anchor }}" data-section-link="{{ $anchor }}"
           class="rounded-md px-3 py-1 text-sm font-medium text-slate-700 hover:bg-sky-50 hover:text-sky-800 aria-[current=true]:bg-sky-100 aria-[current=true]:text-sky-900">{{ $label }}</a>
    @endforeach
</nav>
<script>
    (function () {
        var bar = document.currentScript.previousElementSibling;
        var links = Array.prototype.slice.call(bar.querySelectorAll('[data-section-link]'));
        var root = document.documentElement;

        // Keep the bar (and section jumps) clear of the sticky patient banner.
        function measure() {
            var banner = document.querySelector('[data-zone="patient-banner"]');
            root.style.setProperty('--banner-height', banner ? banner.offsetHeight + 'px' : '0px');
        }
        function offset() {
            var top = parseFloat(getComputedStyle(bar).top) || 0;
            return top + bar.offsetHeight + 12;
        }
        function setCurrent(id) {
            links.forEach(function (a) { a.setAttribute('aria-current', a.dataset.sectionLink === id ? 'true' : 'false'); });
        }
        // The current section is the last one whose top has scrolled under the bar.
        function update() {
            var line = offset(), current = links[0] && links[0].dataset.sectionLink;
            links.forEach(function (a) {
                var target = document.getElementById(a.dataset.sectionLink);
                if (target && target.getBoundingClientRect().top - line <= 1) current = a.dataset.sectionLink;
            });
            if (window.innerHeight + window.scrollY >= document.body.scrollHeight - 2 && links.length) {
                current = links[links.length - 1].dataset.sectionLink;
            }
            setCurrent(current);
        }

        links.forEach(function (a) {
            a.addEventListener('click', function (event) {
                var target = document.getElementById(a.dataset.sectionLink);
                if (!target) return;
                event.preventDefault();
                window.scrollTo({ top: window.scrollY + target.getBoundingClientRect().top - offset(), behavior: 'smooth' });
                history.replaceState(null, '', '#' + a.dataset.sectionLink);
                // Put the cursor in the section's first box so typing can start straight away.
                var field = target.querySelector('input:not([type=hidden]):not([readonly]), textarea, select');
                if (field) setTimeout(function () { field.focus({ preventScroll: true }); }, 350);
            });
        });

        measure();
        update();
        window.addEventListener('resize', function () { measure(); update(); });
        window.addEventListener('scroll', update, { passive: true });
    })();
</script>
