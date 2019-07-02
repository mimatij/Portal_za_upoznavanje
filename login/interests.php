<?php
session_start();
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
     <title></title>
   </head>
   <body>
     <?php
      if($_SESSION['registriran'] === true && !isset($_SESSION['ulogiran']))
      {
        echo 'Registracija uspješna!';
        echo 'Unestite svoje osobne podatke i interese.';
      }
      elseif($_SESSION['ulogiran'] === true)
      {
        echo 'Izmijenite podatke i spremite promjene<br><br>';
      }
      ?>
      <br>
      <form class="" action="interests.php" method="post">
        Osobni podaci:
        Ime: <input type="text" name="ime" value="" placeholder="<?php echo $_SESSION['ime']; ?>"><br>
        Prezime: <input type="text" name="prezime" value="" placeholder="<?php echo $_SESSION['prezime']; ?>"><br>
        <?php  ?>
        Spol:
        <input type="radio" name="spol" value="Z"> Muškarac
        <input type="radio" name="spol" value="M"> Žena
        <br>
        Grad: <input type="text" name="grad" value="" placeholder="<?php echo $_SESSION['grad']; ?>"><br>
        <button type="submit" name="btn_osobni_podaci">Spremi promjene</button>
      </form>
      <br><br>
      <form action="interests.php" method="post">
        Osobni interesi:
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

      <form action="interests.php" method="post">
        <button type="submit" name="btn_sto_korisnik_trazi">Spremi</button>
      </form>

   </body>
 </html>
