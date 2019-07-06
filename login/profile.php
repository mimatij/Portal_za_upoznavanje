<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
require '../database/db.php';

// echo '<pre>';
// //echo '$_SERVER = '; print_r($_SERVER);
// echo '$_POST = '; print_r($_POST);
// echo '$_SESSION = '; print_r($_SESSION);
// echo '<pre>';

$email = $_SESSION['email'];
$rezultat = $mysqli->query("SELECT ime, prezime, spol, grad FROM Korisnik WHERE email='$email'");
$korisnik = $rezultat->fetch_assoc();

$ime = $korisnik['ime'];
$prezime = $korisnik['prezime'];
$spol = $korisnik['spol'];
$grad = $korisnik['grad'];

$_SESSION['ime'] = $ime;
$_SESSION['prezime'] = $prezime;
$_SESSION['spol'] = $spol;
$_SESSION['grad'] = $grad;

if(isset($_POST['btn_uredi'])) header('location: interests.php');
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
                    <li><a href="chat.php" data-hover="Chat">Chat</a></li>
                    <li><a href="interests.php" data-hover="Uredi profil">Uredi profil</a></li>
                    <li><a href="logout.php" data-hover="Logout">Logout</a></li>
                </ul>
            </div>
        </div>

        <br>


        <p class="pozdrav">Hello, <?php echo " " . $_SESSION['ime'] . "!"; ?></p>

        <!-- <div class="personal_card"> -->
            <img class="user_image" src="korisnik.jpg" title="user_image"/>        

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

        <!-- </div> -->

    </body>
</html>
