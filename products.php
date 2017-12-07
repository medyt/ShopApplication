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
        session_start();
        $conn = connectDB($servername, $username, $password, $name); 
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        if (isset($_POST["function"])) {
            if(strcmp($_POST["function"], "Delete")==0) {
                delete($conn,$_POST["id"]);
            } else {
                if(strcmp($_POST["function"],"Update")==0) {
                    echo "am ajuns aici";
                }
            }                
        }
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
                        <form action="products.php" method="post">
                            <input type="hidden" name="function" value="Delete">
                            <input type="hidden" name="id" value="<?=$row["id"]?>">
                            <input type="submit" value="Delete">
                        </form>
                        <form action="products.php" method="post">
                            <input type="hidden" name="function" value="Update">
                            
                            <input type="submit" value="Update">
                        </form>
                    </td>
                </tr>
            <?php endwhile;?>
        </table>
    <?php endif;?> 
    <a href="/appMag/product.php" class="button">Add</a>
    <a href="/appMag/logout.php" class="button">Logout</a>   
    <?php $conn->close();?>
    </body>
</html>