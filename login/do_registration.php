<?php
session_start();
require '../database/db.php';

if(isset($_POST['btn_ok_registration']))
{
  if(isset($_POST['email']) && isset($_POST['password_1']) && isset($_POST['password_2'])
    && $_POST['email'] !== "" && $_POST['password_1'] !== "" && $_POST['password_2'] !== "")
  {
    if($_POST['password_1'] === $_POST['password_2'])
    {
      require 'check_registration.php';
    }
    else
    {
      $_SESSION['message'] = 'Lozinke se ne poklapaju.';
      header('location: errors.php');
    }
  }
  else
  {
    $_SESSION['message'] = 'Unesite podatke u sva polja.';
    header('location: errors.php');
  }
}
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>
     <form action="do_registration.php" method="post">
       Email: <input type="text" name="email" value="">
       Lozinka: <input type="password" name="password_1" value="">
       Potvrdi lozinku: <input type="password" name="password_2" value="">
       <button type="submit" name="btn_ok_registration">Ok!</button>
     </form>
   </body>
 </html>
