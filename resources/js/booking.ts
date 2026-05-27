// ═══════════════════════════════════════════════════════
//  Premax Autocare — Multi-step Booking JS
//  File: resources/js/booking.ts
// ═══════════════════════════════════════════════════════
export {};

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
        nextStep: (from: number) => void;
        prevStep: (from: number) => void;
    }
}

interface UserPrefill {
    name:  string;
    phone: string;
    email: string;
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

const STEP_ACTIVE   = ['bg-custom-primary', 'border-custom-primary', 'text-white'];
const STEP_INACTIVE = ['bg-[#1a1a1a]', 'border-white/15', 'text-white/30'];

function updateStepper(to: number): void {
    document.querySelectorAll<HTMLElement>('[data-step]').forEach(wrapper => {
        const step    = parseInt(wrapper.dataset.step ?? '0');
        const dot     = wrapper.querySelector<HTMLElement>('.step-circle');
        const numEl   = wrapper.querySelector<HTMLElement>('.step-num');
        const checkEl = wrapper.querySelector<HTMLElement>('.step-check');
        if (!dot || !numEl || !checkEl) return;

        if (step < to) {
            dot.classList.remove(...STEP_INACTIVE);
            dot.classList.add(...STEP_ACTIVE);
            numEl.classList.add('hidden');
            checkEl.classList.remove('hidden');
        } else if (step === to) {
            dot.classList.remove(...STEP_INACTIVE);
            dot.classList.add(...STEP_ACTIVE);
            numEl.classList.remove('hidden');
            checkEl.classList.add('hidden');
        } else {
            dot.classList.remove(...STEP_ACTIVE);
            dot.classList.add(...STEP_INACTIVE);
            numEl.classList.remove('hidden');
            checkEl.classList.add('hidden');
        }
    });

    document.querySelectorAll<HTMLElement>('[data-line]').forEach(line => {
        const n = parseInt(line.dataset.line ?? '0');
        line.classList.toggle('bg-custom-primary', n < to);
        line.classList.toggle('bg-white/10',       n >= to);
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
    const TAB_ACTIVE   = ['bg-custom-primary', 'text-white', 'border-custom-primary'];
    const TAB_INACTIVE = ['bg-transparent', 'text-white/40', 'border-white/10'];

    document.querySelectorAll<HTMLButtonElement>('.category-tab').forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.category ?? '';

            document.querySelectorAll<HTMLButtonElement>('.category-tab').forEach(t => {
                t.classList.remove(...TAB_ACTIVE);
                t.classList.add(...TAB_INACTIVE);
            });
            tab.classList.remove(...TAB_INACTIVE);
            tab.classList.add(...TAB_ACTIVE);

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

    // ── Read server-rendered data ───────────────────────
    const premaxEl      = document.getElementById('premax-data');
    const preselectedId = premaxEl?.dataset.selectedService ?? '';
    const userData      = premaxEl?.dataset.user ? JSON.parse(premaxEl.dataset.user) as UserPrefill | null : null;

    // Pre-select service when ?service= passed from service cards
    if (preselectedId) {
        const target = document.querySelector<HTMLButtonElement>(
            `.service-card[data-service-id="${preselectedId}"]`
        );
        if (target) {
            const parentGroup = target.closest<HTMLElement>('.category-group');
            if (parentGroup) {
                const groupKey = parentGroup.dataset.group ?? '';
                document.querySelector<HTMLButtonElement>(
                    `.category-tab[data-category="${groupKey}"]`
                )?.click();
            }
            selectServiceCard(target);
        }
    } else {
        const bladePreselect = document.querySelector<HTMLButtonElement>('.service-card[data-preselect]');
        if (bladePreselect) selectServiceCard(bladePreselect);
    }

    // ── Pre-fill step 4 with logged-in user details ─────
    if (userData) {
        const nameInput  = $<HTMLInputElement>('full-name');
        const phoneInput = $<HTMLInputElement>('phone');
        const emailInput = $<HTMLInputElement>('email');
        if (nameInput  && userData.name)  nameInput.value  = userData.name;
        if (phoneInput && userData.phone) phoneInput.value = userData.phone;
        if (emailInput && userData.email) emailInput.value = userData.email;
    }

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