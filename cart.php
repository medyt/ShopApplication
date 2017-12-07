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
        session_start();
        $conn = connectDB($servername, $username, $password, $name); 
        $valuesArray = $_SESSION["incart"];        
        if (isset($_POST["function"])){
            if(strcmp($_POST["function"], "Remove") == 0) {     
                remove($_POST["id"]);
            }   
        }
        $length = count($valuesArray);               
        $params = array_fill(0, $length, '?');         
        $typeOfData = str_repeat("i", $length);         
        $values[] = $typeOfData;
        for ($i=0; $i<$length; $i++) {
            $values[] = &$valuesArray[$i];
        }
        $row_cnt= 0;
        if ($length>0) {
            $query = 'SELECT id, title, description, price FROM products WHERE id in ('.implode(',',$params).')';
            $stmt = mysqli_prepare($conn, $query);
            call_user_func_array(array($stmt, "bind_param"), $values);
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
                    <form action="/appMag/cart.php" method="post">
                        <input type="hidden" name="function" value="Remove">
                        <input type="hidden" name="id" value="<?=$row[0]?>">
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
    <?php $conn->close();?>
</body>
</html>
