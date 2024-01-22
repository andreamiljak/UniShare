<?php


    //Nastavak sesije
    session_start();

    if (!isset($_SESSION['id'])) {
    echo '<script>alert("Korisnik nije logiran.");</script>';
    header("Location: login.html");
    //exit();
    }

    $id = $_SESSION['id'];

    $conn = new mysqli('localhost','root','','login-register');


    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //echo '<script>alert("Session ID: ' . $_SESSION['id'] . '");</script>';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 
  


  //minjanje korisnickog imena
  if (isset($_POST['novoKorIme']) && $_POST['novoKorIme']!="") {
      $novoKorIme = $_POST['novoKorIme'];
      //echo '<script>alert("Session ID: ' . $novoKorIme . '");</script>';
      $sql = "UPDATE korisnici SET korisnicko_ime = '$novoKorIme' WHERE id = '$id'";
      mysqli_query($conn, $sql);
      }
  }

  if (isset($_POST['noviEmail']) && $_POST['noviEmail']!="") {
      $noviEmail = $_POST['noviEmail'];
      //echo '<script>alert("Session ID: ' . $novoKorIme . '");</script>';
      $sql = "UPDATE korisnici SET email = '$noviEmail' WHERE id = '$id'";
      mysqli_query($conn, $sql);
     
      }
	
  
  $file = $_FILES['profile_image'];
  $fileName = $file['name'];

  if ($fileName != ''){
  //echo '<script>alert("Session ID: ' . $fileName . '");</script>'; 
  move_uploaded_file($file['tmp_name'], 'uploads/' . $fileName);
  // Update the user's profile picture in the database
  $sql = "UPDATE korisnici SET profilna='$fileName' WHERE id='$id'";
  mysqli_query($conn, $sql);
  $_SESSION['profilna']=$fileName;
  }
  
  if ($_POST['trenutnaLozinka']!="" || $_POST['novaLozinka']!="" || $_POST['ponovljenaNovaLozinka']!="") {

  if ($_POST['trenutnaLozinka']!="" && $_POST['novaLozinka']!="" && $_POST['ponovljenaNovaLozinka']!="") {
      $trenutnaLozinka = $_POST['trenutnaLozinka'];
      $novaLozinka = $_POST['novaLozinka'];
      $ponovljenaNovaLozinka = $_POST['ponovljenaNovaLozinka'];

      if ($trenutnaLozinka == $_SESSION['lozinka']){
          if($novaLozinka === $ponovljenaNovaLozinka){
            $sql = "UPDATE korisnici SET lozinka = '$novaLozinka' WHERE id = '$id'";
            mysqli_query($conn, $sql);
          }
          else {
              echo '<script>alert("Nova i ponovljena lozinka se ne podudaraju.");</script>';
          }
      }
      else{
          echo '<script>alert("Netočna lozinka");</script>';
          //echo file_get_contents("profil.html");
      }}
   else {
       echo '<script>alert("Fali podatak");</script>';
       //echo file_get_contents("profil.html");
   }
   }
   //header("profil.php");
   //echo file_get_contents("profil.php");
    
   header("Location: profil.php");
    exit; 


    // Zatvaranje veze
    $conn->close();


   
?>
