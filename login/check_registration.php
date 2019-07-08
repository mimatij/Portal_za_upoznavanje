<?php

if(!isset($_SESSION)) { 
  session_start(); 
}
require '../database/db.php';

//escape_string - zaštita od SQL injections
$email = $mysqli->escape_string($_POST['email']);
$_SESSION['email'] = $email;

//ako email nije ispravan na errors.php, inače ELSE -> ako ne stavim ostatk u else, ne radi kako treba
if( !empty($email) && (filter_var( $email, FILTER_VALIDATE_EMAIL ) === false))
{
    //$_SESSION['ETO'] = "tu sammmmmm";
    //var $poruka = "$email nije ispravna email adresa.";
    $_SESSION['message'] = "Pogrešan unos email-a.";
    header("location: errors.php");
}
else
{
  //treba provjeriti postoji li taj korisnik već u bazi
  $rezultat = $mysqli->query("SELECT email FROM Korisnik WHERE email='$email'") or die($mysqli->error());

  //broj veći od 0 znači da korisnik postoji
  if($rezultat->num_rows > 0)
  {
    $_SESSION['message'] = 'Korisnik s tim email-om već postoji.';
    header("location: errors.php");
  }
  else
  {
    $lozinka = $_POST['password_1'];
    if(!preg_match('/^[0-9a-zA-Z_]{6,20}$/', $lozinka))
    {
      $_SESSION['message'] = 'Lozinka nije okej: dozvoljena su velika, mala slova, brojevi i underscore. <br> Minimalno 6 znakova.';
      header("location: errors.php");
    }
    else
    {
      //password_hash je da ne spremamo u bazu lozinku nego kriptiranu lozinku
      $lozinka = $mysqli->escape_string(password_hash($_POST['password_1'], PASSWORD_BCRYPT));

      //queri upit - samo zbog lakše čitljivosti koda
      $sql = "INSERT INTO Korisnik (email, lozinka) VALUES ('$email', '$lozinka')";
      //dodavanje novog korisnika u bazu
      if($mysqli->query($sql))
      {
        $_SESSION['registriran'] = true;
        $_SESSION['email'] = $email;
        $_SESSION['message'] = 'Registracija uspjela.';
        header('location: interests.php');
      }
    }//kraj else spremanje u bazu
  }//kraj else email je okej i ne postoji u bazi

}//kraj else email je okej

 ?>