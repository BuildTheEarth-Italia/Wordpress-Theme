const loadOnlineUsers = async function(url) {
    // Prendo la lista di player online
    const response = await fetch(url + '/online', {
        'method': 'GET',
        'mode': 'cors'
    }).then(result => result.json());

            // Creo elemento per online
            const circle = document.createElement('div');
            circle.classList.add('online-circle')

    // Itero tutti i giocatori online
    response.online.forEach(player => {
        // Ottengo il popup contenente il player
        const bubble = document.querySelector("tr[data-username='" + player.name + "']")?.querySelector(".bubble") ?? null;

        if(bubble !== null)
            bubble.insertBefore(circle, bubble.querySelector('.name'));
    });
}
