<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
require '../database/db.php';

$email = $_SESSION['email'];
$sql = "SELECT id FROM Korisnik where email='$email'";
$id = $mysqli->query($sql)->fetch_object()->id;

if(isset($_POST['btn_osobni_podaci']))
  require 'check_personal_data.php';

if(isset($_POST['btn_opis_korisnika']) || isset($_POST['btn_sto_korisnik_trazi']))
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
          <?php
            function provjeri_zadanost($atribut, $tablica){
              global $mysqli;
              global $id;
              $sql = "SELECT COUNT(*) AS br_zadanih FROM $tablica WHERE id = $id AND naziv = '$atribut'";
              if($mysqli->query($sql)->fetch_object()->br_zadanih == 1)
                echo " checked=checked";
              
            }
          ?>


          <table align = "center">
            <tr>
              <th align = "center"><a class="osobni_podaci">Osobni podaci:</a></th>
              <th align = "center"><a class="moji_interesi">Moji interesi:</a></th>
              <th align = "center"><a class="partnerovi_interesi">Od partnera očekujem:</a></th>
            </tr>
            <tr>
              <td class="td_left">
                <div class="container_left">
                <form class="" action="interests.php" method="post">
                    Ime: <br><input type="text" name="ime" value="" placeholder="<?php echo $_SESSION['ime']; ?>"><br><br>
                    Prezime: <br><input type="text" name="prezime" value="" placeholder="<?php echo $_SESSION['prezime']; ?>"><br><br>
                    Spol:<br>
                    <?php
                        if(isset($_SESSION['spol']) && $_SESSION['spol'] === "M")
                        {
                          echo '<input type="radio" name="spol" value="M" checked="true">muško';
                          echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                          echo '<input type="radio" name="spol" value="Z">žensko';
                        }
                        elseif ($_SESSION['spol'] === "Z")
                        {
                          echo '<input type="radio" name="spol" value="M">muško';
                          echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                          echo '<input type="radio" name="spol" value="Z" checked="true">žensko';
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
              </td>

              <td>
                <div class="container_middle">
                <form action="interests.php" method="post">
                    <br><a class="naglaseno">Tražim:</a><br>
                    <input type="checkbox" name="odnos[]" value="veza" <?php provjeri_zadanost('veza', 'nudim_interese');?> >Vezu
                    <input type="checkbox" name="odnos[]" value="prijateljstvo" <?php provjeri_zadanost('prijateljstvo', 'nudim_interese');?>>Prijateljstvo
                    <input type="checkbox" name="odnos[]" value="druzenje" <?php provjeri_zadanost('druzenje', 'nudim_interese');?>>Druženje
                    <input type="checkbox" name="odnos[]" value="dopisivanje" <?php provjeri_zadanost('dopisivanje', 'nudim_interese');?>>Dopisivanje
                    <br><a class="naglaseno">Moji hobiji:</a><br>
                    <table>
                        <tr>
                          <td><input type="checkbox" name="hobiji[]" value="auti" <?php provjeri_zadanost('auti', 'nudim_interese');?>>Auti</td>
                          <td><input type="checkbox" name="hobiji[]" value="drustvene_igre" <?php provjeri_zadanost('drustvene_igre', 'nudim_interese');?>>Društvene igre</td>
                          <td><input type="checkbox" name="hobiji[]" value="film" <?php provjeri_zadanost('film', 'nudim_interese');?>>Film</td>
                          <td><input type="checkbox" name="hobiji[]" value="fotografija" <?php provjeri_zadanost('fotografija', 'nudim_interese');?>>Fotografija</td>
                          <td><input type="checkbox" name="hobiji[]" value="knjizevnost" <?php provjeri_zadanost('knjizevnost', 'nudim_interese');?>>Književnost</td>
                          <td><input type="checkbox" name="hobiji[]" value="kuhanje" <?php provjeri_zadanost('kuhanje', 'nudim_interese');?>>Kuhanje</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji[]" value="muzika" <?php provjeri_zadanost('muzika', 'nudim_interese');?>>Muzika</td>
                          <td><input type="checkbox" name="hobiji[]" value="plesanje" <?php provjeri_zadanost('plesanje', 'nudim_interese');?>>Plesanje </td>
                          <td><input type="checkbox" name="hobiji[]" value="politika" <?php provjeri_zadanost('politika', 'nudim_interese');?>>Politika</td>
                          <td><input type="checkbox" name="hobiji[]" value="priroda" <?php provjeri_zadanost('priroda', 'nudim_interese');?>>Priroda</td>
                          <td><input type="checkbox" name="hobiji[]" value="putovanja_imam" <?php provjeri_zadanost('putovanja_imam', 'nudim_interese');?>>Putovanja</td>
                          <td><input type="checkbox" name="hobiji[]" value="racunala" <?php provjeri_zadanost('racunala', 'nudim_interese');?>>Računala</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji[]" value="racunalne_igre" <?php provjeri_zadanost('racunalne_igre', 'nudim_interese');?>>Računalne igre</td>
                          <td><input type="checkbox" name="hobiji[]" value="umjetnost" <?php provjeri_zadanost('umjetnost', 'nudim_interese');?>>Umjetnost </td>
                          <td><input type="checkbox" name="hobiji[]" value="izlasci"<?php provjeri_zadanost('izlasci', 'nudim_interese');?>>Izlasci </td>
                          <td><input type="checkbox" name="hobiji[]" value="kafic"<?php provjeri_zadanost('kafic', 'nudim_interese');?>>Kafić </td>
                          <td><input type="checkbox" name="hobiji[]" value="jedrenje"<?php provjeri_zadanost('jedrenje', 'nudim_interese');?>>Jedrenje </td>
                          <td><input type="checkbox" name="hobiji[]" value="kazaliste"<?php provjeri_zadanost('kazaliste', 'nudim_interese');?>>Kazalište </td>
                        </tr>                   
                    </table>

                    


                    <br><br><br>

                    <button type="submit" name="btn_opis_korisnika">Spremi opis</button>
                </form>
                </div>
              </td>
              
              <td>
                <div class="container_right">
                <form action="interests.php" method="post">
                    <br><a class="naglaseno">Partner je:</a><br>
                    <input type="checkbox" name="trazim_spol[]" value="M" <?php provjeri_zadanost('M', 'trazim_interese');?>>Muško
                    <input type="checkbox" name="trazim_spol[]" value="Z" <?php provjeri_zadanost('Z', 'trazim_interese');?>>Žensko
                    <br><a class="naglaseno">Traži:</a><br>
                    <input type="checkbox" name="odnos2[]" value="veza" <?php provjeri_zadanost('veza', 'trazim_interese');?> >Vezu
                    <input type="checkbox" name="odnos2[]" value="prijateljstvo" <?php provjeri_zadanost('prijateljstvo', 'trazim_interese');?>>Prijateljstvo
                    <input type="checkbox" name="odnos2[]" value="druzenje" <?php provjeri_zadanost('druzenje', 'trazim_interese');?>>Druženje
                    <input type="checkbox" name="odnos2[]" value="dopisivanje" <?php provjeri_zadanost('dopisivanje', 'trazim_interese');?>>Dopisivanje
                    <br><a class="naglaseno">Partnerovi hobiji:</a><br>
                    <table>
                        <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="auti" <?php provjeri_zadanost('auti', 'trazim_interese');?>>Auti</td>
                          <td><input type="checkbox" name="hobiji2[]" value="drustvene_igre" <?php provjeri_zadanost('drustvene_igre', 'trazim_interese');?>>Društvene igre</td>
                          <td><input type="checkbox" name="hobiji2[]" value="film" <?php provjeri_zadanost('film', 'trazim_interese');?>>Film</td>
                          <td><input type="checkbox" name="hobiji2[]" value="fotografija" <?php provjeri_zadanost('fotografija', 'trazim_interese');?>>Fotografija</td>
                          <td><input type="checkbox" name="hobiji2[]" value="knjizevnost" <?php provjeri_zadanost('knjizevnost', 'trazim_interese');?>>Književnost</td>
                          <td><input type="checkbox" name="hobiji2[]" value="kuhanje" <?php provjeri_zadanost('kuhanje', 'trazim_interese');?>>Kuhanje</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="muzika" <?php provjeri_zadanost('muzika', 'trazim_interese');?>>Muzika</td>
                          <td><input type="checkbox" name="hobiji2[]" value="plesanje" <?php provjeri_zadanost('plesanje', 'trazim_interese');?>>Plesanje </td>
                          <td><input type="checkbox" name="hobiji2[]" value="politika" <?php provjeri_zadanost('politika', 'trazim_interese');?>>Politika</td>
                          <td><input type="checkbox" name="hobiji2[]" value="priroda" <?php provjeri_zadanost('priroda', 'trazim_interese');?>>Priroda</td>
                          <td><input type="checkbox" name="hobiji2[]" value="putovanja_imam" <?php provjeri_zadanost('putovanja_imam', 'trazim_interese');?>>Putovanja</td>
                          <td><input type="checkbox" name="hobiji2[]" value="racunala" <?php provjeri_zadanost('racunala', 'trazim_interese');?>>Računala</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="racunalne_igre" <?php provjeri_zadanost('racunalne_igre', 'trazim_interese');?>>Računalne igre</td>
                          <td><input type="checkbox" name="hobiji2[]" value="umjetnost" <?php provjeri_zadanost('umjetnost', 'trazim_interese');?>>Umjetnost </td>
                          <td><input type="checkbox" name="hobiji2[]" value="izlasci"<?php provjeri_zadanost('izlasci', 'trazim_interese');?>>Izlasci </td>
                          <td><input type="checkbox" name="hobiji2[]" value="kafic"<?php provjeri_zadanost('kafic', 'trazim_interese');?>>Kafić </td>
                          <td><input type="checkbox" name="hobiji2[]" value="jedrenje"<?php provjeri_zadanost('jedrenje', 'trazim_interese');?>>Jedrenje </td>
                          <td><input type="checkbox" name="hobiji2[]" value="kazaliste"<?php provjeri_zadanost('kazaliste', 'trazim_interese');?>>Kazalište </td>
                        </tr>                   
                    </table>

                    


                    <br><br><br>

                    <button type="submit" name="btn_sto_korisnik_trazi">Spremi</button>
                </form>
                </div>
              </td>
            </tr>
          </table>

          
          

          

          
      
          

    </body>
</html>
