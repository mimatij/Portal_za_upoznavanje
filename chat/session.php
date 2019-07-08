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

$message= [];
$message['uspjeh']=false;
if(isset($_GET['id'])){
    $_SESSION['partner']=$_GET['id'];
    $message['uspjeh']=true;

}


sendJSONandExit( $message );


?>