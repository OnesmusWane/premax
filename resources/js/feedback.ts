// ═══════════════════════════════════════════════════════
//  Premax Autocare — Feedback Form Controller
//  Compile: tsc feedback.ts --target ES2017 --outFile feedback.js
//  Or import in your Vite/Laravel Mix entry point
// ═══════════════════════════════════════════════════════

// ── Types ──────────────────────────────────────────────

interface FeedbackState {
  rating: number;
}

const state: FeedbackState = {
  rating: 0,
};

// ── Helpers ─────────────────────────────────────────────

function getEl<T extends HTMLElement>(id: string): T | null {
  return document.getElementById(id) as T | null;
}

function showError(id: string, visible: boolean): void {
  getEl(id)?.classList.toggle('hidden', !visible);
}

function setInputError(input: HTMLElement | null, hasError: boolean): void {
  if (!input) return;
  if (hasError) {
    input.classList.add('border-custom-primary');
    input.classList.remove('border-gray-200');
  } else {
    input.classList.remove('border-custom-primary');
    input.classList.add('border-gray-200');
  }
}

// ── Star Rating ─────────────────────────────────────────

function initStars(): void {
  const stars = document.querySelectorAll<HTMLButtonElement>('#star-group .star-btn');
  const ratingInput = getEl<HTMLInputElement>('fb-rating');

  // Restore any previously selected rating (e.g. on validation failure redirect)
  const savedRating = parseInt(ratingInput?.value ?? '0');
  if (savedRating > 0) {
    state.rating = savedRating;
    paintStars(stars, savedRating);
  }

  stars.forEach(star => {
    const value = parseInt(star.dataset.value ?? '0');

    // Hover: preview fill
    star.addEventListener('mouseenter', () => paintStars(stars, value));

    // Mouse leave: restore selected or clear
    star.addEventListener('mouseleave', () => paintStars(stars, state.rating));

    // Click: commit selection
    star.addEventListener('click', () => {
      state.rating = value;
      if (ratingInput) ratingInput.value = String(value);
      paintStars(stars, value);
      showError('err-rating', false);
    });
  });
}

function paintStars(
  stars: NodeListOf<HTMLButtonElement>,
  upTo: number
): void {
  stars.forEach(star => {
    const value = parseInt(star.dataset.value ?? '0');
    const svg   = star.querySelector('svg');
    if (!svg) return;

    if (value <= upTo) {
      svg.setAttribute('fill', '#FBBF24');
      svg.setAttribute('stroke', '#FBBF24');
    } else {
      svg.setAttribute('fill', 'none');
      svg.setAttribute('stroke', '#CBD5E1');
    }
  });
}

// ── Form Validation ─────────────────────────────────────

function validateFeedback(): boolean {
  let valid = true;

  // Name (required)
  const nameInput = getEl<HTMLInputElement>('fb-name');
  const nameOk    = (nameInput?.value.trim().length ?? 0) > 0;
  showError('err-name', !nameOk);
  setInputError(nameInput, !nameOk);
  if (!nameOk) valid = false;

  // Rating (required)
  const ratingOk = state.rating > 0;
  showError('err-rating', !ratingOk);
  if (!ratingOk) valid = false;

  return valid;
}

// ── Submit Handler ──────────────────────────────────────

function initForm(): void {
  const form       = getEl<HTMLFormElement>('feedback-form');
  const submitBtn  = getEl<HTMLButtonElement>('submit-btn');

  if (!form) return;

  form.addEventListener('submit', (e: Event) => {
    e.preventDefault();

    if (!validateFeedback()) {
      // Scroll to first error
      const firstError = form.querySelector<HTMLElement>(':not(.hidden).text-custom-primary');
      firstError?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      return;
    }

    // Show loading state
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting...';
      submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
    }

    form.submit();
  });

  // Clear name error on input
  getEl('fb-name')?.addEventListener('input', () => {
    showError('err-name', false);
    setInputError(getEl('fb-name'), false);
  });
}

// ── Boot ────────────────────────────────────────────────

document.addEventListener('DOMContentLoaded', () => {
  initStars();
  initForm();
});