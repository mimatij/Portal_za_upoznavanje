<?php
//spajanje na bazu
require '../database/db.php';

session_start();
echo '<pre>';
//echo '$_SERVER = '; print_r($_SERVER);
echo '$_POST = '; print_r($_POST);
echo '$_SESSION = '; print_r($_SESSION);
echo '<pre>';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upoznaj.me</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>

  </head>
  <body>
    <form action="index.php" method="post">
      <button type="submit" name="btn_login">Login</button>
      <button type="submit" name="btn_register">Registracija</button>
    </form>
    <?php
      echo 'dobar dan';

      if($_SERVER['REQUEST_METHOD'] == 'POST')
      {
        if(isset($_POST['btn_login']))
          header('location: do_login.php');

        elseif(isset($_POST['btn_register']))
          header('location: do_registration.php');

      }
     ?>


  </body>
</html>
