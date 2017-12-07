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
        $lengthRemove= count($_SESSION["incart"]);        
        for ($i = 0; $i < $lengthRemove; $i++) {
            if ($_SESSION["incart"][$i] == $id) {
                unset($_SESSION["incart"][$i]);
            }
        }
    }
?>