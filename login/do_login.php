<?php
if(!isset($_SESSION)) { 
    session_start(); 
}
include_once( '../database/db.php');

if(isset($_POST['btn_ok_login']))
{
    include_once('check_login.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upoznaj me! - login</title>
        <link rel="icon" type="image/png" href="icon.png">
        <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="../css/style_do_login.css?<?php echo time(); ?>" media="screen, projection">
    </head>
    
    <body>
        <a href="index.php"><img src="https://www.shareicon.net/data/512x512/2015/10/30/664361_arrows_512x512.png" class="povratak" /></a>
        
        <div class="container">
            <p>Ulogiraj se!</p>

            <form action="do_login.php" method="post">
                Email: <br><input type="text" name="email" value=""><br><br>
                Lozinka: <br><input type="password" name="password" value=""><br><br>
                <button type="submit" name="btn_ok_login">Ok</button>
            </form>
        </div>

    </body>
</html>
