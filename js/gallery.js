const slider = document.querySelector('.gallery .slider'); // Reference alla galleria
const children = slider.children; // Ottengo gli elementi figli

const onGalleryMouseMove = function(evt) {
    if(evt.buttons != 1)
		return; // Se pulsante non schiacciato esco

	const oldSpaceLeft = parseFloat(window.getComputedStyle(slider).marginLeft) || 0; // Margine precedente
	let newSpaceLeft = oldSpaceLeft + evt.movementX; // Sposto la galleria
	const spaceRight = parseFloat(window.innerWidth - slider.lastElementChild.getBoundingClientRect().right) || 0; // Spazio a destra

	// Sposto la galleria
	onMovementOverGallery(newSpaceLeft, spaceRight);
}

var galleryLastTouchX = 0;
const onTouchStart = function(evt) {
	const touch = evt.changedTouches[0]; // Tocco del dito 0

	galleryLastTouchX = touch.clientX; //Salvo la nuova X
}

const onGalleryTouchMove = function(evt) {
	evt.preventDefault();

	const touch = evt.changedTouches[0]; // Tocco del dito 0

	const oldSpaceLeft = parseFloat(window.getComputedStyle(slider).marginLeft) || 0; // Margine precedente
	let newSpaceLeft = oldSpaceLeft + touch.clientX - galleryLastTouchX; // Sposto la galleria
	const spaceRight = parseFloat(window.innerWidth - slider.lastElementChild.getBoundingClientRect().right) || 0; // Spazio a destra

	onMovementOverGallery(newSpaceLeft * 1.001, spaceRight); // Sposto la galleria

	galleryLastTouchX = touch.clientX; //Salvo la nuova X
}

const onMovementOverGallery = function(newSpaceLeft, spaceRight) {
    slider.classList.remove('animateMargin'); // Rimuovo animazione automatica

	//TODO: Animare fine dello scroll
	if(newSpaceLeft >= 30) {
		newSpaceLeft = 30; // Riduco il margine

	} else if(spaceRight >= 30) {
		newSpaceLeft += spaceRight - 30; // Riduco il margine
	}
	
	slider.style.marginLeft = newSpaceLeft + 'px'; // Applico il margine
}

for(let i = 0; i < children.length; i++) {
	children[i].addEventListener('dragstart', (evt) => {
		evt.preventDefault();
		return false;
	});
	children[i].draggable = false;
}

// Aggiungo event listeners per la galleria
slider.addEventListener('mousemove', onGalleryMouseMove, supportsPassiveAttribute ? { passive: true } : false);				// Aggiungo event handler per il movimento con il mouse
slider.addEventListener('touchstart',onTouchStart, supportsPassiveAttribute ? { passive: true } : false);					// Aggiungo event handler per l'inizio del touch
slider.addEventListener('touchmove', onGalleryTouchMove, supportsPassiveAttribute ? { passive: true } : false); 			// Aggiungo event handler per il touch
