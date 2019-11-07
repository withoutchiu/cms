<?php
require('connect.php');

$action = "none";

function call()
{
  header("Location:index.php");
  exit;
}

if(isset($_GET['action']) AND $_GET['action'] == "insert"){
  $action = "insert";
}elseif(isset($_GET['action']) AND $_GET['action'] == "update" AND isset($_GET['id']) AND ($_GET['id']) > 1 AND is_numeric($_GET['id'])){
  $action = "update";

  $qry = "SELECT * FROM categories WHERE categoryId = '$_GET[id]'";
  $stmt = $db->prepare($qry);
  $stmt->execute();

}else{
  call();
}

include 'php-image-resize-master/lib/ImageResize.php';
use \Gumlet\ImageResize;

function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
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



if($_POST && isset($_POST['insert']) && isset($_POST['categoryTitle']) && isset($_POST['categoryDescription']) && isset($_POST['updatedBy'])){
  $image_upload_detected = isset($_FILES['categoryImage']) && ($_FILES['categoryImage']['error'] === 0);
  $upload_error_detected = isset($_FILES['categoryImage']) && ($_FILES['categoryImage']['error'] > 0);
  $allowed_image_types = ['jpg', 'jpeg', 'png'];
  $imagePathToDb = "";

  $categoryTitle = filter_input(INPUT_POST, 'categoryTitle', FILTER_SANITIZE_STRING);
	$categoryDescription = filter_input(INPUT_POST, 'categoryDescription', FILTER_SANITIZE_STRING);
	$updatedBy = filter_input(INPUT_POST, 'updatedBy', FILTER_SANITIZE_STRING);

  $query = "INSERT INTO categories(categoryTitle,categoryDescription,categoryImage,updatedBy)
                          VALUES (:categoryTitle,:categoryDescription,:categoryImage,:updatedBy)";

  $statement = $db->prepare($query);
  $statement->bindValue(':categoryTitle', $categoryTitle);
  $statement->bindValue(':categoryDescription', $categoryDescription);
  $statement->bindValue(':updatedBy', $updatedBy);

  echo "<h1>test</h1>";

  if ($image_upload_detected) {
      $image_filename        = $categoryTitle . '_' . $_FILES['categoryImage']['name'];
      $temporary_image_path  = $_FILES['categoryImage']['tmp_name'];
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

                $imagePathToDb = "uploads" . DIRECTORY_SEPARATOR . $image_filename;

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
  $statement->bindValue(':categoryImage', $imagePathToDb);
  $statement->execute();

  header("Location:product.php");
}

if($_POST && isset($_POST['update']) && isset($_POST['categoryTitle']) && isset($_POST['categoryDescription']) && isset($_POST['categoryId'])){
  $categoryTitle = filter_input(INPUT_POST, 'categoryTitle', FILTER_SANITIZE_STRING);
  $categoryDescription = filter_input(INPUT_POST, 'categoryDescription', FILTER_SANITIZE_STRING);
  $categoryId = filter_input(INPUT_POST, 'categoryId', FILTER_SANITIZE_NUMBER_INT);

  $image_upload_detected = isset($_FILES['categoryImage1']) && ($_FILES['categoryImage1']['error'] === 0);
  $upload_error_detected = isset($_FILES['categoryImage1']) && ($_FILES['categoryImage1']['error'] > 0);
  $allowed_image_types = ['jpg', 'jpeg', 'png'];
  $imagePathToDb = "";

  echo "<h1> Test --- "  . $image_upload_detected . "</h1>";

  echo "<h1> Test2--- " . $_POST['categoryImagePrev'] . "</h1>";

  echo "<h1> Test23--- " . $categoryTitle . "</h1>";


  if($image_upload_detected != 1){
  $query = "UPDATE categories SET categoryTitle ='$_POST[categoryTitle]', categoryDescription = '$_POST[categoryDescription]'
  WHERE categoryId = '$_GET[id]' ";

  $statement = $db->prepare($query);
  $statement->bindValue(':categoryTitle', $categoryTitle);
  $statement->bindValue(':categoryDescription', $categoryDescription);
  $statement->bindValue(':categoryId', $categoryId , PDO::PARAM_INT);

  $statement->execute();

  header("Location:product.php");
}else{
    echo "<h1>image upload</h1>";
    $isDeletedMedium = unlink(substr($_POST['categoryImagePrev'],0 , -4) . "_medium" . substr($_POST['categoryImagePrev'], -4));
    $isDeletedThumbnail = unlink(substr($_POST['categoryImagePrev'],0 , -4) . "_thumbnail" . substr($_POST['categoryImagePrev'], -4));
    $isDeleted = unlink($_POST['categoryImagePrev']);

    if($isDeleted AND $isDeletedMedium and $isDeletedThumbnail){
      //echo "<h1> Test2--- " . $_POST['categoryImage1'] . "</h1>";

      if ($image_upload_detected) {
          $image_filename        = $categoryTitle . '_' . $_FILES['categoryImage1']['name'];
          $temporary_image_path  = $_FILES['categoryImage1']['tmp_name'];
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

                    $imagePathToDb = "uploads/" . $image_filename;

                    echo '123123123123---' . $imagePathToDb;
                    }
                }
              }else{
                echo "Please try again.";
              }

          }else{
            echo "<h2>File is not allowed. Please try using 'gif', 'jpg', 'jpeg', 'png', 'pdf', 'gif' type only!</h2>";
          }
      }
      $query = "UPDATE categories SET categoryTitle ='$_POST[categoryTitle]', categoryDescription = '$_POST[categoryDescription]', categoryImage = '$imagePathToDb'
      WHERE categoryId = '$_GET[id]' ";

      $statement = $db->prepare($query);
      $statement->bindValue(':categoryTitle', $categoryTitle);
      $statement->bindValue(':categoryDescription', $categoryDescription);
      $statement->bindValue(':categoryImage', $imagePathToDb);
      $statement->bindValue(':categoryId', $categoryId , PDO::PARAM_INT);

      $statement->execute();

    }
    header("Location:product.php");
  }
}

if($_POST && isset($_POST['delete'])){
  $query = "DELETE FROM categories WHERE categoryId = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();
  header("Location:product.php");

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
       <form method="POST" enctype="multipart/form-data">
         <p>Category Title: <input type="text" name="categoryTitle" id="categoryTitle" required/></p>
         <p>Category Description: <input type="text" name="categoryDescription" id="categoryDescription" required/></p>
         <p><label for='image'>Image Filename:</label></p>
         <p><input type='file' name='categoryImage' id='categoryImage' required></p>
         <input type="text" name="updatedBy" id="updatedBy" value="<?=$_SESSION['userId']?>" style="display:none" required/>
         <p><input type="submit" name='insert' type='insert' value="Insert Category"></p>
      </form>
     <?php endif ?>

     <?php if($action == "update"): ?>
       <?php while($row = $stmt->fetch()): ?>
         <h1>update</h1>
         <form method="POST" enctype="multipart/form-data">
           <p>Category Title: <input type="text" name="categoryTitle" id="categoryTitle" value= '<?= $row['categoryTitle']?>'/></p>
           <p>Category Description: <input type="text" name="categoryDescription" id="categoryDescription" value= '<?= $row['categoryDescription']?>'/></p>
           <p><label for='image'>Image Filename:</label></p>
           <p><input type='file' name='categoryImage1' id='categoryImage1'></p>
           <p><input type='text' name='categoryImagePrev' id='categoryImagePrev' value="<?=$row['categoryImage']?>"></p>
           <input type="text" name="categoryId" id="categoryId" value= '<?= $row['categoryId']?>' style="display:none"/>
           <p><input type="submit"  name='update' type='update' value="Update this Category" class="btn btn-primary"></p>
           <p><input type="submit"  name='delete' type='delete' value="Delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this item?');"></p>
         </form>
       <?php endwhile ?>
     <?php endif ?>
   </body>
 </html>
