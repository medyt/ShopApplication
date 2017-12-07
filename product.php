<!DOCTYPE html>
<html>
<head>
<style>
    input.solid {border-style: solid;border-color:#017572;}
    #row{
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
    <?php
       /*if (isset($_POST["function"])) {
        if(strcmp($_POST["function"],"Add")==0) {     
            echo "am ajuns aici";
            //add($_POST["title));
        }   
    }  */  
    ?>
    <div>
        <div>            
            <form action="product.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="function" value="Add">
                <input class="solid" id="row" type="text" name="title" value="Title"><br>
                <input class="solid" id="row" type="text" name="Description" value="Description"><br>    
                <input class="solid" id="row" type="text" name="Price" value="Price"><br>
                <p name="Photo">Image:</p>
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" class="button" value="Save" name="submit">
            </form>
        </div>
        <div>
            <a href="/appMag/products.php" class="button">Products</a>
        </div>
    </div>
</body>
</html>