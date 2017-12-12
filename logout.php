<?php
   include ("common.php");
   $_SESSION['valid']=false;
   unset($_SESSION["username"]);
   $msg = translate('You have cleaned session', $translate);
   header('Refresh: 2; URL = index.php');
?>
<html>
    <head>
    </head>
    <body>
        <?= $msg ?>
    </body>
</html>