// ═══════════════════════════════════════════════════════
//  Premax Autocare — Multi-step Booking JS
//  File: resources/js/booking.ts
// ═══════════════════════════════════════════════════════

interface BookingData {
    serviceId:  string;
    service:    string;
    price:      string;
    reg:        string;
    make:       string;
    date:       string;
    time:       string;
    name:       string;
    phone:      string;
    email:      string;
    notes:      string;
}

declare global {
    interface Window {
        PREMAX: { selectedServiceId: string | null };
        nextStep: (from: number) => void;
        prevStep: (from: number) => void;
    }
}

const state: BookingData = {
    serviceId: '', service: '', price: '',
    reg: '', make: '', date: '', time: '',
    name: '', phone: '', email: '', notes: '',
};

// ── Helpers ────────────────────────────────────────────

function $<T extends HTMLElement = HTMLElement>(id: string): T | null {
    return document.getElementById(id) as T | null;
}

function showError(id: string, show: boolean): void {
    $<HTMLElement>(id)?.classList.toggle('hidden', !show);
}

function isValidPhone(val: string): boolean {
    return /^[+\d\s\-()]{7,15}$/.test(val.trim());
}

// ── Validation ─────────────────────────────────────────

function validateStep(step: number): boolean {
    if (step === 1) {
        const ok = state.service !== '';
        showError('err-service', !ok);
        return ok;
    }
    if (step === 2) {
        const reg = $<HTMLInputElement>('reg-number')?.value.trim() ?? '';
        const ok  = reg.length > 0;
        showError('err-reg', !ok);
        if (ok) {
            state.reg  = reg;
            state.make = $<HTMLInputElement>('make-model')?.value.trim() ?? '';
        }
        return ok;
    }
    if (step === 3) {
        const dateOk = state.date !== '';
        const timeOk = state.time !== '';
        showError('err-date', !dateOk);
        showError('err-time', !timeOk);
        return dateOk && timeOk;
    }
    if (step === 4) {
        const nameVal  = $<HTMLInputElement>('full-name')?.value.trim() ?? '';
        const phoneVal = $<HTMLInputElement>('phone')?.value.trim()     ?? '';
        const nameOk   = nameVal.length > 0;
        const phoneOk  = isValidPhone(phoneVal);
        showError('err-name',  !nameOk);
        showError('err-phone', !phoneOk);
        if (nameOk)  state.name  = nameVal;
        if (phoneOk) state.phone = phoneVal;
        state.email = $<HTMLInputElement>('email')?.value.trim()    ?? '';
        state.notes = $<HTMLTextAreaElement>('notes')?.value.trim() ?? '';
        return nameOk && phoneOk;
    }
    return true;
}

// ── Stepper UI ─────────────────────────────────────────

function updateStepper(to: number): void {
    document.querySelectorAll<HTMLElement>('[data-step]').forEach(wrapper => {
        const step    = parseInt(wrapper.dataset.step ?? '0');
        const dot     = wrapper.querySelector<HTMLElement>('.step-circle');
        const numEl   = wrapper.querySelector<HTMLElement>('.step-num');
        const checkEl = wrapper.querySelector<HTMLElement>('.step-check');
        if (!dot || !numEl || !checkEl) return;

        if (step < to) {
            dot.classList.remove('bg-white', 'border-gray-300', 'text-gray-400');
            dot.classList.add('bg-custom-primary', 'border-custom-primary', 'text-white');
            numEl.classList.add('hidden');
            checkEl.classList.remove('hidden');
        } else if (step === to) {
            dot.classList.remove('bg-white', 'border-gray-300', 'text-gray-400');
            dot.classList.add('bg-custom-primary', 'border-custom-primary', 'text-white');
            numEl.classList.remove('hidden');
            checkEl.classList.add('hidden');
        } else {
            dot.classList.remove('bg-custom-primary', 'border-custom-primary', 'text-white');
            dot.classList.add('bg-white', 'border-gray-300', 'text-gray-400');
            numEl.classList.remove('hidden');
            checkEl.classList.add('hidden');
        }
    });

    document.querySelectorAll<HTMLElement>('[data-line]').forEach(line => {
        const n = parseInt(line.dataset.line ?? '0');
        line.classList.toggle('bg-custom-primary', n < to);
        line.classList.toggle('bg-gray-300',       n >= to);
    });
}

function showPanel(step: number): void {
    document.querySelectorAll<HTMLElement>('.step-panel').forEach(p => p.classList.add('hidden'));
    $(`step-${step}`)?.classList.remove('hidden');
}

// ── Confirm summary ─────────────────────────────────────

function populateConfirm(): void {
    const vehicle = [state.reg, state.make].filter(Boolean).join(' · ');
    const dateLabel = state.date
        ? new Date(state.date + 'T00:00:00').toLocaleDateString('en-KE', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' })
        : '—';

    const confirmService  = $<HTMLElement>('confirm-service');
    const confirmPrice    = $<HTMLElement>('confirm-price');
    const confirmVehicle  = $<HTMLElement>('confirm-vehicle');
    const confirmDatetime = $<HTMLElement>('confirm-datetime');
    const confirmName     = $<HTMLElement>('confirm-name');
    const confirmPhone    = $<HTMLElement>('confirm-phone');

    if (confirmService)  confirmService.textContent  = state.service || 'Not selected';
    if (confirmPrice)    confirmPrice.textContent     = state.price   || '';
    if (confirmVehicle)  confirmVehicle.textContent   = vehicle        || '—';
    if (confirmDatetime) confirmDatetime.textContent  = (state.date && state.time) ? `${dateLabel} at ${state.time}` : '—';
    if (confirmName)     confirmName.textContent      = state.name    || '—';
    if (confirmPhone)    confirmPhone.textContent     = state.phone   || '—';

    // Fill hidden form fields
    const fields: Record<string, string> = {
        'h-service-id': state.serviceId,
        'h-service':    state.service,
        'h-reg':        state.reg,
        'h-make':       state.make,
        'h-date':       state.date,
        'h-time':       state.time,
        'h-name':       state.name,
        'h-phone':      state.phone,
        'h-email':      state.email,
        'h-notes':      state.notes,
    };
    Object.entries(fields).forEach(([id, val]) => {
        const el = $<HTMLInputElement>(id);
        if (el) el.value = val;
    });
}

// ── Public navigation ──────────────────────────────────

window.nextStep = function(from: number): void {
    if (!validateStep(from)) return;
    const to = from + 1;
    updateStepper(to);
    showPanel(to);
    if (to === 5) populateConfirm();
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

window.prevStep = function(from: number): void {
    const to = from - 1;
    if (to < 1) return;
    updateStepper(to);
    showPanel(to);
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

// ── Boot ───────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {

    // ── Category tab switching ──────────────────────────
    document.querySelectorAll<HTMLButtonElement>('.category-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.category ?? '';

            // Update tab styles
            document.querySelectorAll<HTMLButtonElement>('.category-tab').forEach(t => {
                t.classList.remove('bg-custom-primary', 'text-white', 'border-custom-primary');
                t.classList.add('bg-white', 'text-gray-600', 'border-gray-300');
            });
            tab.classList.add('bg-custom-primary', 'text-white', 'border-custom-primary');
            tab.classList.remove('bg-white', 'text-gray-600', 'border-gray-300');

            // Show/hide groups
            document.querySelectorAll<HTMLElement>('.category-group').forEach(group => {
                group.style.display = group.dataset.group === target ? 'grid' : 'none';
            });
        });
    });

    // ── Service card selection ──────────────────────────
    function selectServiceCard(card: HTMLButtonElement): void {
        document.querySelectorAll<HTMLButtonElement>('.service-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        state.service   = card.dataset.service   ?? '';
        state.serviceId = card.dataset.serviceId ?? '';
        state.price     = card.dataset.price     ?? '';
        showError('err-service', false);
    }

    document.querySelectorAll<HTMLButtonElement>('.service-card').forEach(card => {
        card.addEventListener('click', () => selectServiceCard(card));
    });

    // Pre-select if ?service= was passed from homepage cards
    const preselectedId = window.PREMAX?.selectedServiceId;
    if (preselectedId) {
        const target = document.querySelector<HTMLButtonElement>(
            `.service-card[data-service-id="${preselectedId}"]`
        );
        if (target) {
            // Switch to its category tab first
            const parentGroup = target.closest<HTMLElement>('.category-group');
            if (parentGroup) {
                const groupKey = parentGroup.dataset.group ?? '';
                const tab = document.querySelector<HTMLButtonElement>(
                    `.category-tab[data-category="${groupKey}"]`
                );
                tab?.click();
            }
            selectServiceCard(target);
        }
    }

    // Also handle data-preselect attribute rendered by Blade
    const bladePreselect = document.querySelector<HTMLButtonElement>('.service-card[data-preselect]');
    if (bladePreselect && !preselectedId) selectServiceCard(bladePreselect);

    // ── Time slot selection ─────────────────────────────
    document.querySelectorAll<HTMLButtonElement>('.time-slot').forEach(slot => {
        slot.addEventListener('click', () => {
            document.querySelectorAll<HTMLButtonElement>('.time-slot').forEach(s => s.classList.remove('selected'));
            slot.classList.add('selected');
            state.time = slot.dataset.time ?? '';
            showError('err-time', false);
        });
    });

    // ── Date input ──────────────────────────────────────
    const dateInput = $<HTMLInputElement>('booking-date');
    if (dateInput) {
        dateInput.addEventListener('change', () => {
            state.date = dateInput.value;
            showError('err-date', false);
        });
    }

    // ── Clear errors on input ───────────────────────────
    const clearMap: Record<string, string> = {
        'reg-number': 'err-reg',
        'full-name':  'err-name',
        'phone':      'err-phone',
    };
    Object.entries(clearMap).forEach(([inputId, errId]) => {
        $<HTMLInputElement>(inputId)?.addEventListener('input', () => showError(errId, false));
    });
});