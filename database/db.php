<?php
// Spajanje na bazu, inlcuda se u svim ostalima
$host = 'rp2.studenti.math.hr';
$user = 'student';
$pass = 'pass.mysql';
$db = 'udovicic';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);
$mysqli->set_charset("utf8");

//funkcija koja pretvori složenije upise u 'array'
if (!function_exists('rezultat_u_array')) {
    function rezultat_u_array($rezultat_upita) {
        $retci = array();
        while($redak = $rezultat_upita->fetch_assoc()) {
            $retci[] = $redak;
        }
        return $retci;
    }
}
 ?>
