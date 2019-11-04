<?php


$action = "none";

function call()
{
  header("Location:index.php");
  exit;
}

if(isset($_GET['action']) == "insert"){
    $action = "insert";
}else{
    call();
}

?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Product Categories</title>
   </head>
   <body>
     <?php include('nav.php') ?>
     <?php if($action == "insert"): ?>
       <h1>insert</h1>
       <form action="insertCategories.php" method="POST">
         <p>Category Title: <input type="text" name="categoryTitle" id="categoryTitle"/></p>
         <p>Category Description: <input type="text" name="categoryDescription" id="categoryDescription"/></p>
         <input type="text" name="updatedBy" id="updatedBy" value="<?=$_SESSION['firstName']?> <?=$_SESSION['lastName']?>" style="display:none"/>
         <p><input type="submit" value="submit"></p>
      </form>
     <?php endif ?>
   </body>
 </html>
