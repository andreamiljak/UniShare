<?php
// Start or resume the session
session_start();


// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    echo '<script>alert("Korisnik nije logiran.");</script>';
    header("Location: login.html");
    exit();
}

// Establish database connection
$conn = new mysqli('localhost','root','','chatroom_poruke');



// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get message data from the form submission
$username = $_SESSION['korisnicko_ime']; // Use the username from the session
$message = $_POST['poruka'];

// Sanitize the data to prevent SQL injection
$username = $conn->real_escape_string($username);
$message = $conn->real_escape_string($message);

 //echo '<script>alert("Session ID: ' . $message . '");</script>';

// Insert data into the database
$sql = "INSERT INTO poruke (korisnicko_ime, poruka, vrijeme) VALUES ('$username', '$message', NOW())";
$conn->query($sql);

// Close the database connection
$conn->close();
echo file_get_contents("chatroom.html");
?>
