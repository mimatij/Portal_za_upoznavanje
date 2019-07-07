<?php
    $_SESSION['email'] = '';
    $_SESSION['registriran'] = '';
    $_SESSION['ulogiran'] = '';
    $_SESSION['message'] = '';
    $_SESSION['ime'] = '';

    $_SESSION['spol'] = '';
    $_SESSION['prezime'] = '';
    $_SESSION['grad'] = '';

    session_destroy();

    header('location: index.php');
?>