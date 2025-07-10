document.addEventListener('DOMContentLoaded', function() {
    let indietro = document.getElementById('indietro');
    let avanti = document.getElementById('avanti');
    let caseImg = document.getElementById('caseImg');

    indietro.addEventListener('click', function() {
        if (caseImg.src.includes('case1')) {
            caseImg.src = 'images/case3.png';
        } else if (caseImg.src.includes('case2')) {
            caseImg.src = 'images/case1.png';
        } else if (caseImg.src.includes('case3')) {
            caseImg.src = 'images/case2.png';
        }
    });

    avanti.addEventListener('click', function() {
        if (caseImg.src.includes('case1')) {
            caseImg.src = 'images/case2.png';
        } else if (caseImg.src.includes('case2')) {
            caseImg.src = 'images/case3.png';
        } else if (caseImg.src.includes('case3')) {
            caseImg.src = 'images/case1.png';
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