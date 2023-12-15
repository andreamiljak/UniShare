<?php
	$korisnicko_ime = $_POST ['korisnicko_ime'];
	$lozinka = $_POST ['lozinka'];
	$email = $_POST ['email'];

	$conn = new mysqli('localhost','root','','login-register');
	if ($conn->connect_error){
		die('Connection failed : '.$conn->connection_error);
	}
	function isUsernameTaken($korisnicko_ime, $conn) {
		$query = "SELECT * FROM korisnici WHERE korisnicko_ime = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $korisnicko_ime);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}
	function isEmailTaken($email, $conn) {
		$query = "SELECT * FROM korisnici WHERE email = ?";
		$stmt = $conn->prepare($query);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result->num_rows > 0;
	}
	if (isUsernameTaken($korisnicko_ime, $conn)) {
		echo '<script>alert("Profil sa ovim korisnickim imenom vec postoji.");</script>';
		echo file_get_contents("register.html");

	} 
	elseif (isEmailTaken($email, $conn)) {
		echo '<script>alert("Profil sa ovim emailom vec postoji.");</script>';
		echo file_get_contents("register.html");
	} 
	else {
    // Insert new user into the database
		$insertQuery = "INSERT INTO korisnici (korisnicko_ime, email, lozinka) VALUES (?, ?, ?)";
		$insertStmt = $conn->prepare($insertQuery);
		$insertStmt->bind_param("sss", $korisnicko_ime, $email, $lozinka);
    
		if ($insertStmt->execute()) {

			echo "User registered successfully.";
			echo file_get_contents("materijalihub.html");
		} 
		else {
			echo "Error registering user: " . $insertStmt->error;
		}
	}

		$conn->close();

?>