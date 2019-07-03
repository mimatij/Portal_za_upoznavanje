<?php
session_start();
require '../database/db.php';

echo '<pre>';
//echo '$_SERVER = '; print_r($_SERVER);
echo '$_POST = '; print_r($_POST);
echo '$_SESSION = '; print_r($_SESSION);
echo '<pre>';

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
     <title></title>
   </head>
   <body>
     <figure>
       slika
     </figure>
     <form action="profile.php" method="post">
       Hello, <?php echo $_SESSION['ime']; ?>
       <h3>SLIKA ne zaboravit
       ne znam je li dobra ideja spremat sliku u tablicu Korisnik, di
     su i svi osobni podaci. Mislim da je okej, ali triba malo istražit *samo ideja</h3>
     <br>
     <h3>Chat - bi li tribalo spremat te poruke? Kao imat neki history?
     Ako da, onda nam i za to triba nekakva tablica - možda za svaki razgovor kreirat
     novu tablicu i spremat poruke po redu - po slanju i onda ih samo izlistat.
     Triba pamtit i email onog koji je posalo poruku. *samo ideja</h3>
       Osnovni podaci:<br>
       Ime: <?php echo "$ime" . ', ' . "$prezime"; ?>
       <br>
       Grad: <?php echo $grad; ?><br>
       <?php
          if($spol === "M") echo 'muškarac<br>';
          elseif($spol === "Z") echo 'žena<br>';
        ?>
        <button type="submit" name="btn_uredi">Uredi</button>
     </form>

   </body>
 </html>
