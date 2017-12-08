<?php 
    include ("common.php");
    $conn = connectDB($servername, $username, $password, $name);        
    if (isset($_POST["function"])) {
        if($_POST["function"] == "Remove") {     
            if (in_array($_POST["id"], $_SESSION["incart"], true)) {
                array_splice($_SESSION["incart"], array_search($_POST["id"], $_SESSION["incart"]), 1);
            }
        } else {
            if($_POST["function"] == "Checkout") {
                $msg = "Dear".$_POST["Name"].",\n\n\n"."My contact details is ".$_POST["Contact"]."\n".$_POST["Comments"];
                $msg = wordwrap($msg, 70);
                ini_set('smtp_port', 26);
                $headers =  'MIME-Version: 1.0' . "\r\n"; 
                $headers .= 'From: Your name <info@address.com>' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
                mail($checkoutemail, "My order", $msg, $headers);
                $_SESSION["incart"] = array();
                header("Location: index.php"); 
                die();
            }
        }
    }
    $length = count($_SESSION["incart"]);               
    $params = array_fill(0, $length, '?');         
    $values[] = str_repeat("i", $length);
    for ($i = 0; $i < $length; $i++) {
        $values[] = &$_SESSION["incart"][$i];
    }
    $row_cnt = 0;
    if ($length > 0) {
        $query = 'SELECT id, title, description, price FROM products WHERE id in ('.implode(',',$params).')';
        $stmt = mysqli_prepare($conn, $query);
        call_user_func_array(array($stmt, "bind_param"), $values);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row_cnt = mysqli_num_rows($result);   
    }  
    $conn->close();                  
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        input.solid {
            border-style: solid;
            border-color:#017572;
        }
        #row {
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
    <?php if($row_cnt > 0): ?>
        <table>
            <tr>
                <th><?= translate('Photo', $translate) ?></th>
                <th><?= translate('Specification', $translate) ?></th>
                <th><?= translate('Add', $translate) ?></th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <img src="<?= "photo/photo-".$row["id"].".jpg" ?>" height="100" width="100">
                    </td>
                    <td>
                        <p><?= translate('title', $translate) ?> : <?= $row["title"] ?> <br/> </p>
                        <p><?= translate('description', $translate) ?> : <?= $row["description"] ?> <br/> </p>
                        <p><?= translate('price', $translate) ?> : <?= $row["price"] ?> </p>
                    </td>
                    <td>
                        <form action="cart.php" method="post">
                            <input type="hidden" name="function" value="Remove">
                            <input type="hidden" name="id" value="<?= $row["id"] ?>">
                            <input type="submit" name="add" value="<?= translate('Remove', $translate) ?>">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    <?php endif;?>
    <div>
        <form action="cart.php" method="post">
            <input type="hidden" name="function" value="Checkout">
            <input class="solid" id="row" type="text" name="Name" value="<?= translate('Name', $translate) ?>"><br>
            <input class="solid" id="row" type="text" name="Contact" value="<?= translate('Contact details', $translate) ?>"><br>    
            <input class="solid" id="row" type="text" name="Comments" value="<?= translate('Comments', $translate) ?>"><br>
            <div>
                <a href="index.php" class="button"><?= translate('Go to index', $translate) ?></a>
                <input type="submit" class="button" value="<?= translate('Checkout', $translate) ?>">
            </div>
        </form>
    </div>
</body>
</html>
