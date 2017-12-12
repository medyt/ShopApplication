<?php
   session_start();
   $_SESSION['valid']=false;
   unset($_SESSION["username"]);
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