<?php
    include ("config.php");
    function startSession(){
        session_start();        
    }
    function getSessionStatus(){
        return $_SESSION["incart"];
    }
    function setSession($idForProductsInCart){
        $_SESSION["incart"]=$idForProductsInCart;
    }
    function connectDB($servername,$username,$password,$name){
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
    function makeQuery($conn,$sql){        
        $result = $conn->query($sql);
        return $result;
    }
    function closeConnection($conn){
        $conn->close();
    }
?>