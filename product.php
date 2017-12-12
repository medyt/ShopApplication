<?php
    include ("common.php");
    if ($_SESSION['valid']) {
        $conn = connectDB(constant("servername"), constant("username"), constant("password"), constant("name"));
        $query = "SELECT id FROM products";  
        $state = mysqli_prepare($conn, $query); 
        mysqli_stmt_execute($state);
        $result = mysqli_stmt_get_result($state);
        $ids = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $ids[] = $row["id"];
        } 
        if (isset($_GET["function"])) {
            $id = $_GET["id"];
            $title = $_GET["title"];
            $description = $_GET["description"];
            $price = $_GET["price"];
        } else {
            $id = max($ids)+1;
            $title = "newtitle";
            $description = "newdescription";
            $price = "price";
        }
        if (isset($_POST["id"])) {
            if (!in_array($_POST["id"], $ids)) { 
                $query = "INSERT INTO products (id,title,description,price) VALUES (?,?,?,?)";
                $state = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($state, 'isss', $_POST["id"], $_POST["Title"], $_POST["Description"], $_POST["Price"]);
                
            } else {    
                $query = "UPDATE products SET title = ?, description= ?, price= ? WHERE id = ?";
                $state = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($state, 'sssi', $_POST["Title"], $_POST["Description"], $_POST["Price"], $_POST["id"]);               
            }
            mysqli_stmt_execute($state);
            if (strpos($_FILES["fileToUpload"]["type"], "image") !== false) {
                $input = $_FILES["fileToUpload"]["tmp_name"];
                $output = "photo/photo-". $_POST["id"] .'.jpg';
                move_uploaded_file(file_get_contents($input),$output);
            } 
        }
    } else {
        die();
    }    
?>
<!DOCTYPE html>
<html>
<head>
    <style>
        input.solid {
            border-style: solid;
            border-color:#017572;
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
    <div>
        <form action="product.php" method="post" enctype="multipart/form-data">                    
            <input type="hidden" name="id" value="<?= $id ?>">
            <input class="solid" type="text" name="Title" value="<?= $title ?>"><br>
            <input class="solid" type="text" name="Description" value="<?=$description ?>"><br>    
            <input class="solid" type="text" name="Price" value="<?= $price ?>"><br>
            <p name="Photo"><?= translate('Photo', $translate) ?></p>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <div>
                <a href="products.php" class="button"><?= translate('Products', $translate) ?></a>
                <input type="submit" class="button" value="<?= translate('Save', $translate) ?>" name="submit">
            </div>
        </form>
    </div>  
</body>
</html>