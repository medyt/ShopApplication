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
    function delete($conn,$id){
        $sql="DELETE FROM products WHERE id='".$id."'";
        makeQuery($conn,$sql);
        var_dump($sql);
    }
    function remove($id){        
        $removeArray=getSessionStatus(); 
        $removeArray=mb_substr($removeArray,0,-1);        
        $removeArray=explode(",",$removeArray);
        $lengthRemove= count($removeArray);        
        for($i=0;$i<$lengthRemove;$i++){
            if($removeArray[$i]==$id){
                $removeArray[$i]="";
                $removeArray[$i+1]="";
            }
        }
        $removeArray=implode(",",$removeArray);
        $_SESSION["incart"]=$removeArray;
    }
?>