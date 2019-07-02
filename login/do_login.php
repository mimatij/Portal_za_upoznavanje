<?php
session_start();
require '../database/db.php';

if(isset($_POST['btn_ok_login']))
{
  require 'check_login.php';
}
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Upoznaj.me</title>
   </head>
   <body>
     <form action="do_login.php" method="post">
       Email: <input type="text" name="email" value="">
       Lozinka: <input type="password" name="password" value="">
       <button type="submit" name="btn_ok_login">Ok</button>
     </form>
   </body>
 </html>
