document.addEventListener('DOMContentLoaded', function() {
    let indietro = document.getElementById('indietro');
    let avanti = document.getElementById('avanti');
    let gpuImg = document.getElementById('gpuImg');

    indietro.addEventListener('click', function() {
        if (gpuImg.src.includes('gpu1')) {
            gpuImg.src = 'images/gpu3.png';
        } else if (gpuImg.src.includes('gpu2')) {
            gpuImg.src = 'images/gpu1.png';
        } else if (gpuImg.src.includes('gpu3')) {
            gpuImg.src = 'images/gpu2.png';
        }
    });

    avanti.addEventListener('click', function() {
        if (gpuImg.src.includes('gpu1')) {
            gpuImg.src = 'images/gpu2.png';
        } else if (gpuImg.src.includes('gpu2')) {
            gpuImg.src = 'images/gpu3.png';
        } else if (gpuImg.src.includes('gpu3')) {
            gpuImg.src = 'images/gpu1.png';
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