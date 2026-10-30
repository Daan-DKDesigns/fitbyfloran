/**
 * Micro-animaties voor een luxer gevoel.
 * - Elementen buiten beeld komen zacht en getrapt in beeld bij het scrollen.
 * - Met de scroll mee: voortgangsbalk, slankere header, hero-tekst die wegdrijft
 *   en foto's die licht meebewegen (parallax via object-position, dus zonder layoutsprongen).
 * Uit voor bezoekers met "beweging beperken" in hun systeeminstellingen.
 */
(function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.classList.remove('fbf-anim');
        return;
    }

    function init() {
        /* ---------- In beeld komen ---------- */
        var selectors = [
            'main .kicker', 'main h2', 'main .lead', '.copy p', '.copy .btn',
            '.step', '.service', '.special-card', '.partner-logo', '.partner-note',
            '.about-images img', '.second img', '.contact-form', '.footer-top > div'
        ];
        var items = document.querySelectorAll(selectors.join(','));
        var viewport = window.innerHeight;

        if ('IntersectionObserver' in window) {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '0px 0px -8% 0px', threshold: 0.12 });

            items.forEach(function (el) {
                // Wat bij het laden al in beeld staat, laten we gewoon staan (geen flits).
                if (el.getBoundingClientRect().top < viewport * 0.92) {
                    return;
                }
                // Kaarten in een rij komen één voor één binnen.
                var parent = el.parentElement;
                var index = parent ? Array.prototype.indexOf.call(parent.children, el) : 0;
                el.style.setProperty('--fbf-delay', Math.min(index, 5) * 90 + 'ms');
                el.classList.add('fbf-reveal');
                observer.observe(el);
            });
        }

        /* ---------- Met de scroll mee ---------- */
        var header = document.querySelector('.site-header');
        var hero = document.querySelector('.hero-inner');
        var parallax = Array.prototype.slice.call(document.querySelectorAll('.about-images img, .second img'));

        var progress = document.createElement('div');
        progress.className = 'fbf-progress';
        progress.setAttribute('aria-hidden', 'true');
        document.body.appendChild(progress);

        var ticking = false;

        function update() {
            ticking = false;
            var y = window.scrollY || window.pageYOffset;
            var vh = window.innerHeight;
            var max = document.documentElement.scrollHeight - vh;

            progress.style.transform = 'scaleX(' + (max > 0 ? Math.min(y / max, 1) : 0) + ')';

            if (header) {
                header.classList.toggle('is-scrolled', y > 40);
            }

            if (hero && y < vh * 1.2) {
                hero.style.transform = 'translate3d(0,' + (y * 0.22).toFixed(1) + 'px,0)';
                hero.style.opacity = Math.max(1 - y / (vh * 0.85), 0).toFixed(3);
            }

            parallax.forEach(function (img) {
                var r = img.getBoundingClientRect();
                if (r.bottom < 0 || r.top > vh) {
                    return;
                }
                // 0 = foto komt onderin binnen, 1 = foto verlaat bovenin het beeld.
                var p = (vh - r.top) / (vh + r.height);
                img.style.objectPosition = '50% ' + (30 + p * 40).toFixed(1) + '%';
            });
        }

        function onScroll() {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }

        window.addEventListener('scroll', onScroll, { passive: true });
        window.addEventListener('resize', onScroll, { passive: true });
        update();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
