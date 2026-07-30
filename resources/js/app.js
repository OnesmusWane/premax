document.addEventListener('DOMContentLoaded', () => {
    const widgets = document.querySelectorAll('[data-whatsapp-float]');

    widgets.forEach((widget) => {
        const toggle = widget.querySelector('[data-whatsapp-toggle]');
        const menu = widget.querySelector('[data-whatsapp-menu]');

        if (!toggle || !menu) {
            return;
        }

        const setOpen = (isOpen) => {
            menu.dataset.open = isOpen ? 'true' : 'false';
            menu.hidden = !isOpen;
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        setOpen(false);

        toggle.addEventListener('click', () => {
            setOpen(menu.hidden);
        });

        document.addEventListener('click', (event) => {
            if (!widget.contains(event.target)) {
                setOpen(false);
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                setOpen(false);
            }
        });
    });
});
