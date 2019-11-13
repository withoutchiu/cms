<?php
require('connect.php');

if(isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id'])){
  $query = "SELECT * FROM categories WHERE categoryId = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();

  $qry = "SELECT * FROM items WHERE categoryId = '$_GET[id]'";
  $stmt = $db->prepare($qry);
  $stmt->execute();

  $qryComments = "SELECT * FROM comments ORDER BY dateCreated DESC";
  $comments = $db->prepare($qryComments);
  $comments->execute();

}else{
  header("Location:index.php");
}

if($_POST AND $_POST['comment'] AND isset($_POST['yourName']) AND isset($_POST['content'])){
  echo "<h1> ALAM MO BA </h1>";
  $name = filter_input(INPUT_POST, 'yourName', FILTER_SANITIZE_STRING);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

  $query = "INSERT INTO comments(name, content, categoryId)
                      VALUES (:name, :content, :categoryId)";
  $statement = $db->prepare($query);
  $statement->bindValue(':name', $name);
  $statement->bindValue(':content', $content);
  $statement->bindValue(':categoryId', $_GET['id']);
  $statement->execute();

  header("Location:items.php?id=$_GET[id]");

}

?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Items of Category -TITLE HERE-</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
   </head>
   <body style="background-image:url('Assets/img/bg.jpg'); background-attachment:fixed">
     <?php include('nav.php') ?>
     <div class="container" style="background: white; text-align: center; margin-top:50px;">
                 <!-- Page Heading/Breadcrumbs -->
              <?php while($row = $statement->fetch()): ?>
               <div class="row">
                   <div class="col-lg-12">
                       <h1 class="page-header"><?= $row['categoryTitle'] ?></h1>
                    </div>
               </div>
               <!-- /.row -->

               <!-- Deck One -->
               <div class="row">
                   <div class="col-md-12">
                       <br>
                       <br>
                       <img src="<?=$row['categoryImage'] ?>" height="40%" width="40%">
                   </div>
                   <div class="col-md-12">
                      <?= html_entity_decode($row['categoryDescription'])?>
                       <!-- <h4 class="auto-style1">Ceiling Panel 140 x 25</h4>
                       <p class="auto-style2"> CL14025 W140mm x H25mm</p>
                       <p class="auto-style2"> Edit | Delete</p> -->
                   </div>
               </div>
             <?php endwhile ?>
               <!-- /.row -->
               <hr>

               <div class="row">
                   <div class="col-lg-12">
                       <h1>Different Types</h1>
                        <?php if(isset($_SESSION['userId'])): ?>
                         <button type="button" class="btn btn-primay">
                          <span class="glyphicon glyphicon-plus-sign"></span> <a href="itemsProcess.php?id=<?=$_GET['id']?>&action=100"> Add Item </a>
                        </button>
                        <?php endif ?>
                    </div>
                    <?php if($stmt->rowCount() <= 0): ?>
                      <div class="col-md-12">
                        <h1>No Record Yet </h1>
                        <hr/>
                      </div>
                    <?php else: ?>
                      <?php while($row = $stmt->fetch()): ?>
                        <div class="col-md-7" id="item<?=$row['itemId']?>">
                          <img src="<?=$row['image'] ?>" height="40%" width="40%">
                        </div>
                        <div class="col-md-5">
                            <h4 class="auto-style1"><?= $row['itemName'] ?></h4>
                            <p class="auto-style2"><?= $row['itemCode'] ?> W<?= $row['itemWidth']?>mm x H<?=$row['itemHeight'] ?>mm</p>
                            <?php if(isset($_SESSION['userId'])): ?>
                              <?php if($_SESSION['userId'] == $row['updatedBy'] OR $_SESION['accountType'] == 'Admin'):?>
                                <p class="auto-style2"> <a href="itemsProcess.php?id=<?=$row['itemId']?>&action=200">Edit</a> | <a href="itemsProcess.php?id=<?=$row['itemId']?>&action=300" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a></p>
                              <?php endif ?>
                            <?php endif ?>
                        </div>
                      <?php endwhile ?>
                    <?php endif ?>
               </div>
               <hr>
               <br>

               <div class="row">
                 <h1>Comments Section</h1>
                 <div class="col-md-12 form-group">
                   <form method="POST">
                   <div class="col-md-2">
                     <p>Your Name: </p>
                   </div>
                   <div class="col-md-3">
                     <input type="text" class="input form-control" name="yourName" id="yourName" required>
                   </div>
                 </div>

                 <div class="col-md-12 form-group">
                   <div class="col-md-2">
                     <p>comment: </p>
                   </div>
                   <div class="col-md-10">
                     <textarea rows="8" cols="80" class="input form-control" name="content" id="content" required></textarea>
                   </div>
                 </div>
                 <div class="col-md-12 form-group">
                   <div class="col-md-2">
                     <input type="submit" class="input form-control btn btn-primary" name="comment" id="comment">
                   </div>
                   <!-- <div class="col-md-3">
                     <input type="text" class="input form-control" name="itemName" id="itemName" required>
                   </div> -->
                 </div>
               </div>
               <hr/>
               <div class="row ">
                 <!-- <div class="col-md-12 rounded-sm border border-dark">
                   <blockquote>
                   <p class="text-left"> Gilbert Gulliver Chiu </p>
                   <p class="text-left"><i>July 02, 2019</i></p>
                   <p class="text-left">Item: <b>Wood</b></p>
                     <blockquote class="text-left text-justify">
                       This is the comment for testing.
                     </blockquote>
                   </blockquote>
                 </div> -->
                 <?php while($row = $comments->fetch()): ?>
                 <div class="col-md-12 rounded-sm border border-dark">
                   <blockquote>
                   <p class="text-left"> <?= $row['name'] ?> </p>
                   <p class="text-left"><i><?= $row['dateCreated'] ?></i></p>
                     <blockquote class="text-left text-justify">
                       <?= $row['content'] ?>
                     </blockquote>
                     <?php if(isset($_SESSION['accountType']) AND $_SESSION['accountType'] == 'Admin'):?>
                       <p class="auto-style text-right"> Edit | Delete</p>
                     <?php endif ?>
                   </blockquote>
                 </div>
                <?php endwhile ?>
               </div>
               <div class="row text-center">
                   <div class="col-lg-12">
                   </div>
               </div>
       </div>
       <?php include('footer.php') ?>
   </body>
 </html>
