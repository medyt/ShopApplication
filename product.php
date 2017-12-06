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
       
    ?>
    <div>
        <input class="solid" id="row" type="text" name="title" value="Title"><br>
        <input class="solid" id="row" type="text" name="Description" value="Description"><br>    
        <input class="solid" id="row" type="text" name="Price" value="Price"><br>
        <div>
            <p name="Photo">Image:</p>
            <input type="submit" class="button" value="Browse"> 
        </div>
        <div>
            <a href="/appMag/index.php" class="button">Go to index</a>
            <input type="submit" class="button" value="Checkout">
        </div>
    </div>
</body>
</html>