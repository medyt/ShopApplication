<?php
    include ("config.php");
    session_start();
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
    $translate = array(
        'Photo' => 'PHOTO',
        'Specification' => 'SPECIFICATION',
        'Add' => 'ADD',
        'title' => 'Title',
        'description' => 'Description',
        'price' => 'Price',
        'Login' => 'LOGIN',
        'Go to cart' => 'GO TO CART',
        'Remove' => 'REMOVE',
        'Go to index' => 'GO TO INDEX',
        'Checkout' => 'CHECKOUT',
        'Name' => 'NAME',
        'Contact details' => 'CONTACT DETAILS',
        'Comments' => 'COMMENTS',
        'Login' => 'LOGIN',
        'Delete' => 'Delete',
        'Logout' => 'LOGOUT',
        'Products' => 'PRODUCTS',
        'Save' => 'SAVE'
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