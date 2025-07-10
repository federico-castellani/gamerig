document.addEventListener('DOMContentLoaded', function() {
    let aggiungi = document.getElementById('aggiungi');
    let rimuovi = document.getElementById('rimuovi');
    let quantita = document.getElementById('quantita');
    let imgPrimaria = document.getElementById('imgPrimaria');
    let imgSecondarie = document.querySelectorAll('.imgSecondaria');

    aggiungi.addEventListener('click', function() {
        quantita.value = parseInt(quantita.value) + 1;
    });
    rimuovi.addEventListener('click', function() {
        if (quantita.value > 1) {
            quantita.value = parseInt(quantita.value) - 1;
        }
    });
    
    imgSecondarie.forEach(function(img) {
        img.addEventListener('click', function() {
            imgSecondarie.forEach(img => img.classList.remove('imgSelezionata'));

            this.classList.add('imgSelezionata');
            imgPrimaria.src = img.src;
            
        });
    });

    document.getElementById('bottoneCarrello').addEventListener('click', function() {
        document.getElementById('aggiungiCarrello').submit();
    });
});