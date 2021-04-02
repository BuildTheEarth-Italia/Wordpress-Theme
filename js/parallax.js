lax.setup(); // Inizializzo lax

const navbar = jQuery('.navbar');  // Reference alla navbar
const container = jQuery('.root'); // Reference al contenuto

currentMargin = parseInt(
    container.css('marginTop')   // Margine di default di container
);

const updateOnScroll = function () {
    // Assegnazione per compatibilità
    const scroll = jQuery(document).scrollTop();

    // Aggiorno lax
    lax.update(scroll);

    // Ottengo la distanza tra la fine della navbar è il top della viewport
    const distance = scroll - navbar.outerHeight(true);

    // Se distance è maggiore di 0 aggiungo classe fixed
    if (distance >= 0) {
        // Aggiungo la classe fixed-top alla navbar
        navbar.addClass('custom-background fixed');

        // Aggiungo margine al container
        container.css('marginTop', currentMargin + navbar.outerHeight(true));

        // Imposto la distanza da il margine di sopra se la navbar può ancora scendere
        if (distance <= navbar.outerHeight(true)) {
            navbar.css('top', distance - navbar.outerHeight(true));
        } else {
            navbar.css('top', 0);
        }
    } else {
        // Rimuovo la classe fixed-top alla navbar
        navbar.removeClass('csudtom-background fixed');

        // Rimuovo margine al container
        container.css('marginTop', currentMargin);

        // Imposto la distanza da il margine di sopra a 0
        navbar.css('marginTop', null);
    }
}

// Se la pagina viene ridimensionata aggiorno currentMargin
const updateOnResize = function () {
    container.css('marginTop', null); // Rimuovo il margine vecchio

    currentMargin = parseInt(
        container.css('marginTop') // Aggiorno il margine di default
    );

    // Aggiungo margine nuovo al container
    container.css('marginTop', currentMargin + navbar.outerHeight(true));
};


// Animo ad ogni scorrimento della pagina
window.addEventListener('scroll', () =>
    window.requestAnimationFrame(updateOnScroll)
);

// Aggiorno le dimensioni in caso di ridimensionamento
window.addEventListener('resize', updateOnResize);