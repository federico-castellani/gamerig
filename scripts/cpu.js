document.addEventListener('DOMContentLoaded', function() {
    let indietro = document.getElementById('indietro');
    let avanti = document.getElementById('avanti');
    let cpuImg = document.getElementById('cpuImg');

    indietro.addEventListener('click', function() {
        if (cpuImg.src.includes('cpu1')) {
            cpuImg.src = 'images/cpu3.png';
        } else if (cpuImg.src.includes('cpu2')) {
            cpuImg.src = 'images/cpu1.png';
        } else if (cpuImg.src.includes('cpu3')) {
            cpuImg.src = 'images/cpu2.png';
        }
    });

    avanti.addEventListener('click', function() {
        if (cpuImg.src.includes('cpu1')) {
            cpuImg.src = 'images/cpu2.png';
        } else if (cpuImg.src.includes('cpu2')) {
            cpuImg.src = 'images/cpu3.png';
        } else if (cpuImg.src.includes('cpu3')) {
            cpuImg.src = 'images/cpu1.png';
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