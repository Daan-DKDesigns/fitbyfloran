
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

// Intakeformulier versturen zonder de pagina te herladen: geen sprong terug naar boven,
// de bezoeker blijft waar hij is en ziet de bevestiging op dezelfde plek.
// Zonder JavaScript (of bij een netwerkfout) werkt het formulier gewoon zoals voorheen.
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form.contact-form');
    if (!form || !window.fetch || !window.FormData) {
        return;
    }

    const knop = form.querySelector('button[type="submit"]');
    const knopTekst = knop ? knop.textContent : '';
    const whatsapp = form.getAttribute('data-whatsapp') || '';

    // Eén meldingsvak boven de knop, dat schermlezers voorlezen.
    const melding = document.createElement('p');
    melding.className = 'contact-form__notice contact-form__notice--err';
    melding.setAttribute('role', 'alert');
    melding.hidden = true;
    const submit = form.querySelector('.contact-form__submit');
    if (submit) {
        submit.parentNode.insertBefore(melding, submit);
    }

    function fout(tekst) {
        melding.textContent = tekst;
        melding.hidden = false;
        if (knop) {
            knop.disabled = false;
            knop.textContent = knopTekst;
        }
    }

    function gelukt() {
        const naam = (form.querySelector('#fbf_naam') || {}).value || '';
        const voornaam = naam.trim().split(/\s+/)[0] || '';
        const kaart = document.createElement('div');
        kaart.className = 'contact-form__klaar';
        kaart.setAttribute('role', 'status');
        kaart.setAttribute('tabindex', '-1');
        kaart.innerHTML =
            '<div class="contact-form__vink" aria-hidden="true">' +
            '<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7.5"/></svg>' +
            '</div>' +
            '<h3></h3>' +
            '<p>Je aanvraag is verstuurd. Je ontvangt een bevestiging per e-mail en ik neem zo snel mogelijk persoonlijk contact met je op.</p>' +
            (whatsapp ? '<a class="contact-form__klaar-wa" target="_blank" rel="noopener noreferrer"></a>' : '');
        kaart.querySelector('h3').textContent = voornaam ? 'Bedankt, ' + voornaam + '!' : 'Bedankt!';
        const wa = kaart.querySelector('.contact-form__klaar-wa');
        if (wa) {
            wa.href = whatsapp;
            wa.textContent = 'Wil je nog iets aanvullen? Stuur een WhatsApp';
        }

        // De kaart houdt dezelfde hoogte, zodat er niets verspringt op de pagina.
        form.style.minHeight = form.offsetHeight + 'px';
        form.classList.add('is-verstuurd');
        form.replaceChildren(kaart);
        kaart.focus({ preventScroll: true });
    }

    form.addEventListener('submit', function (event) {
        // De browser heeft de verplichte velden al gecontroleerd voordat dit gebeurt.
        event.preventDefault();
        melding.hidden = true;
        if (knop) {
            knop.disabled = true;
            knop.textContent = 'Bezig met versturen…';
        }

        const gegevens = new FormData(form);
        gegevens.append('fbf_ajax', '1');

        fetch(form.getAttribute('action'), {
            method: 'POST',
            body: gegevens,
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(function (antwoord) {
                return antwoord.json();
            })
            .then(function (resultaat) {
                if (resultaat && resultaat.status === 'verzonden') {
                    gelukt();
                } else {
                    fout('Je aanvraag kon niet worden verstuurd. Controleer je naam en e-mailadres en kies waar ik je mee kan helpen, of stuur een WhatsApp.');
                }
            })
            .catch(function () {
                fout('Er ging iets mis met de verbinding. Probeer het nog eens of stuur een WhatsApp.');
            });
    });
});
