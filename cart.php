<!DOCTYPE html>
<html>
<head>
<title>Cart Page</title>
</head>
<body>

    <?php 
        include ("common.php");
        if (isset($_POST["id"])){  
            echo $_POST['id'];
            startSession();
            $idForProductsInCart=$_SESSION["incart"].$_POST['id'].",";
            setSession($idForProductsInCart);
        }
        $conn=connectDB($servername,$username,$password,$name);
        $inCart=getSessionStatus();
        
    ?>
</body>
</html>
