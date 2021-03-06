<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
include_once( '../database/db.php');

$email = $_SESSION['email'];
$sql = "SELECT id, ime, prezime, grad, spol FROM Korisnik where email='$email'";
$obj = $mysqli->query($sql)->fetch_object();
$id = $obj->id;
$ime =$obj->ime;
$prezime = $obj->prezime;
$grad = $obj->grad;
$spol = $obj->spol;

//
if( isset($_POST["insert"]) ){  
    $file = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    $sql = "DELETE FROM foto WHERE id=$id";
    $result = $mysqli->query($sql);
    $sql = "INSERT INTO foto(id, slika) VALUES ($id,'$file')";
    $result = $mysqli->query($sql); 
}  
//

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
        <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/style_interests.css?<?php echo time(); ?>" media="screen, projection">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
        <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css" type="text/css">
        <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
   
    </head>

    <body>

        <div class="logoAndNavbar">
            <a href="profile.php"><img src="logo.png" title="upoznajme" class="logo_image" /></a>

            <div class="navbar">
                <ul class="nav">
                    <li><a href="profile.php" data-hover="Profil">Profil</a></li>
                    <li><a href="../chat/messanger.html" data-hover="Chat">Chat</a></li>
                    <li class="active"><a href="interests.php" data-hover="Uredi profil">Uredi profil</a></li>
                    <li><a href="logout.php" data-hover="Logout">Logout</a></li>
                </ul>
            </div>
        </div>

        <br>

        <?php
            if($_SESSION['registriran'] === true)
            {
              echo '<p class="container_success">Registracija uspješna! '
                . '<i class="fa fa-check" style="color:green; font-size:40px;"></i>'
                . '<br>Unesite svoje osobne podatke i interese.</p>';
            }
            elseif($_SESSION['ulogiran'] === true)
            {
              echo '<p class="container_success">Izmijenite podatke i spremite promjene.</p>';
            }
          ?>
      
          <br>
          <?php
            // funkcija koja provjerava u tablici $tablica je li $atribut zadan ili ne te ispisuje checked=checked ako je, inace nista
            function provjeri_zadanost($atribut, $tablica){
              global $mysqli;
              global $id;
              $sql = "SELECT COUNT(*) AS br_zadanih FROM $tablica WHERE id = $id AND naziv = '$atribut'";
              if($mysqli->query($sql)->fetch_object()->br_zadanih == 1)
                echo " checked=checked";
              
            }
            // isto kao i gornja samo za spol
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


          <a class="osobni_podaci">Osobni podaci:</a>
          <a class="moji_interesi">Moji interesi:</a><br>
        
         
          <!-- Unos osnovnih podataka korisnika -->
          <div class="container_left">
              <form class="" action="interests.php" method="post">
                  <a>Ime:</a> <br><input type="text" name="ime" value="" placeholder="<?php echo $ime ?>" required><br><br>
                  <a>Prezime:</a> <br><input type="text" name="prezime" value="" placeholder="<?php echo $prezime ?>" required><br><br>
                  <a>Spol:</a><br>
                  <?php
                      if(isset($spol) && $spol === "M")
                      {
                        echo '<input type="radio" name="spol" value="M" checked="true">muško';
                        echo '&nbsp;&nbsp;&nbsp;&nbsp;';
                        echo '<input type="radio" name="spol" value="Z">žensko';
                      }
                      elseif (isset($spol) && $spol === "Z")
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
                  <a>Grad:</a> <br><input type="text" name="grad" value="" placeholder="<?php echo $grad ?>"><br><br>
                  <button type="submit" name="btn_osobni_podaci">Spremi promjene</button><br><br><br>

                  <a>Lociraj me:</a> <br><button id="btn_geolokacija">Gdje sam?</button><br><br>
              </form>
                      <?php $_SESSION['id'] = $id; ?>
            
                <br>
           
                <!-- Uploadanje slike -->
                <a>Učitaj sliku (jpg, jpeg, gif, png):</a><br>
                <form method="post" enctype="multipart/form-data">  
                        <input type="file" name="image" id="image" /><br><br>
                        <input type="submit" name="insert" id="insert" value="Spremi sliku" />  
                </form>
             
          </div>

          <!-- Unos vlastitih interesa -->
          <div class="container_middle">
          <form action="interests.php" method="post">

              <a class="naglaseno">Tražim:</a><br>
                  <input type="checkbox" name="odnos[]" value="Veza" <?php provjeri_zadanost('Veza', 'nudim_interese');?> ><a>Vezu</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="odnos[]" value="Prijateljstvo" <?php provjeri_zadanost('Prijateljstvo', 'nudim_interese');?>><a>Prijateljstvo</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="odnos[]" value="Druženje" <?php provjeri_zadanost('Druženje', 'nudim_interese');?>><a>Druženje</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="odnos[]" value="Dopisivanje" <?php provjeri_zadanost('Dopisivanje', 'nudim_interese');?>><a>Dopisivanje</a>
              
              <br><br><br><br>
              
              <a class="naglaseno">Moji hobiji:</a><br>
                  <table>
                      <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Auti" <?php provjeri_zadanost('Auti', 'nudim_interese');?>><a>Auti</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Film" <?php provjeri_zadanost('Film', 'nudim_interese');?>><a>Film</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Fotografija" <?php provjeri_zadanost('Fotografija', 'nudim_interese');?>><a>Fotografija</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Politika" <?php provjeri_zadanost('Politika', 'nudim_interese');?>><a>Politika</a></td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Književnost" <?php provjeri_zadanost('Književnost', 'nudim_interese');?>><a>Književnost</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Kuhanje" <?php provjeri_zadanost('Kuhanje', 'nudim_interese');?>><a>Kuhanje</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Muzika" <?php provjeri_zadanost('Muzika', 'nudim_interese');?>><a>Muzika</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Plesanje" <?php provjeri_zadanost('Plesanje', 'nudim_interese');?>><a>Plesanje</a></td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Priroda" <?php provjeri_zadanost('Priroda', 'nudim_interese');?>><a>Priroda</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Putovanja" <?php provjeri_zadanost('Putovanja', 'nudim_interese');?>><a>Putovanja</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Računala" <?php provjeri_zadanost('Računala', 'nudim_interese');?>><a>Računala</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Kazalište"<?php provjeri_zadanost('Kazalište', 'nudim_interese');?>><a>Kazalište</a></td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Umjetnost" <?php provjeri_zadanost('Umjetnost', 'nudim_interese');?>><a>Umjetnost</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Izlasci"<?php provjeri_zadanost('Izlasci', 'nudim_interese');?>><a>Izlasci</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Kafić"<?php provjeri_zadanost('Kafić', 'nudim_interese');?>><a>Kafić</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Jedrenje"<?php provjeri_zadanost('Jedrenje', 'nudim_interese');?>><a>Jedrenje</a></td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji[]" value="Računalne igre" <?php provjeri_zadanost('Računalne igre', 'nudim_interese');?>><a>Računalne igre</a></td>
                          <td><input type="checkbox" name="hobiji[]" value="Društvene igre" <?php provjeri_zadanost('Društvene igre', 'nudim_interese');?>><a>Društvene igre</a></td>
                      </tr>
                  </table>

              <br><br><br>

              <a class="naglaseno">Moje osobine:</a><br>
                  <table>
                      <tr>
                          <td><input type="checkbox" name="osobine[]" value="Društvenost" <?php provjeri_zadanost('Društvenost', 'nudim_interese');?>><a>Društvenost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Hiperaktivnost" <?php provjeri_zadanost('Hiperaktivnost', 'nudim_interese');?>><a>Hiperaktivnost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Inteligencija" <?php provjeri_zadanost('Inteligencija', 'nudim_interese');?>><a>Inteligencija</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Iskrenost" <?php provjeri_zadanost('Iskrenost', 'nudim_interese');?>><a>Iskrenost</a>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="osobine[]" value="Lijenost" <?php provjeri_zadanost('Lijenost', 'nudim_interese');?>><a>Lijenost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Marljivost" <?php provjeri_zadanost('Marljivost', 'nudim_interese');?>><a>Marljivost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Ponos" <?php provjeri_zadanost('Ponos', 'nudim_interese');?>><a>Ponos</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Pričljivost" <?php provjeri_zadanost('Pričljivost', 'nudim_interese');?>><a>Pričljivost</a></td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="osobine[]" value="Radoznalost" <?php provjeri_zadanost('Radoznalost', 'nudim_interese');?>><a>Radoznalost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Spretnost" <?php provjeri_zadanost('Spretnost', 'nudim_interese');?>><a>Spretnost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Sramežljivost" <?php provjeri_zadanost('Sramežljivost', 'nudim_interese');?>><a>Sramežljivost</a></td>
                          <td><input type="checkbox" name="osobine[]" value="Vjernost" <?php provjeri_zadanost('Vjernost', 'nudim_interese');?>><a>Vjernost</a></td>
                      </tr>
                  </table>
              
              <br><br><br>

              <button type="submit" name="btn_opis_korisnika">Spremi opis</button>
          </form>
          </div>

          <!-- Unos partnerovih interesa koje tražimo -->
          <a class="partnerovi_interesi">Od partnera očekujem:</a><br>

          <div class="container_right">
          <form action="interests.php" method="post">
              <a class="naglaseno">Partner je:</a><br>
                  <input type="checkbox" name="trazim_spol[]" value="M" <?php provjeri_zadanost_spola('M');?>><a>Muško</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="trazim_spol[]" value="Z" <?php provjeri_zadanost_spola('Z');?>><a>Žensko</a>
              
              <br><br><br>
              
              <a class="naglaseno">Traži:</a><br>
                  <input type="checkbox" name="odnos2[]" value="Veza" <?php provjeri_zadanost('Veza', 'trazim_interese');?> ><a>Vezu</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="odnos2[]" value="Prijateljstvo" <?php provjeri_zadanost('Prijateljstvo', 'trazim_interese');?>><a>Prijateljstvo</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="odnos2[]" value="Druženje" <?php provjeri_zadanost('Druženje', 'trazim_interese');?>><a>Druženje</a> &nbsp;&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="odnos2[]" value="Dopisivanje" <?php provjeri_zadanost('Dopisivanje', 'trazim_interese');?>><a>Dopisivanje</a> &nbsp;&nbsp;&nbsp;&nbsp;
              
              <br><br><br>
              
              <a class="naglaseno">Partnerovi hobiji:</a><br>

                  <table>
                      <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Auti" <?php provjeri_zadanost('Auti', 'trazim_interese');?>>Auti</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Film" <?php provjeri_zadanost('Film', 'trazim_interese');?>>Film</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Fotografija" <?php provjeri_zadanost('Fotografija', 'trazim_interese');?>>Fotografija</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Književnost" <?php provjeri_zadanost('Književnost', 'trazim_interese');?>>Književnost</td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Kuhanje" <?php provjeri_zadanost('Kuhanje', 'trazim_interese');?>>Kuhanje</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Muzika" <?php provjeri_zadanost('Muzika', 'trazim_interese');?>>Muzika</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Plesanje" <?php provjeri_zadanost('Plesanje', 'trazim_interese');?>>Plesanje</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Politika" <?php provjeri_zadanost('Politika', 'trazim_interese');?>>Politika</td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Priroda" <?php provjeri_zadanost('Priroda', 'trazim_interese');?>>Priroda</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Putovanja" <?php provjeri_zadanost('Putovanja', 'trazim_interese');?>>Putovanja</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Računala" <?php provjeri_zadanost('Računala', 'trazim_interese');?>>Računala</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Umjetnost" <?php provjeri_zadanost('Umjetnost', 'trazim_interese');?>>Umjetnost</td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Izlasci"<?php provjeri_zadanost('Izlasci', 'trazim_interese');?>>Izlasci</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Kafić"<?php provjeri_zadanost('Kafić', 'trazim_interese');?>>Kafić</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Jedrenje"<?php provjeri_zadanost('Jedrenje', 'trazim_interese');?>>Jedrenje</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Kazalište"<?php provjeri_zadanost('Kazalište', 'trazim_interese');?>>Kazalište</td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="hobiji2[]" value="Računalne igre" <?php provjeri_zadanost('Računalne igre', 'trazim_interese');?>>Računalne igre</td>
                          <td><input type="checkbox" name="hobiji2[]" value="Društvene igre" <?php provjeri_zadanost('Društvene igre', 'trazim_interese');?>>Društvene igre</td>
                      </tr>
                  </table>
              
              <br><br>
              
              <a class="naglaseno">Osobine koje tražim:</a><br>

                  <table>
                      <tr>
                          <td><input type="checkbox" name="osobine2[]" value="Društvenost" <?php provjeri_zadanost('Društvenost', 'trazim_interese');?>>Društvenost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Hiperaktivnost" <?php provjeri_zadanost('Hiperaktivnost', 'trazim_interese');?>>Hiperaktivnost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Inteligencija" <?php provjeri_zadanost('Inteligencija', 'trazim_interese');?>>Inteligencija</td>
                          <td><input type="checkbox" name="osobine2[]" value="Iskrenost" <?php provjeri_zadanost('Iskrenost', 'trazim_interese');?>>Iskrenost</td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" name="osobine2[]" value="Lijenost" <?php provjeri_zadanost('Lijenost', 'trazim_interese');?>>Lijenost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Marljivost" <?php provjeri_zadanost('Marljivost', 'trazim_interese');?>>Marljivost</td>
                          <td><input type="checkbox" name="osobine2[]" value="Ponos" <?php provjeri_zadanost('Ponos', 'trazim_interese');?>>Ponos</td>
                          <td><input type="checkbox" name="osobine2[]" value="Pričljivost" <?php provjeri_zadanost('Pričljivost', 'trazim_interese');?>>Pričljivost</td>
                      </tr>
                      <tr>
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


          
          <script>
$( document ).ready( function() 
{
    $( "#btn_geolokacija" ).on( "click", locate );

    $( "#insert" ).on( "click", photoCorrectness ); 
} );

// Funkcija koja dohvaća geografsku širinu i dužinu korisnika i zatim ih šalje preko ajaxa skripti "geolocation.php" koja će ih spremiti u bazu
function locate() 
{
    navigator.geolocation.getCurrentPosition( function( pos ) 
    {
        var sir = Number(pos.coords.latitude);
        var duz = Number(pos.coords.longitude);

        $.ajax(
        {
            url: "geolocation.php",
            data:
            {
                sirina: sir,
                duzina: duz
            },
            success: function( data )
            {
            },
            error: function( xhr, status )
            {
                if( status !== null )
                    console.log( "Greška prilikom Ajax poziva: " + status );
            }
        } );
    } );
}

function photoCorrectness(){ 
    var ime_slike = $( "#image" ).val();  
    if(ime_slike == ''){  
        alert( "Odaberi sliku." );  
        return false;  
    }  
    else{  
        var tip_slike = $( "#image" ).val().split('.').pop().toLowerCase();  
        if(jQuery.inArray(tip_slike, ['gif','png','jpg','jpeg']) === -1){  
            alert( "Nedopušten tip slike." );  
            $( "#image" ).val('');  
            return false;  
        }  
    }  
}

</script>


    </body>
</html>
