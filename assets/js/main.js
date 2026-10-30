
document.addEventListener('DOMContentLoaded', function () {
    const header = document.querySelector('.site-header');
    const hamburger = document.getElementById('navHamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    if (!header || !hamburger || !mobileMenu) {
        return;
    }

    function setMenuOpen(open) {
        hamburger.setAttribute('aria-expanded', String(open));
        hamburger.setAttribute(
            'aria-label',
            open ? 'Menu sluiten' : 'Menu openen'
        );

        mobileMenu.classList.toggle('is-open', open);
        mobileMenu.setAttribute('aria-hidden', String(!open));

        // De pagina eronder scrollt niet mee zolang het menu open is.
        // Het hamburgericoon wordt via CSS (aria-expanded) een kruisje.
        document.documentElement.classList.toggle('fbf-menu-open', open);
    }

    hamburger.addEventListener('click', function () {
        const isOpen =
            hamburger.getAttribute('aria-expanded') === 'true';

        setMenuOpen(!isOpen);

        // Toetsenbord en schermlezer: na openen meteen in het menu, na sluiten terug op de knop.
        if (!isOpen) {
            const eerste = mobileMenu.querySelector('a');
            if (eerste) {
                window.setTimeout(function () { eerste.focus({ preventScroll: true }); }, 50);
            }
        }
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
        if (window.innerWidth > 1000) {
            setMenuOpen(false);
        }
    });
}); 

// Intakeformulier: een knop bij een traject of specialisatie vult "Waar kan ik je mee helpen?" alvast in.
document.addEventListener('DOMContentLoaded', function () {
    const keuze = document.getElementById('fbf_hulpvraag');
    if (!keuze) {
        return;
    }

    document.addEventListener('click', function (event) {
        const knop = event.target.closest('[data-hulpvraag]');
        if (!knop) {
            return;
        }
        const waarde = knop.getAttribute('data-hulpvraag');
        const optie = Array.prototype.find.call(keuze.options, function (o) {
            return o.value === waarde;
        });
        if (optie) {
            keuze.value = waarde;
        }
    });
});
