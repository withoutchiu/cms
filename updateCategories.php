<?php
require('connect.php');


$query = "SELECT * FROM categories WHERE categoryId = '$_GET[id]'";
$statement = $db->prepare($query);
$statement->execute();

if(isset($_POST['update']))
{
	$categoryTitle = filter_input(INPUT_POST, 'categoryTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$categoryDescription = filter_input(INPUT_POST, 'categoryDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$updatedBy = filter_input(INPUT_POST, 'updatedBy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	if((strlen($categoryTitle) > 0) && (strlen($categoryDescription) > 0))
	{
		$query = "UPDATE categories SET categoryTitle ='$_POST[categoryTitle]', content = '$_POST[categoryDescription]'
		WHERE id = '$_GET[id]' ";

		$statement = $db->prepare($query);
		$statement->bindValue(':categoryTitle', $categoryTitle);
		$statement->bindValue(':categoryDescription', $categoryDescription);
		$statement->bindValue(':updatedBy', $updatedBy);

		$statement->execute();

		header("Location:index.php");
	}
	else
	{
		header("Location:product.php");
	}
}


if(isset($_POST['delete']))
{
  $categoryTitle = filter_input(INPUT_POST, 'categoryTitle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$categoryDescription = filter_input(INPUT_POST, 'categoryDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$updatedBy = filter_input(INPUT_POST, 'updatedBy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$query = "DELETE FROM categories WHERE id = '$_GET[id]'";
	$statement = $db->prepare($query);
	$statement->bindValue(':categoryTitle', $categoryTitle);
	$statement->bindValue(':categoryDescription', $categoryDescription);
	$statement->bindValue(':updatedBy', $updatedBy);

	$statement->execute();

	header("Location:product.php");
}

function call()
{
	header("Location:index.php");
	exit;
}

if(!isset($_GET['id']) ||   ($_GET['id']) < 1 || (!is_numeric($_GET['id'])))
{
	call();
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php include('nav.php') ?>
    <div>
      <?php while($row = $statement->fetch()): ?>
        <form method="post">
          <h2>Category Title</h2>
          <INPUT value= '<?= $row['categoryTitle']?>' id='categoryTitle' name='categoryTitle'>
          <h2>Category Description</h2>
          <textarea name='categoryDescription' COLS='90' ROWS='10'><?= $row['categoryDescription']?></textarea>
          <input type="text" name="updatedBy" id="updatedBy" value="<?=$_SESSION['firstName']?> <?=$_SESSION['lastName']?>">
          <INPUT id='update' type='submit' name='update' value='update'>
          <INPUT id='submit' name='delete' type='submit' value='delete'>
        </form>
      <?php endwhile ?>
    </div>

  </body>
</html>
