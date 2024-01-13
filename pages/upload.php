<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uploadDir = 'uploads/'; //putanja gdje se spremaju dokumenti

    // Provjera postojanja direktorija za prijenos datoteka, ako ne postoji, stvorite ga
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedFile = $uploadDir . basename($_FILES['file']['name']);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($uploadedFile, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($uploadedFile)) {
        echo "Sorry, file already exists. ";
        $uploadOk = 0;
    }

    // Provjera veličine datoteke
    if ($_FILES['file']['size'] > 5000000) {
        echo 'File is too large.';
        $uploadOk = 0;
    }

    // Dopuštanje svih formata datoteka (izmjena prema potrebama)
    $allowedFormats = ['pdf', 'docx', 'txt', 'jpg', 'jpeg', 'png', 'gif']; //vamo dodat jos formata po potrebi
    if (!in_array($fileType, $allowedFormats)) {
        echo 'Only PDF, DOCX, TXT, JPG, JPEG, PNG, and GIF files are allowed.';
        $uploadOk = 0;
    }

    // Provjera je li $uploadOk postavljen na 0 zbog neke greške
    if ($uploadOk == 0) {
        echo 'File was not uploaded.';
    } else {
        // Sve je u redu, pohranite datoteku
        if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFile)) {
            // Pohrana informacija u bazu podataka
            $filename = basename($_FILES['file']['name']);
            $fileType = $fileType;
            $filepath = $uploadedFile;

            $conn = new mysqli('localhost', 'root', '', 'login-register');

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            $sql = "INSERT INTO uploaded_files (filename, filetype, ocjena, filepath) VALUES ('$filename', '$fileType', 0, '$filepath')";
            $conn->query($sql);

            $conn->close();

            // Prikaz uploadane datoteke na stranici (s ikonom i linkom)
            echo '<div>';
            echo '<a href="' . $uploadedFile . '" target="_blank"><img src="../img/pdficon.png" alt="File Icon"> <br>' . basename($_FILES['file']['name']); '</a>';
            echo '</div>';
        } else {
            echo 'Error uploading file: ' . $_FILES['file']['error'] . '<br>';
            echo 'Error in MySQL query: ' . $sql . '<br>' . $conn->error;
        }
    }
}
?>
