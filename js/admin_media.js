jQuery(document).ready(($) => {
    $('button.page-title-action.bte-upload').click((e) => {
            //blocco comportamento di default del browser
            e.preventDefault();

            //istanza del picker delle immagini
            let imagePicker;

            //se picker esiste già lo apro
            if(imagePicker)
                imagePicker.open();

           //altrimenti ne creo uno
           imagePicker = wp.media({
                         title: 'Scegli un\'immagine',
                         multiple : true,
                         library : {
                              type : 'image',
                          }
                     });

                    imagePicker.on('close', () => {
                        //ottengo le immagini selezionate
                        const selection =  imagePicker.state().get('selection');

                        //salvo le immagini in variabile globale
                        window.selectedImages = selection;

                        //carico le immagini
                        uploadImages(selection);
                    });

                    imagePicker.on('open', () => {
                        //ottengo le immagini selezionate
                        let selection =  imagePicker.state().get('selection');
                        
                        //ottengo le immmagini salvate
                        const selectedImages = window.selectedImages ? window.selectedImages : [];

                        //aggiungo le immagini alla selezione del picker
                        selectedImages.forEach((item) => {
                            selection.add([item]);
                        });

                    });

                    //apro il picker
                    imagePicker.open();
   });

    const uploadImages = (items) => {
        let data = {
            action: 'bte_add_image_via_ajax',
            images: []
        };

        //riempo il campo per le immagini
        items.forEach((item) => data.images.push(item.id));

        $.get(
            ajaxurl, 
            data, 
            () => window.location.reload()
        );
    }
});