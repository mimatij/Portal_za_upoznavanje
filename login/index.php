<?php
session_start();
require '../database/db.php';

echo '<pre>';
echo '$_POST = '; print_r($_POST);
echo '$_SESSION = '; print_r($_SESSION);
echo '<pre>';

if(isset($_POST['btn_login']))
  header('location: do_login.php');

elseif(isset($_POST['btn_register']))
  header('location: do_registration.php');
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upoznaj.me</title>
  </head>
  <body>
    <form action="index.php" method="post">
      <button type="submit" name="btn_login">Login</button>
      <button type="submit" name="btn_register">Registracija</button>
    </form>
  </body>
</html>
