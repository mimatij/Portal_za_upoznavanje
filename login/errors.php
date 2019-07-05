<?php
session_start();
require '../database/db.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Upoznaj me! - registracija</title>
        <link rel="icon" type="image/png" href="icon.png">
        <link rel="stylesheet" type="text/css" href="../css/style_errors.css?<?php echo time(); ?>" media="screen, projection">
        <link href='http://fonts.googleapis.com/css?family=Lobster+Two' rel='stylesheet' type='text/css'>
    </head>
    <body>

        <div class="container">
            <p>Greška</p>
      
            <?php
                if(isset($_SESSION['message']) && !empty($_SESSION['message']))
                {
                  // echo 'Greška:<br>';
                  echo $_SESSION['message'];
                }
                else
                  header('location: index.php');
            ?>

            <br><br><br><br>Povratak na naslovnicu:<br><br>
            <a href="index.php"><button type='submit'/>Ponovi</button></a>
        </div>

    </body>
</html>
