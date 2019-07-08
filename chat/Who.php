<?php
session_start();
require '../database/db.php';

$ime1 = $_SESSION['ime'];
$email1 = $_SESSION['email'];
$id2 = $_SESSION['partner'];



function sendJSONandExit( $message )
{
    // Kao izlaz skripte pošalji $message u JSON formatu i prekini izvođenje.
    header( 'Content-type:application/json;charset=utf-8' );
    echo json_encode( $message );
    flush();
    exit( 0 );
}


function sendErrorAndExit( $messageText )
{
	$message = [];
	$message[ 'error' ] = $messageText;
	sendJSONandExit( $message );
}

$rezultat = $mysqli->query("SELECT ime, prezime, email FROM Korisnik WHERE id='$id2'");
$korisnik = $rezultat->fetch_assoc();

$ime2 = $korisnik['ime'];
$prezime2 = $korisnik['prezime'];
$email2 = $korisnik['email'];

$message= [];
$message['ime1']=$ime1;
$message['email1']=$email1;
$message['ime2']=$ime2;
$message['email2']=$email2;
//$message['prezime2']=$prezime2;

sendJSONandExit( $message );


?>