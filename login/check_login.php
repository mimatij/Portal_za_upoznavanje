<?php
if(!isset($_SESSION)) { 
  session_start(); 
}
include_once( '../database/db.php');

//dohvacamo unešeni email i tražimo ga u bazi
//email je jedinstven!
$email = $mysqli->escape_string($_POST['email']);
$rezultat = $mysqli->query("SELECT * FROM Korisnik WHERE email='$email'");

//ako je dohvaćeno 0 redaka iz tablice u bazi -> nema korisnika
//inače: dohvaćen je jedan, treba vidjeti je li lozinka ispravna
if($rezultat->num_rows === 0)
{
  $_SESSION['message'] = "Nepostojeći korisnik.";
  header('location: errors.php');
}
else
{
  //dohvaćamo red koji sadrži uneseni email
  //u redu su svi podaci o korisniku koje smo dohvatili
  $korisnik = $rezultat->fetch_assoc();
  //provjera je li lozinka ispravna
  $password = $_POST['password'];
  $hash = $korisnik['lozinka'];
  if(password_verify($password, $hash))
  {
    //spremit u session
    //zasad ove podatke, ostale kasnije, po potrebi
    $_SESSION['email'] = $korisnik['email'];
    $_SESSION['ime'] = $korisnik['ime'];
    if($korisnik['ime'] === "NULL") $_SESSION['ime']='nepoznat';
    else $_SESSION['ime'] = $korisnik['ime'];

    //varijabla za Login
    $_SESSION['ulogiran'] = true;
    $_SESSION['registriran'] = false;
    header('location: profile.php');
  }
  else
  {
    $_SESSION['message'] = 'Pogrešna lozinka, pokušajte ponovno.';
    header('location: errors.php');
  }
}


 ?>
