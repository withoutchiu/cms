<?php
require('connect.php');
session_start();

if($_POST AND $_POST['updateComment'] AND isset($_POST['content']) AND isset($_POST['commentId'])){

  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
  $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);
  $isHidden = $_POST['isHidden'];

  if($isHidden == true){
    $isHidden = 1;
  }

  if($_POST['isDisemvowel'] == true){
    $content = str_replace(array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'), '', $content);
  }

  $query = "UPDATE comments SET content ='$content', isHidden = '$isHidden'
  WHERE commentId = '$commentId' ";

  $statement = $db->prepare($query);
  $statement->execute();

  header("Location:items.php?id=$_GET[id]#commentSection");

}

if($_POST AND $_POST['deleteComment'] AND isset($_POST['content']) AND isset($_POST['commentId'])){
  $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
  $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_NUMBER_INT);

  $query = "DELETE FROM comments
  WHERE commentId = '$commentId' ";

  $statement = $db->prepare($query);
  $statement->execute();

  header("Location:items.php?id=$_GET[id]#commentSection");

}

 ?>
