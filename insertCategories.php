<?php
require('connect.php');

if($_POST && isset($_POST['categoryTitle']) && isset($_POST['categoryDescription']) && isset($_POST['updatedBy'])){
  $categoryTitle = filter_input(INPUT_POST, 'categoryTitle', FILTER_SANITIZE_STRING);
	$categoryDescription = filter_input(INPUT_POST, 'categoryDescription', FILTER_SANITIZE_STRING);
	$updatedBy = filter_input(INPUT_POST, 'updatedBy', FILTER_SANITIZE_STRING);

  echo "$categoryTitle";
  echo "$categoryDescription";
  echo "$updatedBy";

  $query = "INSERT INTO categories(categoryTitle,categoryDescription,updatedBy)
                          VALUES (:categoryTitle,:categoryDescription,:updatedBy)";
  $statement = $db->prepare($query);
  $statement->bindValue(':categoryTitle', $categoryTitle);
  $statement->bindValue(':categoryDescription', $categoryDescription);
  $statement->bindValue(':updatedBy', $updatedBy);
  $statement->execute();
  header("Location:product.php");
}
?>
