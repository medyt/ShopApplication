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
    p {
        display: inline;
    }
</style>
</head>
<body>

    <?php 
        include ("common.php");
        session_start();
        $conn = connectDB($servername, $username, $password, $name);        
        if (isset($_POST["function"])){
            if(strcmp($_POST["function"], "Remove") == 0) {     
                remove($_POST["id"]);
            }
        }
        $length = count($_SESSION["incart"]);               
        $params = array_fill(0, $length, '?');         
        $values[] = str_repeat("i", $length);
        for ($i=0; $i<$length; $i++) {
            $values[] = &$_SESSION["incart"][$i];
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
        $conn->close();                  
    ?>
    <?php if($row_cnt > 0):?>
        <table>
            <tr>
                <th><?= translate('Photo', $translate) ?></th>
                <th><?= translate('Specification', $translate) ?></th>
                <th><?= translate('Add', $translate) ?></th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <?php $photoName="photo/photo-".$row["id"].".jpg"?>
                <tr>
                    <td>
                        <img src="<?=$photoName?>" height="100" width="100">
                    </td>
                    <td>
                        <p><?= translate('title', $translate) ?> : <?= $row["title"] ?> <br/> </p>
                        <p><?= translate('description', $translate) ?> : <?= $row["description"] ?> <br/> </p>
                        <p><?= translate('price', $translate) ?> : <?= $row["price"] ?> </p>
                    </td>
                    <td>
                        <form action="/appMag/cart.php" method="post">
                            <input type="hidden" name="function" value="Remove">
                            <input type="hidden" name="id" value="<?=$row["id"]?>">
                            <input type="submit" name="add" value="<?= translate('Remove', $translate) ?>">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    <?php endif;?>
    <div>
        <input class="solid" id="row" type="text" name="fname" value="<?= translate('Name', $translate) ?>"><br>
        <input class="solid" id="row" type="text" name="lname" value="<?= translate('Contact details', $translate) ?>"><br>    
        <input class="solid" id="row" type="text" name="lname" value="<?= translate('Comments', $translate) ?>"><br>
        <div>
            <a href="/appMag/index.php" class="button"><?= translate('Go to index', $translate) ?></a>
            <input type="submit" class="button" value="<?= translate('Checkout', $translate) ?>">
        </div>
    </div>
</body>
</html>
