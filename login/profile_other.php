<?php

// profil kompatibilne osobe
if(!isset($_SESSION)) { 
    session_start(); 
}
include_once('../database/db.php');
$id = $_SESSION['partner'];
$mojid = $_SESSION['mojid'];
$upit = "INSERT INTO spojeni  VALUES ($mojid,$id)";
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
        <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/style_profile.css?<?php echo time(); ?>" media="screen, projection">
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

        <?php
        // Dohvaćanje profilne slike iz baze iz tablice "foto" - fja base64_encode dekodira binarni zapis tipa LONGBLOB
        $sql = "SELECT * FROM foto WHERE id=$id";
        $result = $mysqli->query($sql);
        $row = mysqli_fetch_array($result);
        if($row) // ako je korisnik spremio sliku, nacrtaj ju
            echo ' <img src="data:image/jpeg;base64,'.base64_encode($row['slika'] ).'" class="user_image" /> ';
        else
            echo ' <img src="https://3znvnpy5ek52a26m01me9p1t-wpengine.netdna-ssl.com/wp-content/uploads/2017/07/noimage_person.png" class="user_image" /> ';
        ?>  
        
        <form class="" action="profile.php" method="post"> 
            <div class="user_info">

                <a style="font-weight:600">Ime:</a> <?php echo " $ime" . ' ' . "$prezime"; ?><br><br>
                <a style="font-weight:600">Spol:</a>
                <?php
                    if($spol === "M") echo ' muško';
                    elseif($spol === "Z") echo ' žensko';
                ?><br><br>
                <a style="font-weight:600">Grad:</a> <?php echo " " . $grad; ?>
            </div>
        </form>
 

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

            
        ?>
        
        <br><HR class="break"><br>

        <a class="text">Želiš poslati poruku? Klikni na sljedeći gumb i započni razgovor!</a><br>
        <form action="../chat/chat.html">
            <button type="submit" name="chat" style="font-size: 38px;">&#128140;</button>
        </form>  

    </body>
</html>