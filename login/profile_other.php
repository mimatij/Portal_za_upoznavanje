<?php

if(!isset($_SESSION)) { 
    session_start(); 
}
include_once('../database/db.php');
$id = $_SESSION['partner'];
$mojid = $_SESSION['mojid'];
$upit = "INSERT INTO spojeni  VALUES ($id,$mojid)";
$rezultat = $mysqli->query($upit);


$rezultat = $mysqli->query("SELECT ime, prezime, spol, grad, trazim, email FROM Korisnik WHERE id='$id'");
$korisnik = $rezultat->fetch_assoc();

$ime = $korisnik['ime'];
$prezime = $korisnik['prezime'];
$spol = $korisnik['spol'];
$trazim = $korisnik['trazim'];
$grad = $korisnik['grad'];
$email = $korisnik['email'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upoznaj me! - profil</title>
        <link rel="icon" type="image/png" href="icon.png">
        <link rel="stylesheet" type="text/css" href="../css/style_profile.css?<?php echo time(); ?>" media="screen, projection">
        <link href='http://fonts.googleapis.com/css?family=Berkshire+Swash' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
    </head>

    <body>

        <div class="logoAndNavbar">
            <a href="profile.php"><img src="logo.png" title="upoznajme" class="logo_image" /></a>

            <div class="navbar">
                <ul class="nav">
                    <li class="active"><a href="profile.php" data-hover="Profil">Profil</a></li>
                    <li><a href="../chat/messanger.html" data-hover="Chat">Chat</a></li>
                    <li><a href="interests.php" data-hover="Uredi profil">Uredi profil</a></li>
                    <li><a href="logout.php" data-hover="Logout">Logout</a></li>
                </ul>
            </div>
        </div>

        <br>

        <p class="pozdrav">Ovo je profil tvog kompatibilnog partnera!</p>

        <!-- <div class="personal_card"> -->
            <!-- <img class="user_image" src="korisnik.jpg" title="user_image"/>  -->

            <form class="" action="profile.php" method="post"> 
                <div class="user_info">

                    <!-- Osnovni podaci:<br> -->
                    <a style="font-weight:600">Ime:</a> <?php echo " $ime" . ' ' . "$prezime"; ?><br><br>
                    <a style="font-weight:600">Spol:</a>
                    <?php
                        if($spol === "M") echo ' muško';
                        elseif($spol === "Z") echo ' žensko';
                    ?><br><br>
                    <a style="font-weight:600">Grad:</a> <?php echo " " . $grad; ?>
                </div>
            </form>
        <!-- </div> -->

        <HR class="break"><br>

        <a class="text">Ovu osobu opisuju sljedeći pojmovi:</a>

        <?php 
            $upit = "SELECT naziv FROM nudim_interese WHERE id = $id";
            $rezultat = $mysqli->query($upit);
            $retci = rezultat_u_array($rezultat);
            $brojac = -1;
            echo '<ul class="lista_osobine">';
            foreach ($retci as $key => $value) {
                foreach ($value as $key => $value2) {
                    $brojac++;
                    if($brojac % 5 === 0) echo '</ul><ul class="lista_osobine">';
                    echo '<li>' . $value2 . '</li>';
                }
            }
            echo '</ul>';

            //SELECT id FROM Korisnik WHERE NOT(id = $id); svi idevi
            //SELECT naziv FROM nudim_interese where id = 48;
            //SELECT naziv FROM trazim where id = 48;/
            
            //SELECT trazim_interese.naziv FROM trazim_interese INNER JOIN nudim_interese ON trazim_interese.naziv=nudim_interese.naziv AND trazim_interese.id=48 AND nudim_interese.id=55;
        ?>
        
        <br><HR class="break"><br>

        <a class="text">Želiš poslati poruku? Klikni na sljedeći gumb i započni razgovor!</a><br>
        <form action="../chat/chat.html">
            <button type="submit" name="chat" style="font-size: 38px;">&#128140;</button>
        </form>  

    </body>
</html>