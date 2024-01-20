<?php


    //Nastavak sesije
    session_start();
    // Povezivanje na bazu podataka

    if (!isset($_SESSION['id'])) {
    echo '<script>alert("Korisnik nije logiran.");</script>';
    header("Location: login.html");
    exit();
}

    $conn = new mysqli('localhost','root','','login-register');


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Postavljanje i dohvaćanje podataka iz POST zahtjeva
    $korisnicko_ime = $_POST ['korisnicko_ime'];
	$email = $_POST ['email'];


  if (isset($_POST['korisnicko_ime'])) {
 
    if (!empty($korisnicko_ime)) {
      if($korisnicko_ime != $_SESSION['korisnicko_ime']){
          $sql = "UPDATE korisnici SET korisnicko_ime='$korisnicko_ime' WHERE id=$_SESSION['id']";
          mysqli_query($conn, $sql);
      }
    }
  }

if (isset($_POST['email'])) {
  // Validate the user's email
  $email = trim($_POST['email']);
  if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Update the user's email in the database
    $sql = "UPDATE users SET email='$email' WHERE id=1";
    mysqli_query($conn, $sql);
  } else {
    echo "Invalid email address";
  }
}

if (isset($_POST['profile_picture'])) {
  // Upload the profile picture
  $file = $_FILES['profile_picture'];
  $fileName = uniqid() . '.' . $file['type'];
  move_uploaded_file($file['tmp_name'], 'uploads/' . $fileName);

  // Update the user's profile picture in the database
  $sql = "UPDATE users SET profile_picture='$fileName' WHERE id=1";
  mysqli_query($conn, $sql);
}


    // Zatvaranje veze
    $conn->close();
?>
