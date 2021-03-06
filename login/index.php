<?php
//spajanje na bazu
include_once( '../database/db.php');

if(!isset($_SESSION)) { 
  session_start(); 
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upoznaj me!</title>
    <link rel="icon" type="image/png" href="icon.png">
    <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/style_index.css?<?php echo time(); ?>" media="screen, projection">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>
  // Promjena slika na početnoj stranici "index.php" svakih 5 sekundi
$(document).ready(function(){
var container = $('#left');

var backgrounds = new Array(
    'url(index_1.jpg)'
  , 'url(index_2.jpg)'
  , 'url(index_3.jpg)'
);

var trenutni = 0;

function nextBackground() {
    trenutni++;
    trenutni = trenutni % backgrounds.length;
    container.css('background-image', backgrounds[trenutni]);
}
setInterval(nextBackground, 5000);

container.css('background-image', backgrounds[0]);
});
</script>
  </head>

  <body>
    <img src="login_image.png" title="login_image" class="login_image"/>
        
    <div class="logo_div">
        <a href="index.php"><img src="logo.png" title="upoznajme" class="logo_image" /></a>
        <form action="index.php" method="post">
            <button type="submit" name="btn_login" class="btn_login">Login</button>
        </form>
    </div>
    
    <br>
    
    <div id="left" class="left"></div>
    <div class="right">
        <form action="index.php" method="post">
            <button type="submit" name="btn_register" class="btn_register">Registracija</button>
        </form>
    </div>

    <?php

      if($_SERVER['REQUEST_METHOD'] === 'POST')
      {
        if(isset($_POST['btn_login']))
          header('location: do_login.php');

        elseif(isset($_POST['btn_register']))
          header('location: do_registration.php');

      }
     ?>
      
      <div class="dolje">
          <footer>
              <div class="footerContainer">
                <div class="footerBox">
                    <div class="footerItem">
                      <p class="sredina"><a href="mailto:upoznajme@gmail.com"><i class="fa fa-envelope" style="font-size:42px;color:red"></i></a></p>
                      <p>upoznajme@gmail.com</p>
                    </div>

                    <div class="footerItem">
                    <p style="font-size: 200%">&#x1F4CD;</p>
                    <p>Ljubavna Adresa 14/II, Grad Ljubavi</p>
                    </div>

                </div>
              </div>
          </footer>
          <footer>  
              <div class="footerSredina">
                <a>Copyright © 2019 Luka Naglić, Mia Matijašević, Mia Tadić, Kristina Udovičić. All rights reserved.</a>
              </div>
          </footer>
      </div>

  </body>
</html>