function displayUploadedFiles() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);

            console.log('Odgovor s poslužitelja:', response); //

            var container = document.getElementById("uploadedFileContainer");
            // Očisti trenutni prikaz
            container.innerHTML = '';

            // Prikaz ikona na stranici
            response.forEach(function (file) {
                var iconContainer = document.createElement("div");
                iconContainer.className = "file-item";

                var link = document.createElement("a");
                link.href = file.filepath || "#";  // Postavi href na filepath, ili na "#" ako filepath nije dostupan
                link.target = "_blank";
                link.title = "Dvostruki klik za otvaranje linka";

                var icon = document.createElement("div");
                // Dodaj uvjetni prikaz ikona ovisno o vrsti datoteke
                var fileTypeIcon = '';
                if (file.filepath) {
                    var fileType = file.filepath.split('.').pop().toLowerCase();
                    if (fileType === 'pdf') {
                        fileTypeIcon = '<img src="../img/pdficon.png" alt="File Icon">';
                    } else if (fileType === 'docx') {
                        fileTypeIcon = '<img src="../img/docxicon.png" alt="File Icon">';
                    } else if (fileType === 'txt') {
                        fileTypeIcon = '<img src="../img/txticon.png" alt="File Icon">';
                    } else if (fileType === 'jpg' || fileType === 'jpeg' || fileType === 'png' || fileType === 'gif') {
                        fileTypeIcon = '<img src="../img/imageicon.png" alt="File Icon">';
                    } else {
                        fileTypeIcon = '<img src="../img/defaulticon.png" alt="File Icon">';
                    }
                }

                // Ograniči duljinu imena datoteke i dodaj "..." ako je predugo
                var fileName = file.filename.length > 10 ? file.filename.substring(0, 10) + '...' : file.filename;

                icon.innerHTML = fileTypeIcon + '<br><span title="' + file.filename + '">' + fileName + '</span>';
                //icon.innerHTML = fileTypeIcon + '<br><span>' + file.filename + '</span>';
                
                // Dodaj klik za otvaranje preview prozora ili linka
                iconContainer.appendChild(link);
                link.appendChild(icon);

                container.appendChild(iconContainer);

                // Dodaj event listener za dvostruki klik
                var clickCount = 0;
                icon.addEventListener('click', function (event) {
                    event.preventDefault();

                    clickCount++;

                    // Otvori preview prozor samo na jednom kliku
                    if (clickCount === 1) {
                        setTimeout(function () {
                            if (clickCount === 1) {
                                // Prikazi podatke o datoteci u preview prozoru
                                var uploadedAt = new Date(file.uploaded_at); 
                                var formattedDate = uploadedAt.toLocaleDateString();

                                document.getElementById('previewFile').innerHTML = `
                                    <button id="closeBtn">Zatvori</button>
                                    <div class="file-info-container">
                                    <h3 class="file-title">${file.filename}</h3>
                                    <div class="file-rating">
                                        <p class="upload-date">${formattedDate}</p>
                                            <p>Prosječna ocjena:<span id="averageRating">0</span></p>
                                            Ocijeni:
                                            <div class="star-container" id="ratingStars">
                                                <i class="fa fa-star-o star-icon" data-rating="1"></i>
                                                <i class="fa fa-star-o star-icon" data-rating="2"></i>
                                                <i class="fa fa-star-o star-icon" data-rating="3"></i>
                                                <i class="fa fa-star-o star-icon" data-rating="4"></i>
                                                <i class="fa fa-star-o star-icon" data-rating="5"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="comments-container">
                                        <div class = "comments-naslov">
                                            <h1>Komentari</h1>
                                        </div>
                                        <div> Broj komentara: <span id="comment">0</span></div>
                                        <div class="comments"></div>
                                        <div class="commentbox">
                                            <div class="content">
                                                <h2 class="komentiraj">Komentiraj kao: </h2>
                                                <input type="text" value="Anonymous" class="user">

                                                <div class="commentinput">
                                                    <input type="text" placeholder="Unesi komentar" class="usercomment">
                                                    <div class="buttons">
                                                        <button type="submit" disabled id="publish">Objavi</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                const starIcons = document.querySelectorAll('.star-icon');
starIcons.forEach(starIcon => {
    starIcon.addEventListener('click', () => {
        const rating = parseInt(starIcon.getAttribute('data-rating'), 10);

        // Update the UI to reflect the selected rating
        updateStarRatingUI(rating);

        // You can also send the rating to your server for storage or further processing
        // For now, let's assume you have a function called saveRatingToServer
        saveRatingToServer(rating);
    });
});


// Function to update the star rating UI
function updateStarRatingUI(rating) {
    starIcons.forEach(starIcon => {
        const starRating = parseInt(starIcon.getAttribute('data-rating'), 10);
        if (starRating <= rating) {
            starIcon.classList.remove('fa-star-o');
            starIcon.classList.add('fa-star');
        } else {
            starIcon.classList.remove('fa-star');
            starIcon.classList.add('fa-star-o');
        }
    });

    // Update the average rating in your UI
    const averageRatingElement = document.getElementById('averageRating');
    averageRatingElement.textContent = rating;
}

// Function to save the rating to the server (replace this with your actual server logic)
function saveRatingToServer(rating) {
    // Your logic to save the rating to the server goes here
    console.log('Rating saved to server:', rating);
}


                                previewFile.classList.add('open');

                                // Dodaj event listener za gumb "Zatvori" nakon što je prozor otvoren
                                var closeBtn = document.getElementById('closeBtn');
                                closeBtn.addEventListener('click', function () {
                                    previewFile.classList.remove('open');
                                    // Dodajte logiku za brisanje ili resetiranje preview prozora po potrebi
                                });
                            }
                            clickCount = 0;
                        }, 250);
                    } else if (clickCount === 2 && file.filepath) {
                        // Otvori link samo na dvostrukom kliku i ako filepath nije prazan
                        window.open(file.filepath, '_blank');
                        clickCount = 0;
                    }
                });
            });
        }
    };

    xhr.open('GET', 'get_uploaded_files.php', true);
    xhr.send();
}

// Poziv funkcije pri ponovnom učitavanju stranice
window.onload = displayUploadedFiles;