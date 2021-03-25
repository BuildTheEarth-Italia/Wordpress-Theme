jQuery(document).ready(($) => {
    lax.setup(); //avvio lax
    const nav = $(".mainNav"); //reference alla navbar
    const main = $(".content"); //reference a main

    const updateOnScroll = () => {
        //aggiorno lax
        lax.update(window.scrollY);

        //distanza navbar da fine viewport
        const navbarHeight = nav.get(0).getBoundingClientRect().bottom;

        //distanza tra main e fine viewport
        const mainOffset = main.get(0).getBoundingClientRect().top;

        //a che altezza devo mostrare sfondo navbar?
        const distance = mainOffset - navbarHeight;
        
        //aggiungo lo sfondo a navbar se necessario
        if(distance <= 50) {
            nav.addClass("custom-background");
        } else {
            nav.removeClass("custom-background");
        }
        
        //animo nuovamente
        window.requestAnimationFrame(updateOnScroll);
    }
    window.requestAnimationFrame(updateOnScroll);
});