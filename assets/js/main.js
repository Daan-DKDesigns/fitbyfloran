(function () {
  'use strict';

  // Scroll-reveal animaties.
  var items = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (e.isIntersecting) {
          e.target.classList.add('in');
        }
      });
    }, { threshold: 0.15 });
    items.forEach(function (i) { io.observe(i); });
  } else {
    items.forEach(function (i) { i.classList.add('in'); });
  }

  // Licht/donker-toggle.
  var SUN = '<circle cx="12" cy="12" r="4"></circle><line x1="12" y1="2" x2="12" y2="4.5"></line><line x1="12" y1="19.5" x2="12" y2="22"></line><line x1="4.2" y1="4.2" x2="6" y2="6"></line><line x1="18" y1="18" x2="19.8" y2="19.8"></line><line x1="2" y1="12" x2="4.5" y2="12"></line><line x1="19.5" y1="12" x2="22" y2="12"></line><line x1="4.2" y1="19.8" x2="6" y2="18"></line><line x1="18" y1="6" x2="19.8" y2="4.2"></line>';
  var MOON = '<path d="M20.5 14.2A8.5 8.5 0 1 1 9.8 3.5a7 7 0 0 0 10.7 10.7z" fill="currentColor" stroke="none"></path>';

  var toggleButtons = document.querySelectorAll('.theme-toggle');

  function applyTheme(theme) {
    var isLight = theme === 'light';
    if (isLight) {
      document.documentElement.setAttribute('data-theme', 'light');
    } else {
      document.documentElement.removeAttribute('data-theme');
    }
    toggleButtons.forEach(function (btn) {
      var svg = btn.querySelector('svg');
      if (svg) { svg.innerHTML = isLight ? MOON : SUN; }
      btn.setAttribute('aria-label', isLight ? 'Wissel naar donkere weergave' : 'Wissel naar lichte weergave');
      btn.setAttribute('aria-pressed', isLight ? 'true' : 'false');
    });
  }

  var saved = 'dark';
  try {
    saved = window.localStorage.getItem('fbf-theme') || 'dark';
  } catch (err) {
    // localStorage niet beschikbaar (bijv. privémodus); val terug op 'dark'.
  }
  applyTheme(saved);

  toggleButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      var current = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
      var next = current === 'light' ? 'dark' : 'light';
      applyTheme(next);
      try {
        window.localStorage.setItem('fbf-theme', next);
      } catch (err) {
        // negeer opslagfouten
      }
    });
  });

  // Hamburgermenu.
  var navHamburger = document.getElementById('navHamburger');
  var mobileMenu = document.getElementById('mobileMenu');
  var hamburgerIcon = document.getElementById('hamburgerIcon');
  var BURGER = '<line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="18" x2="21" y2="18"></line>';
  var CROSS = '<line x1="5" y1="5" x2="19" y2="19"></line><line x1="19" y1="5" x2="5" y2="19"></line>';

  if (navHamburger && mobileMenu && hamburgerIcon) {
    function closeMenu() {
      mobileMenu.classList.remove('open');
      navHamburger.setAttribute('aria-expanded', 'false');
      navHamburger.setAttribute('aria-label', 'Open menu');
      hamburgerIcon.innerHTML = BURGER;
    }
    function openMenu() {
      mobileMenu.classList.add('open');
      navHamburger.setAttribute('aria-expanded', 'true');
      navHamburger.setAttribute('aria-label', 'Sluit menu');
      hamburgerIcon.innerHTML = CROSS;
    }
    navHamburger.addEventListener('click', function () {
      mobileMenu.classList.contains('open') ? closeMenu() : openMenu();
    });
    mobileMenu.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', closeMenu);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') { closeMenu(); }
    });
    window.matchMedia('(min-width: 861px)').addEventListener('change', function (e) {
      if (e.matches) { closeMenu(); }
    });
  }
})();
