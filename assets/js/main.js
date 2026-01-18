/**
 * Main Theme Script
 */

(function() {
	'use strict';

	// Mobile menu toggle
	const initMobileMenu = () => {
		const nav = document.querySelector('.primary-navigation');
		if (!nav) return;

		// Add your mobile menu logic here
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initMobileMenu);
	} else {
		initMobileMenu();
	}
})();
