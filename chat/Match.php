<?php
session_start();
require '../database/db.php';

$ime = $_SESSION['ime'];
$email = $_SESSION['email'];

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

//Doznajemo id ulogiranog korisnika
$id_ulogirani = $mysqli->query("SELECT id FROM Korisnik
    WHERE email='$email'");
$row = $id_ulogirani->fetch_assoc();
$id = $row['id'];

$rezultat = $mysqli->query("SELECT id_drugog FROM spojeni
    WHERE id_prvog='$id'");

$message=[];
$message['spojen_sa']=[];

while($osobe = $rezultat->fetch_assoc() ){
    $id_drugog = $osobe['id_drugog'];
   // echo " ".$id_drugog." ";
    $id2 = $mysqli->query("SELECT email,ime,prezime FROM Korisnik
        WHERE id='$id_drugog'");
    $drugi = $id2->fetch_assoc();

    $message['spojen_sa'][]=array('email2' => $drugi['email'],'ime2' => $drugi['ime'],'prezime2' => $drugi['prezime'],'id2' => $id_drugog);
}

//Za obratni slucaj
$rezultat2 = $mysqli->query("SELECT id_prvog FROM spojeni
    WHERE id_drugog='$id'");

$message['zahtjevi']=[];

while($osobe = $rezultat2->fetch_assoc() ){
    $id_drugog = $osobe['id_prvog'];
   // echo " ".$id_drugog." ";
    $id2 = $mysqli->query("SELECT email,ime,prezime FROM Korisnik
        WHERE id='$id_drugog'");
    $drugi = $id2->fetch_assoc();

    $message['zahtjevi'][]=array('email2' => $drugi['email'],'ime2' => $drugi['ime'],'prezime2' => $drugi['prezime'],'id2' => $id_drugog);
}

    sendJSONandExit( $message );

?>
