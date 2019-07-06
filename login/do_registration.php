<?php
if(!isset($_SESSION)) { 
  session_start(); 
}
//baza uključit
//triba li ovdje?
include_once( '../database/db.php');

if(isset($_POST['btn_ok_registration']))
{
  //echo 'eto';
  if(isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2'])
    && $_POST['email'] !== "" && $_POST['password_1'] !== "" && $_POST['password_2'] !== "")
  {
    if($_POST['password_1'] === $_POST['password_2'])
    {
      //echo 'moze';
      include_once('check_registration.php');
    }
    else
    {
      $_SESSION['message'] = 'Lozinke se ne poklapaju.';
      header('location: errors.php');
    }
  }
  else
  {
    //echo 'nije';
    $_SESSION['message'] = 'Unesite podatke u sva polja.';
    header('location: errors.php');
  }

}
?>

<!DOCTYPE html>
<html>
  <head>
      <meta charset="utf-8">
      <title>Upoznaj me! - registracija</title>
      <link rel="icon" type="image/png" href="icon.png">
      <link rel="stylesheet" type="text/css" href="../css/style_do_registration.css?<?php echo time(); ?>" media="screen, projection">
      <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
  </head>

  <body>
      <div class="container">
          <p>Registriraj se!</p>
          <form action="do_registration.php" method="post">
              Email: <br><input type="text" name="email" value=""><br><br>
              Lozinka: <br><input type="password" name="password_1" value=""><br><br>
              Potvrdi lozinku: <br><input type="password" name="password_2" value=""><br><br>
              <button type="submit" name="btn_ok_registration">Ok!</button>
          </form>
      </div>
  </body>
</html>
