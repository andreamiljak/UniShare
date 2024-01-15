<?php
// Establish database connection
session_start();
$korisnicko_ime = $_SESSION['korisnicko_ime'];

$conn = new mysqli('localhost','root','','chatroom_poruke');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the database
$sql = "SELECT korisnicko_ime, poruka, vrijeme FROM poruke";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');

echo json_encode([
    'korisnicko_ime' => $korisnicko_ime,
    'data' => $data
]);

?>
