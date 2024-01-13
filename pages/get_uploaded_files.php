<?php
$conn = new mysqli('localhost', 'root', '', 'login-register');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

$sql = "SELECT filename, filepath FROM uploaded_files";
$result = $conn->query($sql);

$uploadedFiles = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $uploadedFiles[] = $row;
    }
}

$conn->close();

echo json_encode($uploadedFiles);
?>