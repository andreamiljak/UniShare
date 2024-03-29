<?php
// Start the session
session_start();

//echo '<script>alert("Session ID: ' . $_SESSION['profilna'] . '");</script>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moj profil</title>
    <link rel="icon" type="image/x-icon" href="../img/logoo.png">
    <link rel="stylesheet" href="../styles/profil.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles/materijalihub.css" />
</head>

<body>
    <header>
        <img class="logo" src="../img/logoteksttamnapoz.png" alt="logo">
        <nav>
            <ul class="nav_links">
                <li><a href="materijalihub.html">MaterijaliHub</a></li>
                <li><a href="chatroom.html">ChatRoom</a></li>
                <li><a href="help.html">Pomoć</a></li>
                <li><a href="profil.php">Profil</a></li>
            </ul>
        </nav>
        <a class="odjava" href="logout.php"><button>Odjava</button></a>
    </header>

    <div class="container light-style flex-grow-1 container-p-y">
        <form id="profileForm" method="post" action="update_profile.php" enctype="multipart/form-data">
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                               href="#account-general">Moji podaci</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list"
                               href="#account-change-password">Promijeni lozinku</a>
                            <br>
                            <!--iz nekog razloga kad stavin botun unutar ovog 'a' ispod taj botun vodi na update_profil.php umisto brisanje_profila.php-->
                            <a class="izbrisi_profil" href="brisanje_profila.php">Izbriši profil</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body media align-items-center">
                                    <img src="uploads/<?php echo $_SESSION['profilna']; ?>" id="profile-preview"
                                         class="d-block ui-w-80">
                                    <div class="media-body ml-4">
                                        <label class="btn btn-outline-primary">
                                            Promijeni sliku
                                            <input accept="image/*" type="file" name="profile_image" id="profile_image"
                                                   class="account-settings-fileinput" onchange="previewImage()">
                                        </label> &nbsp;

                                        <button type="submit" class="btn btn-default md-btn-flat">Spremi</button>
                                    </div>
                                </div>
                                <hr class="border-light m-0">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="form-label">Korisničko ime</label>
                                        <input type="text" class="form-control mb-1" name="novoKorIme" id="novoKorIme" placeholder="Novo korisničko ime">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" class="form-control mb-1" id="noviEmail" name="noviEmail" placeholder="Novi email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Fakultet</label>
                                        <select class="form-control" name="faculty" id="faculty" onchange="loadMajors()">
                                            <option value="" disabled selected>Odaberi fakultet</option>
                                            <option value="fakultet1">Fakultet elektrotehnike, strojarstva i brodogradnje Split</option>
                                            <option value="fakultet2">Prirodoslovno-matematički fakultet Split</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Smjer</label>
                                        <select class="form-control" name="major" id="major">
                                            <option value="" disabled selected>Odaberi smjer</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <div class="form-group">
                                        <label class="form-label">Trenutna lozinka</label>
                                        <input type="password" id="trenutnaLozinka" name="trenutnaLozinka" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Nova lozinka</label>
                                        <input type="password" id="novaLozinka" name="novaLozinka" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Ponovno upišite novu lozinku</label>
                                        <input type="password" id="ponovljenaNovaLozinka" name="ponovljenaNovaLozinka" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary">Spremi promjene</button>
                    <button type="button" class="odustani_botun">Odustani</button>
                </div>
            </div>
        </form>

        <!--<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>-->
        <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
        <script type="text/javascript">
            function previewImage() {
                const input = document.getElementById('profile_image');
                const preview = document.getElementById('profile-preview');

                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.width = '80px';
                        preview.style.height = '80px';
                        preview.style.borderRadius = '50%';
                    };

                    reader.readAsDataURL(file);
                }
            }



            function loadMajors() {
                const facultySelect = document.getElementById('faculty');
                const majorSelect = document.getElementById('major');

                majorSelect.innerHTML = "";

                if (facultySelect.value === 'fakultet1') {
                    const options = ['Elektrotehnika', 'Računarstvo', 'Strojarstvo'];
                    options.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.toLowerCase();
                        optionElement.textContent = option;
                        majorSelect.appendChild(optionElement);
                    });
                } else if (facultySelect.value === 'fakultet2') {
                    const options = ['Matematika', 'Informatika', 'Fizika'];
                    options.forEach(option => {
                        const optionElement = document.createElement('option');
                        optionElement.value = option.toLowerCase();
                        optionElement.textContent = option;
                        majorSelect.appendChild(optionElement);
                    });
                }
            }
        </script>
    </div>
      <footer id="page-footer">UniShare</footer>
</body>

</html>
