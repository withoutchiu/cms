<?php
require('connect.php');
session_start();

function call(){
  header("Location:index.php");
  exit;
}

include 'php-image-resize-master/lib/ImageResize.php';
use \Gumlet\ImageResize;

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads/items') {
   $current_folder = dirname(__FILE__);

   // Build an array of paths segment names to be joins using OS specific slashes.
   $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];

   // The DIRECTORY_SEPARATOR constant is OS specific.
   return join(DIRECTORY_SEPARATOR, $path_segments);
}
// file_is_allowed() - Checks the mime-type & extension of the uploaded file for "image-ness".
function file_is_allowed($temporary_path, $new_path) {
    //$allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png', 'application/pdf'];
    $allowed_file_extensions = ['jpg', 'jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];
    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    //$mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid;
}



if(isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id']) AND isset($_GET['action']) AND $_GET['action'] == 100){
  if($_POST AND isset($_POST['insert']) AND isset($_POST['itemName']) AND isset($_POST['itemCode']) AND isset($_POST['itemHeight']) AND isset($_POST['itemWidth'])){
    $image_upload_detected = isset($_FILES['itemImage']) && ($_FILES['itemImage']['error'] === 0);
    $upload_error_detected = isset($_FILES['itemImage']) && ($_FILES['itemImage']['error'] > 0);
    $allowed_image_types = ['jpg', 'jpeg', 'png'];
    $imagePathToDb = "";

    echo "<h1>-----" . $image_upload_detected . "----</h1>";
    echo "<h1>-----" . $upload_error_detected . "----</h1>";


    $filteredName = filter_input(INPUT_POST, 'itemName', FILTER_SANITIZE_STRING);
    $filteredCode = filter_input(INPUT_POST, 'itemCode', FILTER_SANITIZE_STRING);
    $filteredWidth = filter_input(INPUT_POST, 'itemWidth', FILTER_SANITIZE_NUMBER_INT);
    $filteredHeight = filter_input(INPUT_POST, 'itemHeight', FILTER_SANITIZE_NUMBER_INT);
    $categoryId = $_GET['id'];
    $userId = $_SESSION['userId'];

    if ($image_upload_detected) {
      echo "<h1>-----" . $image_upload_detected . "----</h1>";

      echo "<h1>-----" . $image_upload_detected . "----</h1>";

      echo "<h1>-----" . $image_upload_detected . "----</h1>";

      echo "<h1>-----" . $image_upload_detected . "----</h1>";

        $image_filename        = $categoryId . '_' . $_FILES['itemImage']['name'];
        $temporary_image_path  = $_FILES['itemImage']['tmp_name'];
        $new_image_path        = file_upload_path($image_filename);
        if (file_is_allowed($temporary_image_path, $new_image_path)) {
            if(move_uploaded_file($temporary_image_path, $new_image_path)){
              echo "<p>Upload Successfully!</p>";
              if(in_array(pathinfo($image_filename, PATHINFO_EXTENSION), $allowed_image_types)){
                $imagelists = [
                                ["name" => "medium",
                                  "size" => "400" ],
                                ["name" => "thumbnail",
                                  "size" => "50"]
                              ];
                foreach ($imagelists as $imagelist) {
                  echo "<p>Successfully created a " . $imagelist['name'] . " image!</p>";
                  $actual_file_extension   = '.' . pathinfo($image_filename, PATHINFO_EXTENSION);
                  $replacedName = str_replace($actual_file_extension,'_' . $imagelist['name'], $new_image_path);
                  $image = new ImageResize($new_image_path);
                  $image->resizeToWidth($imagelist['size']);
                  $image->save($replacedName . $actual_file_extension);

                  $imagePathToDb = "uploads" . DIRECTORY_SEPARATOR . "items" . DIRECTORY_SEPARATOR .$image_filename;

                  echo $imagePathToDb;
                  }
              }
            }else{
              echo "Please try again.";
            }

        }else{
          echo "<h2>File is not allowed. Please try using 'gif', 'jpg', 'jpeg', 'png', 'pdf', 'gif' type only!</h2>";
        }
    }
    $query = "INSERT INTO items(itemName,itemCode,itemWidth, itemHeight, image, categoryId, updatedBy)
                            VALUES (:itemName,:itemCode,:itemWidth,:itemHeight,:image,:categoryId,:updatedBy)";

    $statement = $db->prepare($query);
    $statement->bindValue(':itemName', $filteredName);
    $statement->bindValue(':itemCode', $filteredCode);
    $statement->bindValue(':itemWidth', $filteredWidth, PDO::PARAM_INT);
    $statement->bindValue(':itemHeight', $filteredHeight, PDO::PARAM_INT);
    $statement->bindValue(':image', $imagePathToDb);
    $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    $statement->bindValue(':updatedBy', $userId, PDO::PARAM_INT);
    $statement->execute();

    header("Location:items.php?id=$categoryId");

  }
}else if(isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id']) AND isset($_GET['action']) AND $_GET['action'] == 200){
  $query = "SELECT * FROM items WHERE itemId = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();

  if($_POST AND isset($_POST['update']) AND isset($_POST['itemName']) AND isset($_POST['itemCode']) AND isset($_POST['itemHeight']) AND isset($_POST['itemWidth'])){
    $image_upload_detected = isset($_FILES['itemImage']) && ($_FILES['itemImage']['error'] === 0);
    $upload_error_detected = isset($_FILES['itemImage']) && ($_FILES['itemImage']['error'] > 0);
    $allowed_image_types = ['jpg', 'jpeg', 'png'];
    $imagePathToDb = "";

    echo "<h1>-----" . $image_upload_detected . "----</h1>";
    echo "<h1>-----" . $upload_error_detected . "----</h1>";


    $filteredName = filter_input(INPUT_POST, 'itemName', FILTER_SANITIZE_STRING);
    $filteredCode = filter_input(INPUT_POST, 'itemCode', FILTER_SANITIZE_STRING);
    $filteredWidth = filter_input(INPUT_POST, 'itemWidth', FILTER_SANITIZE_NUMBER_INT);
    $filteredHeight = filter_input(INPUT_POST, 'itemHeight', FILTER_SANITIZE_NUMBER_INT);
    $itemId = $_GET['id'];
    $userId = $_SESSION['userId'];


    if($image_upload_detected != 1){
      echo "<h1>-----items.php?id=". $_POST['itemCategory'] . "----</h1>";
      $q = "UPDATE items SET itemName = '$_POST[itemName]',
                                 itemCode='$_POST[itemCode]',
                                 itemWidth='$_POST[itemWidth]',
                                 itemHeight='$_POST[itemHeight]',
                                 updatedBy='$userId'
                                 WHERE itemId = '$itemId'";
       $state = $db->prepare($q);
       $state->bindValue(':itemName', $filteredName);
       $state->bindValue(':itemCode', $filteredCode);
       $state->bindValue(':itemWidth', $filteredWidth , PDO::PARAM_INT);
       $state->bindValue(':itemHeight', $filteredHeight , PDO::PARAM_INT);
       $state->bindValue(':updatedBy', $userId , PDO::PARAM_INT);
       $state->bindValue(':itemId', $itemId , PDO::PARAM_INT);
       $state->execute();
       header("Location:items.php?id=$_POST[itemCategory]#item$itemId");
   }else{
     $isDeletedMedium = unlink(substr($_POST['imagePrev'],0 , -4) . "_medium" . substr($_POST['imagePrev'], -4));
     $isDeletedThumbnail = unlink(substr($_POST['imagePrev'],0 , -4) . "_thumbnail" . substr($_POST['imagePrev'], -4));
     $isDeleted = unlink($_POST['imagePrev']);
     if($isDeleted AND $isDeletedMedium and $isDeletedThumbnail){
      if ($image_upload_detected) {
        echo "<h1>-----" . $image_upload_detected . "----</h1>";

        echo "<h1>-----" . $image_upload_detected . "----</h1>";

        echo "<h1>-----" . $image_upload_detected . "----</h1>";

        echo "<h1>-----" . $image_upload_detected . "----</h1>";

          $image_filename        = $_POST['itemCategory'] . '_' . $_FILES['itemImage']['name'];
          $temporary_image_path  = $_FILES['itemImage']['tmp_name'];
          $new_image_path        = file_upload_path($image_filename);
          if (file_is_allowed($temporary_image_path, $new_image_path)) {
              if(move_uploaded_file($temporary_image_path, $new_image_path)){
                echo "<p>Upload Successfully!</p>";
                if(in_array(pathinfo($image_filename, PATHINFO_EXTENSION), $allowed_image_types)){
                  $imagelists = [
                                  ["name" => "medium",
                                    "size" => "400" ],
                                  ["name" => "thumbnail",
                                    "size" => "50"]
                                ];
                  foreach ($imagelists as $imagelist) {
                    echo "<p>Successfully created a " . $imagelist['name'] . " image!</p>";
                    $actual_file_extension   = '.' . pathinfo($image_filename, PATHINFO_EXTENSION);
                    $replacedName = str_replace($actual_file_extension,'_' . $imagelist['name'], $new_image_path);
                    $image = new ImageResize($new_image_path);
                    $image->resizeToWidth($imagelist['size']);
                    $image->save($replacedName . $actual_file_extension);

                    $imagePathToDb = "uploads/items/" .$image_filename;

                    echo $imagePathToDb;
                    }
                }
              }else{
                echo "Please try again.";
              }

          }else{
            echo "<h2>File is not allowed. Please try using 'gif', 'jpg', 'jpeg', 'png', 'pdf', 'gif' type only!</h2>";
          }
        }
      }else {
        echo "<h2>ERROR DELETING FILES!</h2>";
      }

      $q = "UPDATE items SET itemName = '$_POST[itemName]',
                                 itemCode='$_POST[itemCode]',
                                 itemWidth='$_POST[itemWidth]',
                                 itemHeight='$_POST[itemHeight]',
                                 image = '$imagePathToDb',
                                 updatedBy='$userId'
                                 WHERE itemId = '$itemId'";
       $state = $db->prepare($q);
       $state->bindValue(':itemName', $filteredName);
       $state->bindValue(':itemCode', $filteredCode);
       $state->bindValue(':itemWidth', $filteredWidth , PDO::PARAM_INT);
       $state->bindValue(':itemHeight', $filteredHeight , PDO::PARAM_INT);
       $state->bindValue(':updatedBy', $userId , PDO::PARAM_INT);
       $state->bindValue(':image', $imagePathToDb);
       $state->bindValue(':itemId', $itemId , PDO::PARAM_INT);
       $state->execute();
       header("Location:items.php?id=$_POST[itemCategory]#item$itemId");

    }
    // $query = "UPDATE items SET itemName = '$_POST[itemName]',
    //                            itemCode='$_POST[itemCode]',
    //                            itemWidth='$_POST[itemWidth]',
    //                            itemHeight='$_POST[itemHeight]',
    //                            image='$_POST[image]',
    //                            categoryId='$_POST[categoryId]',
    //                            updatedBy='$_POST[updatedBy]')
    //                            WHERE itemId = '$_GET[id]'";
    //
    // $statement = $db->prepare($query);
    // $statement->bindValue(':itemName', $filteredName);
    // $statement->bindValue(':itemCode', $filteredCode);
    // $statement->bindValue(':itemWidth', $filteredWidth, PDO::PARAM_INT);
    // $statement->bindValue(':itemHeight', $filteredHeight, PDO::PARAM_INT);
    // $statement->bindValue(':image', $imagePathToDb);
    // $statement->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
    // $statement->bindValue(':updatedBy', $userId, PDO::PARAM_INT);
    // $statement->execute();
  }
}else if(isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id']) AND isset($_GET['action']) AND $_GET['action'] == 300){

}else{
  call();
}

?>


<!DOCTYPE html>
<html lang="" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Adding Items...</title>
    <script src='indexcss/js/itemProcess.js'></script>
  </head>
  <body>
    <?php include('nav.php') ?>
    <div class="container" style="background: white; text-align: center; margin-top:50px;">
                <!-- Page Heading/Breadcrumbs -->
              <div class="row">
                  <div class="col-lg-12">
                      <h1 class="page-header">Item Details</h1>
                   </div>
              </div>
              <!-- /.row -->

              <!-- Deck One -->
              <?php if($_GET['action'] == 100):?>
              <form method="POST" id="insert" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-8">
                        <div class="col-md-12 form-group">
                          <div class="col-md-offset-4 col-md-2">
                            <label class="label label-primary">Name: </label>
                          </div>
                          <div class="col-md-6">
                            <input type="text" class="input form-control" name="itemName" id="itemName" required>
                          </div>
                        </div>

                        <div class="col-md-12 form-group">
                          <div class="col-md-offset-4 col-md-2">
                            <label class="label label-primary">Code: </label>
                          </div>
                          <div class="col-md-6">
                            <input type="text" maxlength="7" pattern="[A-Z]{2}\d{5}" title="AA12345" required class="input form-control" name="itemCode" id="itemCode">
                          </div>
                        </div>

                        <div class="col-md-12 form-group">
                          <div class="col-md-offset-4 col-md-2">
                            <label class="label label-primary">Width: </label>
                          </div>
                          <div class="col-md-6">
                            <input type="number" min="1" max="99" class="input form-control" required value="0" name="itemWidth" id="itemWidth">
                          </div>
                        </div>

                        <div class="col-md-12 form-group">
                          <div class="col-md-offset-4 col-md-2">
                            <label class="label label-primary">Height: </label>
                          </div>
                          <div class="col-md-6">
                            <input type="number" min="1" max="99" required value="0" class="input form-control" name="itemHeight" id="itemHeight">
                          </div>
                        </div>
                        <!-- <p class="auto-style2"> Edit | Delete</p> -->
                        <!-- <label class="auto-style1">Ceiling Panel 140 x 25</label> -->
                    </div>
                    <div class="col-md-4">
                        <div height="40%" width="40%" class="input form-control">
                          <p><input type='file' name='itemImage' id='itemImage' required></p>
                        </div>
                        <img src="" width="200" style="display:none;" />
                    </div>
                </div>
                <!-- /.row -->
                <br/>
                <div class="row">
                    <div class="col-lg-12">
                          <input type="submit" class="btn btn-primay" id="insert" name="insert"/>
                     </div>
                </div>
              </form>
              <?php endif ?>
              <?php if($_GET['action'] == 200): ?>
                <?php while($row = $statement->fetch()): ?>
                <form method="POST" id="update" enctype="multipart/form-data">
                  <div class="row">
                      <div class="col-md-8">
                          <div class="col-md-12 form-group">
                            <div class="col-md-offset-4 col-md-2">
                              <label class="label label-primary">Name: </label>
                            </div>
                            <div class="col-md-6">
                              <input value="<?=$row['itemName'] ?>" type="text" class="input form-control" name="itemName" id="itemName" required>
                            </div>
                          </div>

                          <div class="col-md-12 form-group">
                            <div class="col-md-offset-4 col-md-2">
                              <label class="label label-primary">Code: </label>
                            </div>
                            <div class="col-md-6">
                              <input value="<?=$row['itemCode']?>" type="text" maxlength="7" pattern="[A-Z]{2}\d{5}" title="AA12345" required class="input form-control" name="itemCode" id="itemCode">
                            </div>
                          </div>

                          <div class="col-md-12 form-group">
                            <div class="col-md-offset-4 col-md-2">
                              <label class="label label-primary">Width: </label>
                            </div>
                            <div class="col-md-6">
                              <input value="<?=$row['itemWidth'] ?>" type="number" min="1" max="99" class="input form-control" required name="itemWidth" id="itemWidth">
                            </div>
                          </div>

                          <div class="col-md-12 form-group">
                            <div class="col-md-offset-4 col-md-2">
                              <label class="label label-primary">Height: </label>
                            </div>
                            <div class="col-md-6">
                              <input value="<?=$row['itemHeight'] ?>" type="number" min="1" max="99" required class="input form-control" name="itemHeight" id="itemHeight">
                            </div>
                          </div>
                          <!-- <p class="auto-style2"> Edit | Delete</p> -->
                          <!-- <label class="auto-style1">Ceiling Panel 140 x 25</label> -->
                      </div>
                      <div class="col-md-4">
                          <div height="40%" width="40%" class="input form-control">
                            <p><input type='file' name='itemImage' id='itemImage'></p>
                          </div>
                          <img src="<?= $row['image'] ?>" width="200" style="display:block;" />
                      </div>
                  </div>
                  <!-- /.row -->
                  <br/>
                  <div class="row">
                      <div class="col-lg-12">
                            <input value="<?=$row['categoryId'] ?>" type="hidden" class="input form-control" name="itemCategory" id="itemCategory">
                            <input value="<?=$row['image'] ?>" type="hidden" class="input form-control" name="imagePrev" id="imagePrev">
                            <input type="submit" class="btn btn-primay" id="update" name="update"/>
                       </div>
                  </div>
                </form>
                <?php endwhile ?>
              <?php endif ?>
              <hr>
              <br>
              <div class="row text-center">
                  <div class="col-lg-12">
                  </div>
              </div>
      </div>
      <?php include('footer.php') ?>
  </body>
</html>
