<?php
    include ("common.php");
    if ($_SESSION['valid']) {
        $conn = connectDB(constant("servername"), constant("username"), constant("password"), constant("name"));
        $addphoto = false;
        $id = null;
        $title = "";
        $description = "";
        $price = "";
        if (isset($_GET["id"])) {
            $id = $_GET["id"];
            $query = 'SELECT title, description, price FROM products WHERE id=?';
            $state = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($state, 'i', $id);
            mysqli_stmt_execute($state); 
            $result = mysqli_stmt_get_result($state);
            $row = mysqli_fetch_assoc($result);
            $title = $row["title"];
            $description = $row["description"];
            $price = $row["price"];
        }
        if (isset($_POST["id"])) {
            if ($_FILES["fileToUpload"]["size"] != 0) {
                if (strpos($_FILES["fileToUpload"]["type"], "image") !== false) {
                    $input = $_FILES["fileToUpload"]["tmp_name"];
                    $addphoto = true;
                } else {
                    echo "The type of your file is not accepted. We accept .jpg file.";
                }
            } else {
                echo "You did not insert the picture";
            }
            if ($_POST["id"] == null) { 
                $query = "INSERT INTO products (title,description,price) VALUES (?,?,?)";
                $state = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($state, 'sss', $_POST["Title"], $_POST["Description"], $_POST["Price"]);                
            } else {    
                $query = "UPDATE products SET title = ?, description= ?, price= ? WHERE id = ?";
                $state = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($state, 'sssi', $_POST["Title"], $_POST["Description"], $_POST["Price"], $_POST["id"]); 
                $output = "photo/photo-". $_POST["id"] .'.jpg';              
            }
            mysqli_stmt_execute($state); 
            if ($_POST["id"] == null) { 
                $query = 'SELECT id FROM products WHERE title=?';
                $state = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($state, 's', $_POST["Title"]);
                mysqli_stmt_execute($state);
                $result = mysqli_stmt_get_result($state);
                $row = mysqli_fetch_assoc($result);
                $id = $row["id"];
                $output = "photo/photo-". $id .'.jpg';
            }
            if ($addphoto) {
                move_uploaded_file(file_get_contents($input),$output);
            }
            header("Location: products.php"); 
            die();         
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
            <input class="solid" type="text" name="Title" placeholder="title" value="<?= $title ?>"><br>
            <input class="solid" type="text" name="Description" placeholder="description" value="<?=$description ?>"><br>    
            <input class="solid" type="text" name="Price" placeholder="price" value="<?= $price ?>"><br>
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