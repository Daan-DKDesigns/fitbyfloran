
document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.site-header');
    const hamburger = document.getElementById('navHamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    if (!header || !hamburger || !mobileMenu) {
        return;
    }

    const icon = document.getElementById('hamburgerIcon');

    function setMenuOpen(open) {
        hamburger.setAttribute('aria-expanded', String(open));
        hamburger.setAttribute(
            'aria-label',
            open ? 'Menu sluiten' : 'Menu openen'
        );

        mobileMenu.classList.toggle('is-open', open);
        mobileMenu.setAttribute('aria-hidden', String(!open));

        if (icon) {
            icon.innerHTML = open
                ? '<line x1="18" y1="6" x2="6" y2="18"></line>' +
                  '<line x1="6" y1="6" x2="18" y2="18"></line>'
                : '<line x1="3" y1="6" x2="21" y2="6"></line>' +
                  '<line x1="3" y1="12" x2="21" y2="12"></line>' +
                  '<line x1="3" y1="18" x2="21" y2="18"></line>';
        }
    }

    hamburger.addEventListener('click', function () {
        const isOpen =
            hamburger.getAttribute('aria-expanded') === 'true';

        setMenuOpen(!isOpen);
    });

    // Sluit met Escape
    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            hamburger.getAttribute('aria-expanded') === 'true'
        ) {
            setMenuOpen(false);
            hamburger.focus();
        }
    });

    // Sluit na het kiezen van een link
    mobileMenu.addEventListener('click', function (event) {
        if (event.target.closest('a')) {
            setMenuOpen(false);
        }
    });

    // Sluit wanneer het desktopmenu weer zichtbaar wordt
    window.addEventListener('resize', function () {
        if (window.innerWidth > 900) {
            setMenuOpen(false);
        }
    });
});