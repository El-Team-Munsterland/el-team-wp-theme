/**
 * Main Theme Script
 */

(function() {
	'use strict';

	// Menü-Knopf für schmale Bildschirme (template-parts/header/navigation.php)
	const initMobileMenu = () => {
		const nav = document.querySelector('.primary-navigation');
		const toggle = nav ? nav.querySelector('.menu-toggle') : null;
		if (!toggle) return;

		const setOpen = (open) => {
			nav.classList.toggle('is-open', open);
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		};

		toggle.hidden = false;
		nav.classList.add('has-menu-toggle');

		toggle.addEventListener('click', () => {
			setOpen(!nav.classList.contains('is-open'));
		});

		// Escape schließt das Menü und setzt den Fokus zurück auf den Knopf
		nav.addEventListener('keydown', (event) => {
			if (event.key === 'Escape' && nav.classList.contains('is-open')) {
				setOpen(false);
				toggle.focus();
			}
		});
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initMobileMenu);
	} else {
		initMobileMenu();
	}
})();
