<?php
session_start();
require '../database/db.php';
$email = $_SESSION['email'];

//u ovoj datoteci spremamo podatke koji opisuju korisnikove interese
//tip odnosa, spol, hobiji, sport,...

if(isset($_POST['trazim_spol']))
{
  $spol = $_POST['trazim_spol'];
  $sql = "UPDATE Korisnik SET spol='". $spol ."' WHERE email='$email'";
  $insert = $mysqli->query($sql);
}

 ?>
