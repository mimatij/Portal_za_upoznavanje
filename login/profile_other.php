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
                    <li><a href="../chat/chat.html" data-hover="Chat">Chat</a></li>
                    <li><a href="interests.php" data-hover="Uredi profil">Uredi profil</a></li>
                    <li><a href="logout.php" data-hover="Logout">Logout</a></li>
                </ul>
            </div>
        </div>

        <br>


        
        <p class="pozdrav">Bok <?php echo " " . $_SESSION['ime'] . ", ovo je profil tvog kompatibilnog partnera!"; ?></p>

        <!-- <div class="personal_card"> -->
            <img class="user_image" src="korisnik.jpg" title="user_image"/>

            <form action="../chat/chat.html">
            <button type="submit" name="chat">Pošalji poruku!</button>
            </form>        

            <!-- **treba li form ovdje uopce? -->
            <form class="" action="profile.php" method="post"> 
                <!-- 
                <h3>SLIKA ne zaboravit
                    ne znam je li dobra ideja spremat sliku u tablicu Korisnik, di
                    su i svi osobni podaci. Mislim da je okej, ali triba malo istražit *samo ideja
                </h3>
                <br>
                <h3>Chat - bi li tribalo spremat te poruke? Kao imat neki history?
                    Ako da, onda nam i za to triba nekakva tablica - možda za svaki razgovor kreirat
                    novu tablicu i spremat poruke po redu - po slanju i onda ih samo izlistat.
                    Triba pamtit i email onog koji je posalo poruku. *samo ideja
                </h3> 
                -->
                <div class="user_info">

                    <!-- Osnovni podaci:<br> -->
                    Ime: <?php echo " $ime" . ' ' . "$prezime"; ?><br><br>
                    Spol:
                    <?php
                        if($spol === "M") echo ' muško';
                        elseif($spol === "Z") echo ' žensko';
                    ?><br><br>
                    Grad: <?php echo " " . $grad; ?><br><br>
                    <!-- <button type="submit" name="btn_uredi">Uredi</button> **ovo ne treba vise jer u izborniku postoji mogucnost "uredi profil" -->
                </div>
            </form>

            Mene opisuju sljedeći pojmovi:
            <?php 
               
                
                $upit = "SELECT naziv FROM nudim_interese WHERE id = $id";
                $rezultat = $mysqli->query($upit);
                $retci = rezultat_u_array($rezultat);
                foreach ($retci as $key => $value) {
                    foreach ($value as $key => $value2) {
                        echo $value2.", ";
                    }
                }
                

                //SELECT id FROM Korisnik WHERE NOT(id = $id); svi idevi
                //SELECT naziv FROM nudim_interese where id = 48;
               // SELECT naziv FROM trazim where id = 48;/

               
               //SELECT trazim_interese.naziv FROM trazim_interese INNER JOIN nudim_interese ON trazim_interese.naziv=nudim_interese.naziv AND trazim_interese.id=48 AND nudim_interese.id=55;
                
            ?>
            

        <!-- </div> -->

    </body>
</html>