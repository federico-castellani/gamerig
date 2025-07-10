window.addEventListener('scroll', function() {
    let top = document.getElementById('titoloTop');
    let bottom = document.getElementById('titoloBottom');
    let position = bottom.getBoundingClientRect().top;
    let cerca = document.getElementById('cerca');
    if(position < 60) {
        top.classList.add('titoloTopVisibile');
        top.classList.remove('titoloTopInvisibile');

        cerca.classList.add('ricercaBarraCorta');
        cerca.classList.remove('ricercaBarraLunga');
    } else {
        top.classList.add('titoloTopInvisibile');
        top.classList.remove('titoloTopVisibile');
        
        cerca.classList.add('ricercaBarraLunga');
        cerca.classList.remove('ricercaBarraCorta');
    }
});