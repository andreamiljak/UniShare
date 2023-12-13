<?php
	$korisnicko_ime = $_POST ['korisnicko_ime'];
	$lozinka = $_POST ['lozinka'];
	$email = $_POST ['email'];

	$conn = new mysqli('localhost','root','','login-register');
	if ($conn->connect_error){
		die('Connection failed : '.$conn->connection_error);
	}
	else {
		$stmt = $conn->prepare("insert into korisnici(korisnicko_ime, lozinka, email) values (?, ?, ?)");
		$stmt->bind_param("sss", $korisnicko_ime, $lozinka, $email);
		$stmt->execute();
		echo "Registracija uspijesna";
		$stmt->close();
		$conn->close();
	}

?>