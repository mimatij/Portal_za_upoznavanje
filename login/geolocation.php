<?php
session_start();
require '../database/db.php';

$email = $_SESSION['email'];

// Dohvaćanje geografske širine i dužine poslanih preko ajaxa
$sirina = $_GET[ "sirina" ];
$duzina = $_GET[ "duzina" ];

// Spremanje širine i dužine u bazu
$sql = "UPDATE Korisnik SET geo_sirina='". $sirina ."' WHERE email='$email'";
$insert = $mysqli->query($sql);
$sql = "UPDATE Korisnik SET geo_duzina='". $duzina ."' WHERE email='$email'";
$insert = $mysqli->query($sql);

header('location: interests.php');
?>