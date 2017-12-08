<?php
    include ("common.php");
    $conn = connectDB($servername, $username, $password, $name); 
    $sql = "SELECT * FROM products";
    $result = $conn->query($sql);
    if (isset($_POST["function"])) {
        if ($_POST["function"] == "Delete") {
            $query = "DELETE FROM products WHERE id=?";
            $state = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($state, 'i', $_POST["id"]);
            mysqli_stmt_execute($state);
            header("Location: products.php");
            die();
        } else {
            if ($_POST["function"] == "Update") {
                echo "am ajuns aici";
            }
        }                
    }
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
        p {
            display: inline;
        }
    </style>
</head>
<body>  
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Photo</th>
                <th>Specification</th> 
                <th>Posibilities</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
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
                        <form action="products.php" method="post">
                            <input type="hidden" name="function" value="Delete">
                            <input type="hidden" name="id" value="<?=$row["id"]?>">
                            <input type="submit" value="<?= translate('Delete', $translate) ?>">
                        </form>
                        <form action="products.php" method="post">
                            <input type="hidden" name="function" value="Update">                            
                            <input type="submit" value="Update">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    <?php endif;?> 
    <a href="product.php" class="button"><?= translate('Add', $translate) ?></a>
    <a href="logout.php" class="button"><?= translate('Logout', $translate) ?></a>   
    </body>
</html>