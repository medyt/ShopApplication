<!DOCTYPE html>
<html>
<head>
<title>Cart Page</title>
<style>
    input.solid {border-style: solid;border-color:#017572;}
    #row{
        margin-top: 1.3em;
        height:2em;
        width: 25.4em;
    }
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

    <?php 
        include ("common.php");
        if (isset($_POST["id"])){
            startSession();
            $idForProductsInCart=$_SESSION["incart"].$_POST['id'].",";
            setSession($idForProductsInCart);            
        }
        else{
            startSession();
        }
        if (isset($_POST["function"])){
            if(strcmp($_POST["function"],"Remove")==0){     
                remove($_POST["id"]);
            }   
        }    
        $inCart=getSessionStatus();
        $conn=connectDB($servername,$username,$password,$name);        
        $inCart=mb_substr($inCart,0,-1);
        $inCart=explode(",",$inCart);
        $length= count($inCart);
        if($length>0){
            $inCart=implode("','",$inCart);
            $stmt="'".$inCart."'";
            $sql="SELECT id, title, description, price FROM products WHERE id in (".$stmt.")";
            $result=makeQuery($conn,$sql);
        }
        else
        {
            $sql = "SELECT id, title, description, price FROM products";
            $result=makeQuery($conn,$sql);
        }              
    ?>
    <?php if($result->num_rows > 0):?>
        <table>
        <tr>
            <th>Photo</th>
            <th>Specification</th> 
            <th>Add</th>
        </tr>
        <?php while($row = $result->fetch_assoc()):?>
            <?php $photoName="photo/photo-".$row["id"].".jpg"?>
            <tr>
                <td>
                    <img src="<?=$photoName?>" height="100" width="100">
                </td>
                <td>
                    <?= "title: ".$row["title"]."<br/>"?>
                    <?= "description: ".$row["description"]."<br/>"?>
                    <?= "price: ".$row["price"]?>
                </td>
                <td>
                    <form action="/appMag/cart.php" method="post">
                        <input type="hidden" name="function" value="Remove">
                        <input type="hidden" name="id" value="<?=$row["id"]?>">
                        <input type="submit" name="add" value="Remove">
                    </form>
                </td>
            </tr>
        <?php endwhile;?>
        </table>
    <?php endif;?>
    <div>
        <input class="solid" id="row" type="text" name="fname" value="Name"><br>
        <input class="solid" id="row" type="text" name="lname" value="Contact Details"><br>    
        <input class="solid" id="row" type="text" name="lname" value="Comments"><br>
        <div>
            <a href="/appMag/index.php" class="button">Go to index</a>
            <input type="submit" class="button" value="Checkout">
        </div>
    </div>
    <?php
        closeConnection($conn);
    ?>
</body>
</html>
