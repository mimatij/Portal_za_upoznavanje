<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
include_once('../database/db.php');

// echo '<pre>';
// //echo '$_SERVER = '; print_r($_SERVER);
// echo '$_POST = '; print_r($_POST);
// echo '$_SESSION = '; print_r($_SESSION);
// echo '<pre>';

$email = $_SESSION['email'];
$sql = "SELECT id FROM Korisnik where email='$email'";
$id = $mysqli->query($sql)->fetch_object()->id;
$rezultat = $mysqli->query("SELECT ime, prezime, spol, grad, trazim FROM Korisnik WHERE email='$email'");
$korisnik = $rezultat->fetch_assoc();

$ime = $korisnik['ime'];
$prezime = $korisnik['prezime'];
$spol = $korisnik['spol'];
$trazim = $korisnik['trazim'];
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
                function spoji(){
                    global $id;
                    global $mysqli;
                    global $spol;
                    $jesam = 0;
                    if($spol === 'M')
                        $jesam = 1;
                    if($spol === 'Z')
                        $jesam = 2;
                    global $trazim;
                    $upit = "SELECT id, spol, trazim FROM Korisnik WHERE NOT(id = $id)";
                    $rezultat = $mysqli->query($upit);
                    $retci = rezultat_u_array($rezultat);
                    $max_zbroj = 0;
                    $max_id = 0;
                    foreach ($retci as $key => $value) {
                                                
                        if($value['id'] == $id)
                            continue;
                        if($jesam === 1 && $value['trazim'] == 2 || $jesam === 2 && $value['trazim'] == 1)
                            continue;
                        if($trazim == 1 && $value['spol'] === 'Z' || $trazim ==2 && $value['spol'] ==='M')
                            continue;
                        $id2 = $value['id'];
                        $upit = "SELECT COUNT(trazim_interese.naziv) AS a FROM trazim_interese INNER JOIN nudim_interese ON trazim_interese.naziv=nudim_interese.naziv AND trazim_interese.id=$id AND nudim_interese.id=$id2";
                        $a = $mysqli->query($upit)->fetch_object()->a;    
                        $upit = "SELECT COUNT(trazim_interese.naziv) AS b FROM trazim_interese INNER JOIN nudim_interese ON trazim_interese.naziv=nudim_interese.naziv AND trazim_interese.id=$id2 AND nudim_interese.id=$id";
                        $b = $mysqli->query($upit)->fetch_object()->b;
                        if($a+$b > $max_zbroj){
                            $max_id = $value['id'];
                            $max_zbroj = $a + $b;
                        }                         
                    }
                    if($max_zbroj > 0){
                        $upit = "INSERT INTO spojeni  VALUES ($id,$max_id)";
                        $rezultat = $mysqli->query($upit);
                        return $max_id;
                    }
                   return -1;
                }
            ?>
            <div>
            <?php
                $partner =  spoji();
                if($partner === -1){
                    echo "Nažalost nema kompatibilnih partnera, pokušaj urediti svoj profil :)";
                }
                else{
                    $_SESSION['partner'] = $partner;
                    echo '<form action="profile_other.php"><button type="submit" name="spoji">Spoji me</button></form>';
                    
                }
            ?>
            </div> 

        <!-- </div> -->

    </body>
</html>