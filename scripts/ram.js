document.addEventListener('DOMContentLoaded', function() {
    let indietro = document.getElementById('indietro');
    let avanti = document.getElementById('avanti');
    let ramImg = document.getElementById('ramImg');

    indietro.addEventListener('click', function() {
        if (ramImg.src.includes('ram1')) {
            ramImg.src = 'images/ram3.png';
        } else if (ramImg.src.includes('ram2')) {
            ramImg.src = 'images/ram1.png';
        } else if (ramImg.src.includes('ram3')) {
            ramImg.src = 'images/ram2.png';
        }
    });

    avanti.addEventListener('click', function() {
        if (ramImg.src.includes('ram1')) {
            ramImg.src = 'images/ram2.png';
        } else if (ramImg.src.includes('ram2')) {
            ramImg.src = 'images/ram3.png';
        } else if (ramImg.src.includes('ram3')) {
            ramImg.src = 'images/ram1.png';
        }
    });

    const hamburger = document.getElementById('hamburger');
    const nav = document.querySelector('nav');
    const iconaHamburger = document.getElementById('icona-hamburger');

    hamburger.addEventListener('click', function() {
        if (nav.style.display === 'block') {
            nav.style.display = 'none';
            iconaHamburger.innerHTML = 'menu';
            avanti.style.top = '50%';
            indietro.style.top = '50%';
        } else {
            nav.style.display = 'block';
            iconaHamburger.innerHTML = 'close';
            avanti.style.top = '78%';
            indietro.style.top = '78%';
        }
    });
});