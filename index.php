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
        session_start();
        $valuesArray = $_SESSION["incart"]; 
        if (isset($_POST["id"])) {            
            $valuesArray[] = $_POST['id'];
            $_SESSION["incart"] = $valuesArray;
            header("Location: http://localhost/appMag/cart.php");           
        }
        //$_SESSION["incart"]=array();
        $conn = connectDB($servername, $username, $password, $name); 
        $inCartIndex = $_SESSION["incart"];   
        $length = count($inCartIndex);        
        $params = array_fill(0, $length, '?');
        $typeOfData = str_repeat("i", $length); 
        $values[] = $typeOfData;
        for ($i=0; $i<$length; $i++) {
            $values[] = &$inCartIndex[$i];
        }
        /*foreach ($inCartIndex as $id) {
            echo $id;
            $values[] = &$id;
        }*/
        //var_dump($values);
        if ($length>0) {
            $query = 'SELECT id, title, description, price FROM products WHERE id not in ('.implode(',',$params).')';
            $stmt = mysqli_prepare($conn, $query);
            call_user_func_array(array($stmt, "bind_param"), $values);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row_cnt = mysqli_num_rows($result);   
        } else {
            $query = 'SELECT id, title, description, price FROM products';
            $stmt = mysqli_prepare($conn,$query);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row_cnt = mysqli_num_rows($result);
        }       
    ?>
    <?php if($row_cnt > 0):?>
        <table>
            <tr>
                <th>Photo</th>
                <th>Specification</th> 
                <th>Add</th>
            </tr>
            <?php while($row = mysqli_fetch_array($result, MYSQLI_NUM)):?>
                <?php $photoName="photo/photo-".$row[0].".jpg"?>
                <tr>
                    <td>
                        <img src="<?=$photoName?>" height="100" width="100">
                    </td>
                    <td>
                        <?= "title: ".$row[1]."<br/>"?>
                        <?= "description: ".$row[2]."<br/>"?>
                        <?= "price: ".$row[3]?>
                    </td>
                    <td>
                        <form action="/appMag/index.php" method="post">
                            <input type="hidden" name="id" value="<?=$row[0]?>">
                            <input type="submit" name="add" value="Add">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    <?php endif;?>
    
    <?php $conn->close();?>
    <a href="/appMag/login.php" class="button">Login</a>
    <a href="/appMag/cart.php" class="button">Go to cart</a>
</body>
</html>

