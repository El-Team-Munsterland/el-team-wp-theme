/**
 * Design → Startseite: Kacheln hinzufügen, entfernen und verschieben (inc/front-page.php).
 * Ohne JavaScript bleibt unten immer eine leere Zeile für eine weitere Kachel.
 */

(function() {
	'use strict';

	const init = () => {
		const body = document.querySelector('.el-team-tiles tbody');
		const template = document.getElementById('el-team-tile-template');
		const addButton = document.querySelector('.el-team-tile-add');
		if (!body || !template || !addButton) return;

		let next = body.querySelectorAll('tr').length;

		// Leere Zeilen (ohne gewählte Seite) entfernen; mit JavaScript gibt es den Knopf zum Hinzufügen
		body.querySelectorAll('tr').forEach((row) => {
			const select = row.querySelector('select');
			if (select && select.value === '0' && body.querySelectorAll('tr').length > 1) {
				row.remove();
			}
		});

		const addRow = () => {
			const html = template.innerHTML.replace(/__INDEX__/g, String(next++));
			body.insertAdjacentHTML('beforeend', html);
			const select = body.lastElementChild.querySelector('select');
			if (select) select.focus();
		};

		addButton.hidden = false;
		addButton.addEventListener('click', addRow);

		body.addEventListener('click', (event) => {
			const button = event.target.closest('button');
			if (!button) return;
			const row = button.closest('tr');
			if (button.classList.contains('el-team-tile-remove')) {
				row.remove();
				if (!body.querySelector('tr')) addRow();
			} else if (button.classList.contains('el-team-tile-up') && row.previousElementSibling) {
				row.parentNode.insertBefore(row, row.previousElementSibling);
				button.focus();
			} else if (button.classList.contains('el-team-tile-down') && row.nextElementSibling) {
				row.parentNode.insertBefore(row.nextElementSibling, row);
				button.focus();
			}
		});
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
