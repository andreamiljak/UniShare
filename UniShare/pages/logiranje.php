<?php

session_start();

$conn = new mysqli('localhost','root','','login-register');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    // Perform user authentication
    $query = "SELECT * FROM korisnici WHERE korisnicko_ime = ? AND lozinka = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $korisnicko_ime, $lozinka);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Authentication successful
        $_SESSION['korisnicko_ime'] = $korisnicko_ime;
        header("Location: naslovna.html"); // Redirect to a dashboard page
        exit();
    } else {
        // Authentication failed
        echo '<script>alert("Netocno korisnicko ime ili lozinka.");</script>';
		echo file_get_contents("login.html");
    }

    $stmt->close();
}

$conn->close();
?>
