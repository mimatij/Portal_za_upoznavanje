<?php
session_start();
require '../database/db.php';
 ?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title></title>
   </head>
   <body>

     <?php
      if(isset($_SESSION['message']) && !empty($_SESSION['message']))
      {
        echo 'Greška:<br>';
        echo $_SESSION['message'];
      }
      else
        header('location: index.php');
      ?>

      <br>Povratak na naslovnicu:
      <a href="index.php"><button type='submit'/>Ponovi</button></a>
   </body>
 </html>
