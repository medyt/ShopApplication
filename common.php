<?php
    include ("config.php");
    session_start();
    
    function connectDB($servername, $username, $password, $name)
    {
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $name);
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
        'Save' => 'SAVE',
        'Posibilities' => 'POSIBILITIES',
        'Image' => 'IMAGE',
        'Online Store' => 'ONLINE STORE',
        'Dear' => 'Dear',
        'My contact details is' => 'My contact details is',
        'Your products is' => 'Your products is',
        'Enter Username and Password' => 'Enter Username and Password',
        'You have cleaned session' => 'You have cleaned session',
        'Wrong username or password' => 'Wrong username or password',
        'The type of your file is not accepted. We accept image file.' => 'The type of your file is not accepted. We accept .jpg file.',
        'You did not insert the picture' => 'You did not insert the picture'
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