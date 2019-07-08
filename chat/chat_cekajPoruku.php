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

if( !isset( $_GET['vrijemeZadnjegPristupa'] ) )
    sendErrorAndExit( 'Nije postavljeno $_GET["vrijemeZadnjegPristupa"].' );

 if( !isset( $_GET['from'] ) )
    sendErrorAndExit( 'Nije postavljeno $_GET["from_"].' );

if( !isset( $_GET['to'] ) )
    sendErrorAndExit( 'Nije postavljeno $_GET["to"].' );

$zadnjiPristup = (int) $_GET[ 'vrijemeZadnjegPristupa' ];

$from_email=$_GET['from'];
$to_email=$_GET['to'];

$rezultat = $mysqli->query("SELECT MAX(lastModified) AS maxLastModified FROM Chat
    WHERE (from_email='$from_email' AND to_email='$to_email')
    OR (from_email='$to_email' AND to_email='$from_email') ");
$row = $rezultat->fetch_assoc();

$timestamp=strtotime($row['maxLastModified']);

if($timestamp > $zadnjiPristup) //Dogodile su se izmjene pa dohvati sve
{
    //Dohvati sve poruke
    $rezultat = $mysqli->query("SELECT from_email,to_email,msg FROM Chat
        WHERE (from_email='$from_email' AND to_email='$to_email')
        OR (from_email='$to_email' AND to_email='$from_email')
        ORDER BY lastModified ASC");

    $message=[];
    $message['vrijemeZadnjegPristupa']=$timestamp;
    $message['poruke']=[];
    while( $poruka = $rezultat->fetch_assoc() )
    {
        $message['poruke'][]=array('from' => $poruka['from_email'],'to' => $poruka['to_email'],'msg' => $poruka['msg']);

    }
    
    sendJSONandExit( $message );
}
//Ako nema izmjena
else {
    $message=[];
    $message['prazno']=true;
    sendJSONandExit( $message );
}

?>
