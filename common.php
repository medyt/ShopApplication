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
    function makeQuery($conn,$sql)
    {        
        $result = $conn->query($sql);
        return $result;
    }
    function delete($conn,$id)
    {
        $sql = "DELETE FROM products WHERE id='".$id."'";
        makeQuery($conn, $sql);
        var_dump($sql);
    }
    function remove($id)
    {        
        $removeArray=$_SESSION["incart"];
        $lengthRemove= count($removeArray);        
        for ($i=0; $i<$lengthRemove; $i++) {
            if ($removeArray[$i] == $id) {
                unset($removeArray[$i]);
            }
        }
        $_SESSION["incart"]=$removeArray;
    }
?>