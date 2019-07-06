<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
require '../database/db.php';

if(isset($_POST['btn_osobni_podaci']))
  require 'check_personal_data.php';

if(isset($_POST['btn_opis_korisnika']))
  require 'check_users_description.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upoznaj me! - upitnik</title>
        <link rel="icon" type="image/png" href="icon.png">
        <link rel="stylesheet" type="text/css" href="../css/style_interests.css?<?php echo time(); ?>" media="screen, projection">
        <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Berkshire+Swash' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- "http://fonts.googleapis.com/css?family=Josefin+Sans&subset=latin,latin-ext" -->
    </head>

    <body>

        <div class="logoAndNavbar">
            <a href="profile.php"><img src="logo.png" title="upoznajme" class="logo_image" /></a>

            <div class="navbar">
                <ul class="nav">
                    <li><a href="profile.php" data-hover="Profil">Profil</a></li>
                    <li><a href="chat.php" data-hover="Chat">Chat</a></li>
                    <li class="active"><a href="interests.php" data-hover="Uredi profil">Uredi profil</a></li>
                    <li><a href="logout.php" data-hover="Logout">Logout</a></li>
                </ul>
            </div>
        </div>

        <br>

        <?php
            if($_SESSION['registriran'] === true /*&& !isset($_SESSION['ulogiran'])*/)
            {
              echo '<p class="container_success">Registracija uspješna! '
                . '<i class="fa fa-check" style="color:green; font-size:40px;"></i>'
                . '<br>Unesite svoje osobne podatke i interese.</p>';
              // echo 'Unesite svoje osobne podatke i interese.<br>';
            }
            elseif($_SESSION['ulogiran'] === true)
            {
              echo '<p class="container_success">Izmijenite podatke i spremite promjene.</p>';
            }
          ?>
      
          <br>

          <a class="osobni_podaci">Osobni podaci:</a>
          <a class="moji_interesi">Moji interesi:</a>
          <a class="partnerovi_interesi">Kod partnera volim:</a><br>

          <div class="container_left">
          <form class="" action="interests.php" method="post">
              Ime: <br><input type="text" name="ime" value="" placeholder="<?php echo $_SESSION['ime']; ?>"><br><br>
              Prezime: <br><input type="text" name="prezime" value="" placeholder="<?php echo $_SESSION['prezime']; ?>"><br><br>
              Spol:<br>
              <?php
                  if(isset($_SESSION['spol']) && $_SESSION['spol'] === "M")
                  {
                    echo '<input type="radio" name="spol" value="M" checked="checked">muško';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '<input type="radio" name="spol" value="Z">žensko';
                  }
                  elseif ($_SESSION['spol'] === "Z")
                  {
                    echo '<input type="radio" name="spol" value="M">muško';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '<input type="radio" name="spol" value="Z" checked="cheched">žensko';
                  }
                  else
                  {
                    echo '<input type="radio" name="spol" value="M">muško';
                    echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                    echo '<input type="radio" name="spol" value="Z">žensko';
                  }
              ?>
              <br><br>
              Grad: <br><input type="text" name="grad" value="" placeholder="<?php echo $_SESSION['grad']; ?>"><br><br><br>
              <button type="submit" name="btn_osobni_podaci">Spremi promjene</button>
          </form>
          </div>

          <div class="container_middle">
          <form action="interests.php" method="post">
              Osobni interesi:
              <h3>Ovdje mi nastaju problemi - ne mogu nikako sebi
              lipo u glavi posložit ideju tih tablica i veze</h3>
              <br>Spol koji tražite:
              <br><input type="radio" name="trazim_spol" value="M">muški
              <br><input type="radio" name="trazim_spol" value="Z">ženski
              <br>Vrsta odnosa koja me zanima: [stavila sam radiobotune da bude samo jedno, ali može i drugačije]
              <br><input type="radio" name="odnos" value="veza">Vezu
              <br><input type="radio" name="odnos" value="prijateljstvo">Prijateljstvo
              <br><input type="radio" name="odnos" value="druzenje">Druženje
              <br>
              Hobiji....
              <input type="checkbox" name="hobiji" value="citanje">čitanje
              <input type="checkbox" name="hobiji" value="putovanja_imam">putovanja
              <input type="checkbox" name="hobiji" value="kuhanje">kuhanje

              <button type="submit" name="btn_opis_korisnika">Spremi opis</button>
          </form>
          </div>
      
          <div class="container_right">
          <form action="interests.php" method="post">
              <button type="submit" name="btn_sto_korisnik_trazi">Spremi</button>
          </form>
          </div>

    </body>
</html>
