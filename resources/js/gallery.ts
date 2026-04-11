interface GalleryItem {
  element: HTMLElement;
  src: string;
  title: string;
  desc: string;
  category: string;
}

const $ = <T extends HTMLElement>(selector: string): T | null =>
  document.querySelector<T>(selector);

const $$ = <T extends Element>(selector: string, ctx: ParentNode = document): T[] =>
  Array.from(ctx.querySelectorAll<T>(selector));

let allItems: GalleryItem[] = [];
let visibleItems: GalleryItem[] = [];
let activeCategory = 'All';
let lightboxIndex = 0;
let heroIndex = 0;
let heroTimer: ReturnType<typeof setInterval> | null = null;

function buildItems(): void {
  allItems = $$<HTMLElement>('[data-gallery-item]').map((element) => ({
    element,
    src: element.dataset.src ?? '',
    title: element.dataset.title ?? 'Premax Autocare',
    desc: element.dataset.desc ?? '',
    category: element.dataset.category ?? 'Uncategorised',
  }));

  visibleItems = [...allItems];
}

function renderCounts(): void {
  const count = $('#gallery-visible-count');
  const empty = $('#gallery-empty');

  if (count) {
    count.textContent = String(visibleItems.length);
  }

  if (empty) {
    empty.classList.toggle('hidden', visibleItems.length > 0);
  }
}

function setActiveFilterButton(filter: string): void {
  $$<HTMLButtonElement>('[data-filter]').forEach((button) => {
    const isActive = button.dataset.filter === filter;
    button.classList.toggle('active', isActive);

    const count = button.querySelector('span');
    if (count) {
      count.classList.toggle('text-white/75', isActive);
      count.classList.toggle('text-gray-400', !isActive);
    }
  });
}

function applyFilter(filter: string): void {
  activeCategory = filter;
  visibleItems = [];

  allItems.forEach((item) => {
    const show = filter === 'All' || item.category === filter;
    item.element.classList.toggle('hidden-item', !show);

    if (show) {
      visibleItems.push(item);
    }
  });

  setActiveFilterButton(filter);
  renderCounts();
}

function renderLightboxThumbs(): void {
  const thumbs = $('#lb-thumbs');
  if (!thumbs) return;

  thumbs.innerHTML = '';

  visibleItems.forEach((item, index) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = 'gallery-lightbox-thumb h-11 w-16 flex-shrink-0 overflow-hidden rounded-md border-2 border-transparent opacity-40 transition-all duration-200 hover:opacity-70';
    button.setAttribute('aria-label', `View image ${index + 1}`);

    if (index === lightboxIndex) {
      button.classList.add('active');
    }

    button.innerHTML = `<img src="${item.src}" alt="${item.title}" class="h-full w-full object-cover">`;
    button.addEventListener('click', () => {
      renderLightbox(index);
    });

    thumbs.appendChild(button);
  });
}

function renderLightbox(index: number): void {
  const item = visibleItems[index];
  const image = $<HTMLImageElement>('#lb-img');
  const title = $('#lb-title');
  const meta = $('#lb-meta');
  const desc = $('#lb-desc');

  if (!item || !image) return;

  lightboxIndex = index;
  image.classList.add('is-loading');

  window.setTimeout(() => {
    image.src = item.src;
    image.alt = item.title;
    image.classList.remove('is-loading');
  }, 120);

  if (title) {
    title.textContent = item.title;
  }

  if (meta) {
    meta.textContent = `${item.category} • ${index + 1} / ${visibleItems.length}`;
  }

  if (desc) {
    desc.textContent = item.desc || 'Real work completed by the Premax Autocare team.';
  }

  renderLightboxThumbs();
}

function openLightbox(index: number): void {
  const lightbox = $('#gallery-lightbox');
  if (!lightbox || !visibleItems[index]) return;

  lightbox.classList.add('open');
  document.body.style.overflow = 'hidden';
  renderLightbox(index);
}

function closeLightbox(): void {
  $('#gallery-lightbox')?.classList.remove('open');
  document.body.style.overflow = '';
}

function navigateLightbox(direction: number): void {
  if (!visibleItems.length) return;
  const next = (lightboxIndex + direction + visibleItems.length) % visibleItems.length;
  renderLightbox(next);
}

function setHeroSlide(index: number): void {
  const slides = $$<HTMLElement>('[data-hero-slide]');
  const thumbs = $$<HTMLButtonElement>('[data-hero-thumb]');

  if (!slides.length) return;

  heroIndex = (index + slides.length) % slides.length;

  slides.forEach((slide, slideIndex) => {
    slide.classList.toggle('active', slideIndex === heroIndex);
  });

  thumbs.forEach((thumb, thumbIndex) => {
    thumb.classList.toggle('active', thumbIndex === heroIndex);
  });
}

function restartHeroTimer(): void {
  if (heroTimer) {
    clearInterval(heroTimer);
  }

  const slides = $$('[data-hero-slide]');
  if (slides.length <= 1) return;

  heroTimer = setInterval(() => {
    setHeroSlide(heroIndex + 1);
  }, 5000);
}

function initHero(): void {
  const slides = $$('[data-hero-slide]');
  if (!slides.length) return;

  $$<HTMLButtonElement>('[data-hero-thumb]').forEach((button) => {
    button.addEventListener('click', () => {
      setHeroSlide(Number(button.dataset.heroTarget ?? '0'));
      restartHeroTimer();
    });
  });

  $('[data-hero-prev]')?.addEventListener('click', () => {
    setHeroSlide(heroIndex - 1);
    restartHeroTimer();
  });

  $('[data-hero-next]')?.addEventListener('click', () => {
    setHeroSlide(heroIndex + 1);
    restartHeroTimer();
  });

  setHeroSlide(0);
  restartHeroTimer();
}

function initFilters(): void {
  $$<HTMLButtonElement>('[data-filter]').forEach((button) => {
    button.addEventListener('click', () => {
      const filter = button.dataset.filter ?? 'All';
      applyFilter(filter);
      button.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    });
  });
}

function initCards(): void {
  allItems.forEach((item) => {
    const open = () => {
      const index = visibleItems.findIndex((visibleItem) => visibleItem.src === item.src);
      if (index >= 0) openLightbox(index);
    };

    item.element.addEventListener('click', open);
    item.element.addEventListener('keydown', (event: KeyboardEvent) => {
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        open();
      }
    });
  });
}

function initLightbox(): void {
  $('#lb-close')?.addEventListener('click', closeLightbox);
  $('#lb-prev')?.addEventListener('click', () => navigateLightbox(-1));
  $('#lb-next')?.addEventListener('click', () => navigateLightbox(1));

  $('#gallery-lightbox')?.addEventListener('click', (event) => {
    if (event.target === event.currentTarget) {
      closeLightbox();
    }
  });

  document.addEventListener('keydown', (event: KeyboardEvent) => {
    const lightbox = $('#gallery-lightbox');
    if (!lightbox?.classList.contains('open')) return;

    if (event.key === 'Escape') closeLightbox();
    if (event.key === 'ArrowLeft') navigateLightbox(-1);
    if (event.key === 'ArrowRight') navigateLightbox(1);
  });

  let touchStartX = 0;

  $('#gallery-lightbox')?.addEventListener('touchstart', (event: TouchEvent) => {
    touchStartX = event.changedTouches[0].clientX;
  }, { passive: true });

  $('#gallery-lightbox')?.addEventListener('touchend', (event: TouchEvent) => {
    const delta = event.changedTouches[0].clientX - touchStartX;
    if (Math.abs(delta) < 50) return;
    navigateLightbox(delta < 0 ? 1 : -1);
  }, { passive: true });
}

document.addEventListener('DOMContentLoaded', () => {
  buildItems();
  initHero();
  initFilters();
  initCards();
  initLightbox();
  applyFilter(activeCategory);
});
