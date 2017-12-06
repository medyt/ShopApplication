<!DOCTYPE html>
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
h1{
    style="color: #7a7a7a;text-transform: uppercase;"
}
</style>
</head>
<body>
    <h1>Online Store</h1>
    
    <?php
        include ("common.php");
        startSession();
        //$_SESSION["incart"]="";
        $inCart=getSessionStatus(); 
        $inCart=mb_substr($inCart,0,-1);
        $inCart=explode(",",$inCart);
        $length= count($inCart);
        $conn=connectDB($servername,$username,$password,$name); 
        if($length>0){
            /*$queryStatus=str_repeat("?,", $length);
            $queryStatus=mb_substr($queryStatus,0,-1);
            $typeOfData=str_repeat("i", $length);  
            $sql = mysqli_prepare($conn,"SELECT id, title, description, price FROM products WHERE id not in (".$queryStatus.")");
            $nameForVar="";
            for($i=0;$i<$length;$i++){
                $nameForVar.="$"."id".$i.",";
            }
            $nameForVar=mb_substr($nameForVar,0,-1);
            $nameForVar=explode(",",$nameForVar); 
                       
            call_user_func_array(array($sql, "bind_param"), array_merge(array($typeOfData), $nameForVar));
            
            $result=mysqli_stmt_execute($sql);
            var_dump(mysqli_stmt_execute($sql));*/
            $inCart=implode("','",$inCart);
            $stmt="'".$inCart."'";
            $sql="SELECT id, title, description, price FROM products WHERE id not in (".$stmt.")";
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
                        <input type="hidden" name="id" value="<?=$row["id"]?>">
                        <input type="submit" name="add" value="Add">
                    </form>
                </td>
            </tr>
        <?php endwhile;?>
        </table>
    <?php endif;?>
    
    <?php
        closeConnection($conn);
    ?>
    <a href="/appMag/login.php" class="button">Login</a>
    <a href="/appMag/cart.php" class="button">Go to cart</a>
</body>
</html>

