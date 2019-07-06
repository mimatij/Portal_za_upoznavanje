<?php
//session?
include_once( '../database/db.php');
$_SESSION['email'] = $_POST['email'];

//password_1 ili password_2 - svejedno je

//escape_string - zaštita od SQL injections
$email = $mysqli->escape_string($_POST['email']);

//password_hash je ne spremamo u bazu lozinku nego kriptiranu lozinku
$lozinka = $mysqli->escape_string(password_hash($_POST['password_1'], PASSWORD_BCRYPT));

//treba provjeriti postoji li taj korisnik već u bazi
$rezultat = $mysqli->query("SELECT email FROM Korisnik WHERE email='$email'") or die($mysqli->error());

//broj veći od 0 znači da korisnik postoji
if($rezultat->num_rows > 0)
{
  echo '0';
  $_SESSION['message'] = 'Korisnik s tim email-om već postoji.';
  header("location: errors.php");
}
else
{
  //spremanje u bazu
  //queri upit - samo zbog lakše čitljivosti koda
  $sql = "INSERT INTO Korisnik (email, lozinka) VALUES ('$email', '$lozinka')";

  //dodavanje novog korisnika u bazu
  if($mysqli->query($sql))
  {
    $_SESSION['registriran'] = true;
    $_SESSION['ulogiran'] = false;
    $_SESSION['email'] = $email;
    $_SESSION['message'] = 'Registracija uspjela.';
    header('location: interests.php');

  }
}

 ?>
