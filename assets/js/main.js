/**
 * Fit by Floran — Main JavaScript
 * Theme toggle, hamburger menu, scroll reveal animations
 */

document.addEventListener('DOMContentLoaded', function() {
	initThemeToggle();
	initHamburgerMenu();
	initScrollReveal();
});

/**
 * Theme Toggle: Dark/Light mode
 */
function initThemeToggle() {
	const toggleBtns = document.querySelectorAll('.theme-toggle');
	const htmlEl = document.documentElement;
	const storageKey = 'fbf-theme';

	// Load saved theme preference
	const savedTheme = localStorage.getItem(storageKey);
	if (savedTheme === 'light') {
		htmlEl.setAttribute('data-theme', 'light');
	}

	toggleBtns.forEach(btn => {
		btn.addEventListener('click', function() {
			const currentTheme = htmlEl.getAttribute('data-theme');
			const newTheme = currentTheme === 'light' ? 'dark' : 'light';

			htmlEl.setAttribute('data-theme', newTheme);
			localStorage.setItem(storageKey, newTheme);
		});
	});
}

/**
 * Hamburger Menu Toggle
 */
function initHamburgerMenu() {
	const hamburgerBtn = document.querySelector('.nav-hamburger');
	const mobileMenu = document.querySelector('.mobile-menu');

	if (!hamburgerBtn || !mobileMenu) return;

	hamburgerBtn.addEventListener('click', function() {
		mobileMenu.classList.toggle('open');
	});

	// Close menu when a link is clicked
	const mobileMenuLinks = mobileMenu.querySelectorAll('a');
	mobileMenuLinks.forEach(link => {
		link.addEventListener('click', function() {
			mobileMenu.classList.remove('open');
		});
	});

	// Close menu when clicking outside
	document.addEventListener('click', function(e) {
		if (!e.target.closest('.nav-hamburger') && !e.target.closest('.mobile-menu')) {
			mobileMenu.classList.remove('open');
		}
	});
}

/**
 * Scroll Reveal: fade-in animations for sections
 */
function initScrollReveal() {
	const revealElements = document.querySelectorAll('.reveal');

	if (!revealElements.length) return;

	// Use Intersection Observer for better performance
	const observerOptions = {
		threshold: 0.1,
		rootMargin: '0px 0px -50px 0px'
	};

	const observer = new IntersectionObserver(function(entries) {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				entry.target.classList.add('in');
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	revealElements.forEach(el => observer.observe(el));
}