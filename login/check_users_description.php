<?php
if(!isset($_SESSION)) { 
  session_start(); 
}
include_once ('../database/db.php');
$email = $_SESSION['email'];


$sql = "SELECT id FROM Korisnik where email='$email'";
$id = $mysqli->query($sql)->fetch_object()->id;
//u ovoj datoteci spremamo podatke koji opisuju korisnikove interese
//tip odnosa, spol, hobiji, sport,...
if(isset($_POST['btn_opis_korisnika'])){
  $sql = "DELETE FROM nudim_interese WHERE id = $id";
  $isprazni = $mysqli->query($sql);
}

if(isset($_POST['btn_sto_korisnik_trazi'])){
  $sql = "DELETE FROM trazim_interese WHERE id = $id";
  $isprazni = $mysqli->query($sql);
}

function ubaci_u_bazu($cbox, $tablica, $mysqli, $id){
  if(isset($_POST["$cbox"])){
    $polje = $_POST["$cbox"];
    foreach($polje as $vrijednost){
      $sql = "INSERT INTO $tablica VALUES ($id, '$vrijednost')";
      $insert = $mysqli->query($sql);
    }
  }
}


ubaci_u_bazu('odnos', 'nudim_interese', $mysqli, $id);
ubaci_u_bazu('hobiji', 'nudim_interese', $mysqli, $id);
ubaci_u_bazu('odnos2', 'trazim_interese', $mysqli, $id);
ubaci_u_bazu('hobiji2', 'trazim_interese', $mysqli, $id);
ubaci_u_bazu('trazim_spol', 'trazim', $mysqli, $id);

if(isset($_POST['trazim_spol'])){
  $polje = $_POST['trazim_spol'];
  $x=0;
  foreach($polje as $vrijednost){
    if($x >0)
      $x = 3;
    if($vrijednost === 'M' && $x === 0)
      $x = 1;
    if($vrijednost === 'Z' && $x === 0)
      $x = 2;
    
  }

  $sql = "UPDATE Korisnik SET trazim = $x WHERE id = $id";
  $update = $mysqli->query($sql);
}
 ?>



