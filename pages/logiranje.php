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
        
        $korisnicko_ime = $_POST['korisnicko_ime'];

    // SQL query to fetch user_id based on username
        $sql = "SELECT id FROM korisnici WHERE korisnicko_ime = '$korisnicko_ime'";
    
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        // Fetch the user_id from the result set
            $row = $result->fetch_assoc();
            $id = $row['id'];
            $_SESSION['id'] = $id;
            $_SESSION['lozinka'] = $lozinka;
        }
        //echo '<script>alert("Session ID: ' . $_SESSION['id'] . '");</script>';
        echo file_get_contents("materijalihub.html");

        //header("Location: materijalihub.html"); // Redirect to a dashboard page
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
