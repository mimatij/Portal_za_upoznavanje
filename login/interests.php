<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
include_once( '../database/db.php');

$email = $_SESSION['email'];
$sql = "SELECT id FROM Korisnik where email='$email'";
$id = $mysqli->query($sql)->fetch_object()->id;

if(isset($_POST['btn_osobni_podaci']))
  include_once('check_personal_data.php');

if(isset($_POST['btn_opis_korisnika']) || isset($_POST['btn_sto_korisnik_trazi']))
  include_once('check_users_description.php');
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

            function provjeri_zadanost_spola($atribut){
              global $mysqli;
              global $id;
              $sql = "SELECT trazim FROM Korisnik WHERE id = $id";
              $a = $mysqli->query($sql)->fetch_object()->trazim;
              if($a == 3)
                echo "checked=checked";
              if($a == 1 && $atribut == 'M' || $a == 2 && $atribut == 'Z')
                echo "checked=checked";
              
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
                    <input type="checkbox" name="odnos[]" value="Veza" <?php provjeri_zadanost('Veza', 'nudim_interese');?> >Vezu
                    <input type="checkbox" name="odnos[]" value="Prijateljstvo" <?php provjeri_zadanost('Prijateljstvo', 'nudim_interese');?>>Prijateljstvo
                    <input type="checkbox" name="odnos[]" value="Druženje" <?php provjeri_zadanost('Druženje', 'nudim_interese');?>>Druženje
                    <input type="checkbox" name="odnos[]" value="Dopisivanje" <?php provjeri_zadanost('Dopisivanje', 'nudim_interese');?>>Dopisivanje
                    <br><a class="naglaseno">Moji hobiji:</a><br>
                    <table>
                        <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Auti" <?php provjeri_zadanost('Auti', 'nudim_interese');?>>Auti</td>
                          <td><input type="checkbox" name="hobiji[]" value="Društvene igre" <?php provjeri_zadanost('Društvene igre', 'nudim_interese');?>>Društvene igre</td>
                          <td><input type="checkbox" name="hobiji[]" value="Film" <?php provjeri_zadanost('Film', 'nudim_interese');?>>Film</td>
                          <td><input type="checkbox" name="hobiji[]" value="Fotografija" <?php provjeri_zadanost('Fotografija', 'nudim_interese');?>>Fotografija</td>
                          <td><input type="checkbox" name="hobiji[]" value="Književnost" <?php provjeri_zadanost('Književnost', 'nudim_interese');?>>Književnost</td>
                          <td><input type="checkbox" name="hobiji[]" value="Kuhanje" <?php provjeri_zadanost('Kuhanje', 'nudim_interese');?>>Kuhanje</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Muzika" <?php provjeri_zadanost('Muzika', 'nudim_interese');?>>Muzika</td>
                          <td><input type="checkbox" name="hobiji[]" value="Plesanje" <?php provjeri_zadanost('Plesanje', 'nudim_interese');?>>Plesanje</td>
                          <td><input type="checkbox" name="hobiji[]" value="Politika" <?php provjeri_zadanost('Politika', 'nudim_interese');?>>Politika</td>
                          <td><input type="checkbox" name="hobiji[]" value="Priroda" <?php provjeri_zadanost('Priroda', 'nudim_interese');?>>Priroda</td>
                          <td><input type="checkbox" name="hobiji[]" value="Putovanja" <?php provjeri_zadanost('Putovanja', 'nudim_interese');?>>Putovanja</td>
                          <td><input type="checkbox" name="hobiji[]" value="Računala" <?php provjeri_zadanost('Računala', 'nudim_interese');?>>Računala</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Računalne igre" <?php provjeri_zadanost('Računalne igre', 'nudim_interese');?>>Računalne igre</td>
                          <td><input type="checkbox" name="hobiji[]" value="Umjetnost" <?php provjeri_zadanost('Umjetnost', 'nudim_interese');?>>Umjetnost</td>
                          <td><input type="checkbox" name="hobiji[]" value="Izlasci"<?php provjeri_zadanost('Izlasci', 'nudim_interese');?>>Izlasci</td>
                          <td><input type="checkbox" name="hobiji[]" value="Kafić"<?php provjeri_zadanost('Kafić', 'nudim_interese');?>>Kafić</td>
                          <td><input type="checkbox" name="hobiji[]" value="Jedrenje"<?php provjeri_zadanost('Jedrenje', 'nudim_interese');?>>Jedrenje</td>
                          <td><input type="checkbox" name="hobiji[]" value="Kazalište"<?php provjeri_zadanost('Kazalište', 'nudim_interese');?>>Kazalište</td>
                        </tr>                   
                    </table>

                    <br> <a class="naglaseno">Moje osobine:</a><br>
                    <table>
                        <tr>
                          <td><input type="checkbox" name="osobine[]" value="Društvenost" <?php provjeri_zadanost('Društvenost', 'nudim_interese');?>>Društvenost</td>
                          <td><input type="checkbox" name="osobine[]" value="Hiperaktivnost" <?php provjeri_zadanost('Hiperaktivnost', 'nudim_interese');?>>Hiperaktivnost</td>
                          <td><input type="checkbox" name="osobine[]" value="Inteligentnost" <?php provjeri_zadanost('Inteligentnost', 'nudim_interese');?>>Inteligentnost</td>
                          <td><input type="checkbox" name="osobine[]" value="Iskrenost" <?php provjeri_zadanost('Iskrenost', 'nudim_interese');?>>Iskrenost</td>
                          <td><input type="checkbox" name="osobine[]" value="Lijenost" <?php provjeri_zadanost('Lijenost', 'nudim_interese');?>>Lijenost</td>
                          <td><input type="checkbox" name="osobine[]" value="Marljivost" <?php provjeri_zadanost('Marljivost', 'nudim_interese');?>>Marljivost</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="osobine[]" value="Ponos" <?php provjeri_zadanost('Ponos', 'nudim_interese');?>>Ponos</td>
                          <td><input type="checkbox" name="osobine[]" value="Pričljivost" <?php provjeri_zadanost('Pričljivost', 'nudim_interese');?>>Pričljivost</td>
                          <td><input type="checkbox" name="osobine[]" value="Radoznalost" <?php provjeri_zadanost('Radoznalost', 'nudim_interese');?>>Radoznalost</td>
                          <td><input type="checkbox" name="osobine[]" value="Spretnost" <?php provjeri_zadanost('Spretnost', 'nudim_interese');?>>Spretnost</td>
                          <td><input type="checkbox" name="osobine[]" value="Sramežljivost" <?php provjeri_zadanost('Sramežljivost', 'nudim_interese');?>>Sramežljivost</td>
                          <td><input type="checkbox" name="osobine[]" value="Vjernost" <?php provjeri_zadanost('Vjernost', 'nudim_interese');?>>Vjernost</td>
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
                    <input type="checkbox" name="trazim_spol[]" value="M" <?php provjeri_zadanost_spola('M');?>>Muško
                    <input type="checkbox" name="trazim_spol[]" value="Z" <?php provjeri_zadanost_spola('Z');?>>Žensko
                    <br><a class="naglaseno">Traži:</a><br>
                    <input type="checkbox" name="odnos2[]" value="Veza" <?php provjeri_zadanost('Veza', 'trazim_interese');?> >Vezu
                    <input type="checkbox" name="odnos2[]" value="Prijateljstvo" <?php provjeri_zadanost('Prijateljstvo', 'trazim_interese');?>>Prijateljstvo
                    <input type="checkbox" name="odnos2[]" value="Druženje" <?php provjeri_zadanost('Druženje', 'trazim_interese');?>>Druženje
                    <input type="checkbox" name="odnos2[]" value="Dopisivanje" <?php provjeri_zadanost('Dopisivanje', 'trazim_interese');?>>Dopisivanje
                    <br><a class="naglaseno">Partnerovi hobiji:</a><br>
                    <table>
                        <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Auti" <?php provjeri_zadanost('Auti', 'trazim_interese');?>>Auti</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Društvene igre" <?php provjeri_zadanost('Društvene igre', 'trazim_interese');?>>Društvene igre</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Film" <?php provjeri_zadanost('Film', 'trazim_interese');?>>Film</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Fotografija" <?php provjeri_zadanost('Fotografija', 'trazim_interese');?>>Fotografija</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Književnost" <?php provjeri_zadanost('Književnost', 'trazim_interese');?>>Književnost</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Kuhanje" <?php provjeri_zadanost('Kuhanje', 'trazim_interese');?>>Kuhanje</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Muzika" <?php provjeri_zadanost('Muzika', 'trazim_interese');?>>Muzika</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Plesanje" <?php provjeri_zadanost('Plesanje', 'trazim_interese');?>>Plesanje</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Politika" <?php provjeri_zadanost('Politika', 'trazim_interese');?>>Politika</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Priroda" <?php provjeri_zadanost('Priroda', 'trazim_interese');?>>Priroda</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Putovanja" <?php provjeri_zadanost('Putovanja', 'trazim_interese');?>>Putovanja</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Računala" <?php provjeri_zadanost('Računala', 'trazim_interese');?>>Računala</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Računalne igre" <?php provjeri_zadanost('Računalne igre', 'trazim_interese');?>>Računalne igre</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Umjetnost" <?php provjeri_zadanost('Umjetnost', 'trazim_interese');?>>Umjetnost</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Izlasci"<?php provjeri_zadanost('Izlasci', 'trazim_interese');?>>Izlasci</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Kafić"<?php provjeri_zadanost('Kafić', 'trazim_interese');?>>Kafić</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Jedrenje"<?php provjeri_zadanost('Jedrenje', 'trazim_interese');?>>Jedrenje</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Kazalište"<?php provjeri_zadanost('Kazalište', 'trazim_interese');?>>Kazalište</td>
                        </tr>                   
                    </table>

                    <br> <a class="naglaseno">Osobine koje tražim:</a><br>
                    <table>
                        <tr>
                          <td><input type="checkbox" name="osobine2[]" value="Društvenost" <?php provjeri_zadanost('Društvenost', 'trazim_interese');?>>Društvenost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Hiperaktivnost" <?php provjeri_zadanost('Hiperaktivnost', 'trazim_interese');?>>Hiperaktivnost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Inteligentnost" <?php provjeri_zadanost('Inteligentnost', 'trazim_interese');?>>Inteligentnost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Iskrenost" <?php provjeri_zadanost('Iskrenost', 'trazim_interese');?>>Iskrenost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Lijenost" <?php provjeri_zadanost('Lijenost', 'trazim_interese');?>>Lijenost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Marljivost" <?php provjeri_zadanost('Marljivost', 'trazim_interese');?>>Marljivost</td>
                        </tr>
                        <tr>
                          <td><input type="checkbox" name="osobine2[]" value="Ponos" <?php provjeri_zadanost('Ponos', 'trazim_interese');?>>Ponos</td>
                          <td><input type="checkbox" name="osobine2[]" value="Pričljivost" <?php provjeri_zadanost('Pričljivost', 'trazim_interese');?>>Pričljivost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Radoznalost" <?php provjeri_zadanost('Radoznalost', 'trazim_interese');?>>Radoznalost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Spretnost" <?php provjeri_zadanost('Spretnost', 'trazim_interese');?>>Spretnost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Sramežljivost" <?php provjeri_zadanost('Sramežljivost', 'trazim_interese');?>>Sramežljivost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Vjernost" <?php provjeri_zadanost('Vjernost', 'trazim_interese');?>>Vjernost</td>
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
