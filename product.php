<?php
    include ("common.php");
    $conn = connectDB($servername, $username, $password, $name);         
    if (isset($_POST["function"])) {
        if($_POST["function"] == "Add") {  
            $id=5;
            $query = "INSERT INTO products (id,title,description,price) VALUES (?,?,?,?)";
            $state = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($state, 'isss', $id,$_POST["Title"], $_POST["Description"], $_POST["Price"]);
            mysqli_stmt_execute($state);
            $input = $_FILES["fileToUpload"]["tmp_name"];
            $output = "./photo/photo-". $id .'.jpg';
            file_put_contents($output, file_get_contents($input));          
        }
    }    
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
    </style>
</head>
<body>    
    <div>
        <form action="product.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="function" value="Add">
            <input class="solid" id="row" type="text" name="Title" value="Title"><br>
            <input class="solid" id="row" type="text" name="Description" value="Description"><br>    
            <input class="solid" id="row" type="text" name="Price" value="Price"><br>
            <p name="Photo">Image:</p>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <div>
                <a href="products.php" class="button"><?= translate('Products', $translate) ?></a>
                <input type="submit" class="button" value="<?= translate('Save', $translate) ?>" name="submit">
            </div>
        </form>
    </div>
</body>
</html>