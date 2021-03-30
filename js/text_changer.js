const text = document.querySelector('.dynamicText');  // Reference al box .dynamicText

const nextSentence = function() {
    // Se non è visibile salto l'animazione a 10 secondi
    if(text.parentElement.style.opacity == 0) {
        setTimeout(
            nextSentence,
            10000
        );

        return;
    }

    const currentIndex = Math.floor(Math.random() * (sentences.length - 1))
    const sentence = sentences[currentIndex]; // Ottengo la frase corrente

    // Funzione per cancellare un carattere dalla frase attiva
    const deleteChar = function() {
        const newText = text.innerText.substr(0, text.innerText.length - 1);

        // Cancello ma mano il testo con intervallo se c'è ancora testo
        if(newText.length > 0) {
            setTimeout(
                deleteChar,
                2 * newText.length
            );
        } else {
            setTimeout(
                addChar,
                500
            );
        }

        // Cancello effettivamente
        text.innerText = newText;
    }
    setTimeout(
        deleteChar,
        2000
    );

    // Funzione per scrivere
    let newTextIndex = 0;
    const addChar = function() {
        const newText = sentence.substr(0, newTextIndex++);

        // Aggiungo ma mano il testo con intervallo se c'è ancora testo
        // Se il carattere aggiunto è uno spazio o un altro segno di punteggiatura allora aspetto un po' di più
        const char = newText.substr(newText.length);

        if(newText.length < sentence.length) {
            if(char != ' ' || char != ',' || char != '\'') {
                setTimeout(
                    addChar,
                    1.01 * newText.length
                );
            } else {
                setTimeout(
                    addChar,
                    80
                );
            }
        } else {
            setTimeout(
                nextSentence,
                5000
            );
        }

        // Aggiungo effettivamente
        text.innerText = newText;
    }
}
nextSentence();
