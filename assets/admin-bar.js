( () => {
	'use strict';

	const LABELS = {
		hidden: window.MAB_DATA?.hiddenText ?? 'Show admin bar',
		visible: window.MAB_DATA?.visibleText ?? 'Hide admin bar',
	};

	const saveState = async ( hidden ) => {
		if ( ! window.MAB_DATA ) return;

		const body = new URLSearchParams( {
			action: 'save_admin_bar_state',
			nonce: MAB_DATA.nonce,
			hidden: JSON.stringify( hidden ),
		} );

		try {
			await fetch( MAB_DATA.ajaxUrl, {
				method: 'POST',
				credentials: 'same-origin',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body,
			} );
		} catch {}
	};

	const init = () => {
		const btn = document.getElementById( 'cab-toggle' );
		if ( ! btn ) return;

		const html = document.documentElement;
		const srText = btn.querySelector( '.screen-reader-text' );

		let hidden = window.MAB_DATA?.state?.hidden ?? false;

		const render = () => {
			const label = LABELS[ hidden ? 'hidden' : 'visible' ];

			html.classList.toggle( 'cab-bar-hidden', hidden );
			if ( srText ) srText.textContent = label;
			btn.title = label;
		};

		btn.addEventListener( 'click', () => {
			hidden = ! hidden;
			render();
			saveState( hidden );
		} );
	};

	document.addEventListener( 'DOMContentLoaded', init );
} )();
