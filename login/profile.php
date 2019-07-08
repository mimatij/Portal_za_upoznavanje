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
$_SESSION['mojid'] = $id;
$rezultat = $mysqli->query("SELECT ime, prezime, spol, grad, trazim, geo_sirina, geo_duzina FROM Korisnik WHERE email='$email'");
$korisnik = $rezultat->fetch_assoc();

$ime = $korisnik['ime'];
$prezime = $korisnik['prezime'];
$spol = $korisnik['spol'];
$trazim = $korisnik['trazim'];
$grad = $korisnik['grad'];
$sirina = $korisnik['geo_sirina'];
$duzina = $korisnik['geo_duzina'];


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
                    <li><a href="../chat/messanger.html" data-hover="Chat">Chat</a></li>
                    <li><a href="interests.php" data-hover="Uredi profil">Uredi profil</a></li>
                    <li><a href="logout.php" data-hover="Logout">Logout</a></li>
                </ul>
            </div>
        </div>

        <br>


        <p class="pozdrav">Bok<?php if(isset($_SESSION['ime']) && $_SESSION['ime'] !== '') echo ", " . $_SESSION['ime']; echo "!"; ?></p>
        
        <!-- <div class="personal_card"> -->
            <!-- <img class="user_image" src="korisnik.jpg" title="user_image"/>         -->

            <form class="" action="profile.php" method="post"> 
                <div class="user_info">
                    <a style="font-weight:600">e-mail:</a> <a class="cursive"><?php echo $email; ?></a><br><br>
                    <a style="font-weight:600">Ime:</a> <a class="cursive"><?php echo " $ime" . ' ' . "$prezime"; ?></a><br><br>
                    <a style="font-weight:600">Spol:</a><a class="cursive">
                    <?php
                        if($spol === "M") echo ' muško';
                        elseif($spol === "Z") echo ' žensko';
                    ?></a><br><br>
                    <a style="font-weight:600">Grad:</a> <a class="cursive"><?php echo " " . $grad; ?></a>
                </div>
            </form>
        <!-- </div> -->

        <HR class="break"><br>

    <div class="container">
        <a class="text">Mene opisuju sljedeći pojmovi:</a>
                    
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
            if( $brojac === -1 ) echo "<a class='subtext'>Nisu uneseni podaci o tebi.</a>";
    
            //SELECT id FROM Korisnik WHERE NOT(id = $id); svi idevi
            //SELECT naziv FROM nudim_interese where id = 48;
            //SELECT naziv FROM trazim where id = 48;/
            
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
                    return $max_id;
                }
                return -1;
            }
        ?>
</div>
        <br><HR class="break"><br>
<div class="container">
        <?php
            $partner =  spoji();
            if($partner === -1){
                echo "<a class='text'>Nažalost trenutno nema kompatibilnih partnera s obzirom na unesene osobine.</a><br>";
                echo "<a class='subtext'>Pokušaj urediti svoj profil :)</a>";
            }
            else{
                $_SESSION['partner'] = $partner;
                ?>
                <a class="text">Pronašli smo osobu za tebe koja ti najviše odgovara!</a><br>
                <a class="subtext">S obzirom na osobine koje posjeduješ i koje tražiš kod partnera, pronašli smo osobu koja ti najbolje odgovara. Ako želiš vidjeti njezin profil, brrrrzo klikni na sljedeći gumb! :)</a><br>
                <form action="profile_other.php">
                    <button type="submit" name="spoji" class="heart">Spoji me</button>
                </form>
                <?php
                //echo '<form action="profile_other.php"><button type="submit" name="spoji">Spoji me</button></form>';
            }
        ?>
    </div>

    <br><br>
    </body>
</html>
