jQuery(document).ready(($) => {
	//time out corrente
	let currentTimeout;

	const setImage = (n) => {
		//fermo timeout corrente
		clearTimeout(currentTimeout);

		//reference alla galleria
		const gallery = $('.gallery');
		
		//numero foto corrente
		const c = gallery.data('gallery-current-photo');
		
		const current = $('.galleryItem').filter('[data-gallery-id=\'' + c + '\']');
		const next = $('.galleryItem').filter('[data-gallery-id="' + n + '"]');
		
		//imposto questa come foto corrente
		gallery.data('gallery-current-photo', n);
			
		//aggiungo animazioni
		current.css('animation', 'shadow 1s ease-out');
		
		//allo scadere dell'animazione avvio l'altra
		currentTimeout = setTimeout(() => {
			//nascondo corrente
			current.css({
				'display': 'none',
				'opacity': 0,
				'animation': 'none'
			});
			
			//mostro successivo
			next.css({
				'display': 'flex',
				'opacity': 1,
				'animation': 'shadow 0.7s ease-in reverse'
			});

			//fermo l'animazione
			setTimeout(() => 
				next.css('animation', 'none')
			, 700);
		}, 1000);
	}

	const autoGalleryInit = () => {
		//reference alla galleria
		const gallery = $('.gallery');
		
		//numero massimo di foto
		const max = gallery.data('gallery-max');

		//numero foto corrente
		let c = gallery.data('gallery-current-photo');
		
		return setInterval(() => {		
			//se il prossimo indice è maggiore del massimo sarà 0
			if(++c >= max)
				c = 0;

			//imposto la foto
			setImage(c);
		}, 10000);
	}

	//avvio la galleria
	autoGalleryInit();
});