document.addEventListener('DOMContentLoaded', function() {
    let indietro = document.getElementById('indietro');
    let avanti = document.getElementById('avanti');
    let mobaImg = document.getElementById('mobaImg');

    indietro.addEventListener('click', function() {
        if (mobaImg.src.includes('moba1')) {
            mobaImg.src = 'images/moba3.png';
        } else if (mobaImg.src.includes('moba2')) {
            mobaImg.src = 'images/moba1.png';
        } else if (mobaImg.src.includes('moba3')) {
            mobaImg.src = 'images/moba2.png';
        }
    });

    avanti.addEventListener('click', function() {
        if (mobaImg.src.includes('moba1')) {
            mobaImg.src = 'images/moba2.png';
        } else if (mobaImg.src.includes('moba2')) {
            mobaImg.src = 'images/moba3.png';
        } else if (mobaImg.src.includes('moba3')) {
            mobaImg.src = 'images/moba1.png';
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