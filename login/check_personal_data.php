<?php
if(!isset($_SESSION)) { 
  session_start(); 
}
include_once('../database/db.php');

$email = $_SESSION['email'];

//za svaki podatak posebna provjera
//za svaki podatak poseban unos u bazu
if(isset($_POST['ime']) && $_POST['ime'] !== "")
{
  $ime = $_POST['ime'];
  $sql = "UPDATE Korisnik SET ime='". $ime ."' WHERE email='$email'";
  $insert = $mysqli->query($sql);
}

if(isset($_POST['prezime']) && $_POST['prezime'] !== "")
{
  $prezime = $_POST['prezime'];
  $sql = "UPDATE Korisnik SET prezime='". $prezime ."' WHERE email='$email'";
  $insert = $mysqli->query($sql);
}

if(isset($_POST['spol']) && $_POST['spol'] !== "")
{
  $spol = $_POST['spol'];
  $_SESSION['spol'] = $spol;
  $sql = "UPDATE Korisnik SET spol='". $spol ."' WHERE email='$email'";
  $insert = $mysqli->query($sql);
}

if(isset($_POST['grad']) && $_POST['grad'] !== "")
{
  $grad = $_POST['grad'];
  $sql = "UPDATE Korisnik SET grad='". $grad ."' WHERE email='$email'";
  $insert = $mysqli->query($sql);
}

header('location: profile.php');
 ?>
