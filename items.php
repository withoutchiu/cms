<?php
require('connect.php');
session_start();
if(isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id'])){
  $query = "SELECT * FROM categories WHERE categoryId = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();

  $qry = "SELECT * FROM items WHERE categoryId = '$_GET[id]'";
  $stmt = $db->prepare($qry);
  $stmt->execute();

  $qryComments = "SELECT * FROM comments WHERE isHidden = false ORDER BY dateCreated DESC";
  $comments = $db->prepare($qryComments);
  $comments->execute();

}else{
  header("Location:index.php");
}

if($_POST AND $_POST['comment'] AND isset($_POST['yourName']) AND isset($_POST['content']) AND isset($_POST['captcha'])){
  echo "<h1> ALAM MO BA </h1>";
  $name = filter_input(INPUT_POST, 'yourName', FILTER_SANITIZE_STRING);
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);

  if($_POST['captcha'] == $_SESSION['digit']){
    echo "<h1>----" . $_SESSION['digit'] . "</h1>";
    $query = "INSERT INTO comments(name, content, categoryId)
                        VALUES (:name, :content, :categoryId)";
    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':content', $content);
    $statement->bindValue(':categoryId', $_GET['id']);
    $statement->execute();
    header("Location:items.php?id=$_GET[id]#commentSection");
  }else{
    $errorMessage = "Incorrect Captcha. Please try again.";
    $hasError = true;
  }

}
// if($_POST AND $_POST['updateComment'] AND isset($_POST['content']) AND isset($_POST['commentId'])){
//
//   $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
//   $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);
//   $isHidden = $_POST['isHidden'];
//
//   if($isHidden == true){
//     $isHidden = 1;
//   }
//
//   if($_POST['isDisemvowel'] == true){
//     $content = str_replace(array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), '', $content);
//   }
//
//   $query = "UPDATE comments SET content ='$content', isHidden = '$isHidden'
//   WHERE commentId = '$commentId' ";
//
//   $statement = $db->prepare($query);
//   $statement->execute();
//
//   header("Location:items.php?id=$_GET[id]#commentSection");
//
// }

// if($_POST AND $_POST['deleteComment'] AND isset($_POST['content']) AND isset($_POST['commentId'])){
//   $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
//   $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);
//
//   $query = "DELETE FROM comments
//   WHERE commentId = '$commentId' ";
//
//   $statement = $db->prepare($query);
//   $statement->execute();
//
//   header("Location:items.php?id=$_GET[id]#commentSection");
//
// }
?>


 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Items of Category -TITLE HERE-</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <script src='indexcss/js/items.js'></script>
   </head>
   <body style="background-image:url('Assets/img/bg.jpg'); background-attachment:fixed">
     <?php include('nav.php') ?>
     <div class="container itemDisplay" style="background: white; text-align: center; margin-top:50px;">
                 <!-- Page Heading/Breadcrumbs -->
              <?php while($row = $statement->fetch()): ?>
               <div class="row">
                   <div class="col-lg-12 text-center">
                       <h1 class="page-header"><?= $row['categoryTitle'] ?></h1>
                    </div>
               </div>
               <!-- /.row -->

               <!-- Deck One -->
               <div class="row">
                   <div class="col-md-12 text-center">
                       <br>
                       <br>
                       <img src="<?=$row['categoryImage'] ?>" height="100%" width="100%">
                   </div>
                   <div class="col-md-12" id="categoryDescriptionDisplay">
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
                   <div class="col-lg-12 text-center">
                       <h1>Different Types</h1>
                        <?php if(isset($_SESSION['userId'])): ?>
                         <button type="button" class="btn btn-primay">
                          <span class="glyphicon glyphicon-plus-sign"></span> <a href="itemsProcess.php?id=<?=$_GET['id']?>&action=100"> Add Item </a>
                        </button>
                        <?php endif ?>
                        <hr/>
                    </div>
                    <?php if($stmt->rowCount() <= 0): ?>
                      <div class="col-md-12 text-center">
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                          <p class="bg-danger">No Item to display, please add an item. </p>
                        </div>
                        <div class="col-md-4">
                        </div>
                      </div>
                    <?php else: ?>
                      <?php while($row = $stmt->fetch()): ?>
                        <div class="col-md-7 text-center" id="item<?=$row['itemId']?>">
                          <img src="<?=substr($row['image'],0,-4) . "_medium" . substr($row['image'],-4)?>" alt="<?= $row['itemName'] ?>">
                        </div>
                        <div class="col-md-5">
                            <p class="auto-style2"><?= $row['itemName'] ?></p>
                            <p class="auto-style2"><?= $row['itemCode'] ?> W<?= $row['itemWidth']?>mm x H<?=$row['itemHeight'] ?>mm</p>
                            <?php if(isset($_SESSION['userId'])): ?>
                              <?php if($_SESSION['userId'] == $row['updatedBy'] OR $_SESSION['accountType'] == 'Admin'):?>
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
                 <?php if(!isset($_SESSION['userId'])): ?>
                 <div class="col-md-12 form-group">
                   <form method="POST" onsubmit="return checkForm(this);" id="commentForm">
                   <div class="col-md-2">
                     <p>Your Name: </p>
                   </div>
                   <div class="col-md-3">
                     <input type="text" class="input form-control" name="yourName" id="yourName" value="<?=isset($_POST['yourName']) ? $_POST['yourName'] : '' ?>" required>
                   </div>
                 </div>

                 <div class="col-md-12 form-group">
                   <div class="col-md-2">
                     <p>Comments: </p>
                   </div>
                   <div class="col-md-10">
                     <textarea rows="8" cols="80" class="input form-control" name="content" id="content" required><?=isset($_POST['content']) ? $_POST['content'] : '' ?></textarea>
                   </div>
                 </div>

                 <div class="col-md-12 form-group">
                   <div class="col-md-2">
                       <p>Captcha:</p>
                   </div>
                   <div class="col-md-2">
                       <input type="text" maxlength="5" name="captcha" id="captcha">
                   </div>
                   <div class="col-md-8">
                      <img src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA">
                  </div>
                  <div class="col-md-4">
                    <?php if(isset($hasError) AND $hasError == true): ?>
                    <div class='p-3 mb-2 bg-danger text-white' id='confirmSuccess'><?= $errorMessage ?></div>
                    <?php endif ?>
                  </div>
                 </div>
                 <div class="col-md-12 form-group">

                   <div class="col-md-2">
                     <input type="submit" class="input form-control btn btn-primary" name="comment" id="comment">
                   </div>
                 </div>
                 </form>
                 <?php endif ?>
               </div>
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
                 <?php if($comments->RowCount() <= 0):?>
                   <h3 class="text-center">No Comment to display</h3>
                 <?php endif ?>
                 <?php while($row = $comments->fetch()): ?>
                 <div class="col-md-12 rounded-sm border border-dark" id="commentSection">
                   <blockquote>
                   <p class="text-left"> <?= $row['name'] ?> </p>
                   <p class="text-left"><i><?= date("F d, Y, g:i a", strtotime($row['dateCreated'])); ?></i></p>
                     <blockquote class="text-left text-justify">
                       <p class="text-left"><?= $row['content']?></p>
                       <div id="edit-form-<?=$row['commentId']?>" style="display:none">
                         <form method="POST" action="commentUpdate.php?id=<?=$_GET['id'] ?>">
                           <textarea rows="8" cols="80" class="input form-control" name="content" id="content" required><?= $row['content'] ?></textarea>
                           <input type="checkbox" class="form-check-input" id="isHidden" name="isHidden">
                           <label class="form-check-label" for="isHidden">Hide this comment</label>
                           <br/>
                           <input type="checkbox" class="form-check-input" id="isDisemvowel" name="isDisemvowel">
                           <label class="form-check-label" for="isDisemvowel">Disemvowel this comment</label>
                           <input type="hidden" id="commentId" name="commentId" value="<?= $row['commentId']?>"/>
                           <br/>
                           <div class="col-md-2">
                             <input type="submit" class="input form-control btn btn-primary" name="updateComment" id="updateComment" value="Update">
                           </div>
                           <div class="col-md-2">
                             <input type="submit" class="input form-control btn btn-primary" name="deleteComment" id="deleteComment" value="Delete" onclick="return confirm('Are you sure you want to delete this item?');">
                           </div>
                         </form>
                      </div>
                     </blockquote>
                    <?php if(isset($_SESSION['accountType']) AND $_SESSION['accountType'] == 'Admin'):?>
                       <p class="auto-style text-right" onclick="openForm(<?=$row['commentId']?>)" id="editBtnComment" style="cursor:pointer"> Edit </p>
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
