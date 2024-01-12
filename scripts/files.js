
//za preview prozor
document.addEventListener('DOMContentLoaded', function () {
    var fileLink = document.getElementById('file-link');
    var closeBtn = document.getElementById('closeBtn');
    var previewFile = document.getElementById('previewFile');
    var clickCount = 0;

    // Otvori file na dvostruki klik u novi prozor
    fileLink.addEventListener('dblclick', function (event) {
        event.stopPropagation(); // Spriječi daljnje širenje događaja prema roditeljskim elementima
        window.open('../file/01_Uvod u programsko inženjerstvo_2021.pdf', '_blank');
    });

    // Otvori preview prozor na obični klik
    fileLink.addEventListener('click', function (event) {
        event.preventDefault();

        // Broji kliks
        clickCount++;

        // Postavlja tajmer za resetiranje brojača nakon 300 ms
        setTimeout(function () {
            if (clickCount === 1) {
                // Otvori preview prozor samo ako je bilo jedan klik
                previewFile.classList.add('open');
            }
            clickCount = 0; // Resetiraj brojač nakon 300 ms
        }, 300);
    });

    // Zatvori preview prozor
    closeBtn.addEventListener('click', function () {
        previewFile.classList.remove('open');
    });
});
