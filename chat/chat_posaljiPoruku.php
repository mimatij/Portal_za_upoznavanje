<?php
session_start();
require '../database/db.php';

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

$poruka = isset( $_GET['poruka'] ) ? urldecode($_GET['poruka']) : '';
//echo "".$poruka;

if( $poruka != '' )
{
    //queri upit - samo zbog lakše čitljivosti koda
    //trebam dobit ovo to_email...tj kome saljem
    $from_email=$_GET['from_email'];
    $to_email=$_GET['to_email'];
    $sql = "INSERT INTO Chat (to_email,from_email,msg) VALUES ('$to_email','$from_email','$poruka')";

    if($mysqli->query($sql)){
    // Iako klijent zapravo ne treba odgovor kada šalje novu poruku,
    // možemo mu svedjeno nešto odgovoriti da olakšamo debugiranje na strani klijenta.
        $response = [];
        $response[ 'ime' ] = $from_email;
        $response[ 'msg' ] = $poruka;
        sendJSONandExit( $response );
    }
}
else
{
    $response = [];
    $response[ 'error' ] = "Poruka nema definirano polje ime ili polje msg.";

    sendJSONandExit( $response );
}

?>
