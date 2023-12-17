<?php


session_start();

$conn = new mysqli('localhost','root','','login-register');

if (isset($_SESSION['id'])) {
    
    $id = $_SESSION['id'];
    //echo '<script>alert("Session ID: ' . $_SESSION['id'] . '");</script>';

    $sql = "DELETE FROM korisnici WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Korisnicki racun izbrisan.");</script>';
        echo file_get_contents("login.html");
    } else {
        echo "Error deleting user profile: " . $conn->error;
    }

} 
else {
    // Redirect to the login page if the user is not logged in
    echo '<script>alert("Korisnik nije logiran.");</script>';
    header("Location: help.html");
    exit();
}

// Close connection
$conn->close();
?>
