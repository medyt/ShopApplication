<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);
   $msg = 'You have cleaned session';
   header('Refresh: 2; URL = index.php');
?>

<html>
    <head>
    </head>
    <body>
        <?= $msg ?>
    </body>
</html>