(function () {
  'use strict';
  var hamburger = document.getElementById('navHamburger');
  var menu = document.getElementById('mobileMenu');
  var icon = document.getElementById('hamburgerIcon');
  var header = document.querySelector('header');
  var BURGER = '<line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
  var CROSS = '<line x1="5" y1="5" x2="19" y2="19"></line><line x1="19" y1="5" x2="5" y2="19"></line>';

  if (!hamburger || !menu) { return; }

  // Houdt het menu exact onder de header, ongeacht headerhoogte
  // (logo-formaat, extra meldingen, desktop/mobiel) of schermrotatie.
  function syncHeaderHeight() {
    if (header) {
      document.documentElement.style.setProperty('--header-h', header.offsetHeight + 'px');
    }
  }

  function closeMenu() {
    menu.classList.remove('open');
    hamburger.setAttribute('aria-expanded', 'false');
    hamburger.setAttribute('aria-label', 'Open menu');
    icon.innerHTML = BURGER;
  }
  function openMenu() {
    syncHeaderHeight();
    menu.classList.add('open');
    hamburger.setAttribute('aria-expanded', 'true');
    hamburger.setAttribute('aria-label', 'Sluit menu');
    icon.innerHTML = CROSS;
  }

  syncHeaderHeight();

  hamburger.addEventListener('click', function () {
    menu.classList.contains('open') ? closeMenu() : openMenu();
  });
  menu.querySelectorAll('a').forEach(function (a) {
    a.addEventListener('click', closeMenu);
  });
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') { closeMenu(); }
  });
  window.matchMedia('(min-width: 1001px)').addEventListener('change', function (e) {
    if (e.matches) { closeMenu(); }
  });
  window.addEventListener('resize', syncHeaderHeight);
  window.addEventListener('orientationchange', syncHeaderHeight);
  window.addEventListener('load', syncHeaderHeight);
})();
