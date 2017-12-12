<?php
    include ("common.php");
    if (!isset($_SESSION["incart"])) {
        $_SESSION["incart"]=array();
    }
    if (isset($_POST["id"])) {            
        $_SESSION["incart"][] = $_POST['id'];
        header("Location: cart.php"); 
        die();          
    }
    $conn = connectDB(constant("servername"), constant("username"), constant("password"), constant("name"));    
    $length = count($_SESSION["incart"]);        
    $params = array_fill(0, $length, '?');
    $typeOfData = str_repeat("i", $length); 
    $values[] = $typeOfData;
    for ($i = 0; $i < $length; $i++) {
        $values[] = &$_SESSION["incart"][$i];
    }
    if ($length > 0) {
        $query = 'SELECT id, title, description, price FROM products WHERE id not in ('.implode(',',$params).')';
        $stmt = mysqli_prepare($conn, $query);
        call_user_func_array(array($stmt, "bind_param"), $values);            
    } else {
        $query = 'SELECT id, title, description, price FROM products';
        $stmt = mysqli_prepare($conn,$query);            
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row_cnt = mysqli_num_rows($result);   
    $conn->close();       
?>
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
    p {
        display: inline;
    }
    </style>
</head>
<body>
    <h1><?= translate('Online Store', $translate) ?></h1>   
    <?php if($row_cnt > 0): ?>
        <table>
            <tr>
                <th><?= translate('Photo', $translate) ?></th>
                <th><?= translate('Specification', $translate) ?></th>
                <th><?= translate('Add', $translate) ?></th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <img src="photo/photo-<?=$row["id"] ?>.jpg"  height="100" width="100">
                    </td>
                    <td>                        
                        <p><?= translate('title', $translate) ?> : <?= $row["title"] ?> <br/> </p>
                        <p><?= translate('description', $translate) ?> : <?= $row["description"] ?> <br/> </p>
                        <p><?= translate('price', $translate) ?> : <?= $row["price"] ?> </p>
                    </td>
                    <td>
                        <form action="index.php" method="post">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <input type="submit" name="add" value="<?= translate('Add', $translate) ?>">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    <?php endif;?>
    
    <a href="login.php" class="button"><?= translate('Login', $translate) ?></a>
    <a href="cart.php" class="button"><?= translate('Go to cart', $translate) ?></a>
</body>
</html>

