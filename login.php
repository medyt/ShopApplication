<?php
   include ("common.php");
   $msg = '';
   if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {				
      if ($_POST['username'] == constant("loginusername") && $_POST['password'] == constant("loginpassword")) {
         $_SESSION['valid'] = true;
         $_SESSION['timeout'] = time();
         $_SESSION['username'] = constant("loginusername");
         header("Location: products.php");
         die();
      } else {
         $msg = 'Wrong username or password';
      }
   }
?>
<html>   
   <head>      
      <style>
         .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            }
      </style>      
   </head>	
   <body>      
      <h2><?= translate('Enter Username and Password', $translate) ?></h2>             
      <div class = "container">      
         <form class = "form-signin" role = "form"  method = "post">
            <h4 class = "form-signin-heading"><?= $msg ?></h4>
            <input type = "text" class = "form-control" name = "username" placeholder = "username =<?= constant("loginusername") ?>" required autofocus></br>
            <input type = "password" class = "form-control" name = "password" placeholder = "password = <?= constant("loginpassword") ?>" required></br>
            <button class = "button" type = "submit"name = "login"><?= translate('Login', $translate) ?></button>
         </form>       
      </div>       
   </body>
</html>