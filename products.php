<!DOCTYPE html>
<html>
<head>
<style>
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
    <h1>Products Management</h1>
    <?php
        include ("common.php");
        $conn=connectDB($servername,$username,$password,$name); 
        $sql="SELECT * FROM products";
        $result=makeQuery($conn,$sql);
    ?>
    <?php if($result->num_rows > 0):?>
        <table>
        <tr>
            <th>Photo</th>
            <th>Specification</th> 
            <th>Posibilities</th>
        </tr>
        <?php while($row = $result->fetch_assoc()):?>
            <?php $photoName="photo/photo-".$row["id"].".jpg"?>
            <tr>
                <td>
                    <img src="<?=$photoName?>" height="100" width="100">
                </td>
                <td>
                    <?= "title: ".$row["title"]."<br/>"?>
                    <?= "description: ".$row["description"]."<br/>"?>
                    <?= "price: ".$row["price"]?>
                </td>
                <td>
                    
                </td>
            </tr>
        <?php endwhile;?>
        </table>
    <?php endif;?> 
    <a href="/appMag/product.php" class="button">Add</a>
    <a href="/appMag/logout.php" class="button">Logout</a>   
    </body>
</html>