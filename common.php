<?php
    include ("config.php");
    function connectDB($servername, $username, $password, $name)
    {
        // Create connection
        $conn = mysqli_connect($servername, $username, $password,$name);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }  
        $conn->select_db($name); 
        $conn->query("SET NAMES 'utf8'");              
        return $conn;
    }
    function delete($conn,$id)
    {
        $query = "DELETE FROM products WHERE id=?";
        $state = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($state, 'i', $id);
        mysqli_stmt_execute($state);
    }
    function remove($id)
    {
        if (in_array($id, $_SESSION["incart"], true)) {
            $key = array_search($id, $_SESSION["incart"]); 
            unset($_SESSION["incart"][$key]);
        }
    }
    function add($title, $description, $price,$file,$conn)
    {
        $id=5;
        $query = "INSERT INTO products (id,title,description,price) VALUES (?,?,?,?)";
        $state = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($state, 'isss', $id,$title, $description, $price);
        mysqli_stmt_execute($state);
        $input = $file["tmp_name"];
        $output = "./photo/photo-". $id .'.jpg';
        file_put_contents($output, file_get_contents($input));
    }
    $translate = array(
        'Photo' => 'PtotoT',
        'Specification' => 'SpecificationT',
        'Add' => 'AddT',
        'title' => 'Title',
        'description' => 'Description',
        'price' => 'Price',
        'Login' => 'LOGIN',
        'Go to cart' => 'GO TO CART'
    );    
    function translate($str, $translate) 
    {
        if (array_key_exists($str, $translate)) {
            return $translate[$str];
        } else {
            return $str;
        }
    }
?>