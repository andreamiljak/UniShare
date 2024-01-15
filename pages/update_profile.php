<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Povezivanje na bazu podataka
    $servername = "localhost";
    $username = "korisnicko_ime";
    $password = "lozinka";
    $dbname = "ime_baze";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Postavljanje i dohvaćanje podataka iz POST zahtjeva
    $username = $_POST['username'];
    $email = $_POST['email'];

    
    $sql = "UPDATE profil SET email='$email' WHERE korisnicko_ime='$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Uspješno ažurirano!";

        // Ako postoji uploadana slika profila
        if (isset($_FILES["profile_image"])) {
            $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/'; // Postavite svoj direktorij za spremanje slika
            $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);

            move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file);

            /
            $updateImageSql = "UPDATE profil SET profilna_slika='$target_file' WHERE korisnicko_ime='$username'";
            $conn->query($updateImageSql);
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Zatvaranje veze
    $conn->close();
}
?>
