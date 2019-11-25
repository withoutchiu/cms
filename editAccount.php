<?php
require('connect.php');
session_start();

if(isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id'])){
  $query = "SELECT * FROM users WHERE userId = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();

}
if($_POST && $_POST['submit'] && isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['username']) && isset($_POST['accountType']) AND
  isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id'])){
  $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
  $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
  $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
  $accountType = filter_input(INPUT_POST, 'accountType', FILTER_SANITIZE_STRING);

  $query = "UPDATE users SET firstName ='$firstName', lastName = '$lastName', username = '$username', accountType = '$accountType'
  WHERE userId = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();

  header("Location:accounts.php");
}else{
$hasError = true;
}
if($_POST AND $_POST['delete'] AND isset($_GET['id']) AND $_GET['id'] >= 1 AND is_numeric($_GET['id'])){
  $query = "DELETE FROM users WHERE userID = '$_GET[id]'";
  $statement = $db->prepare($query);
  $statement->execute();
  header("Location:accounts.php");
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
     <br><br>
     <?php while($row = $statement -> fetch()): ?>
     <form method="POST">
       <?php if(!isset($hasError)): ?>
         <h3>something went wrong please try again.</h3>
       <?php endif ?>
       <p>First Name: </p>
       <input type="text" value="<?=$row['firstName']?>"  id="firstName" name="firstName" >
       <p>Last Name: </p>
       <input type="text" value="<?=$row['lastName']?>"  id="lastName" name="lastName" >
       <p>User Name: </p>
       <input type="text" value="<?=$row['username']?>"  id="username" name="username" >
       <p>Account Type: </p>
       <?php if($row['accountType'] == "Non-Admin"): ?>
       <select  name="accountType"  id="" name="accountType" >
          <option value="Non-Admin" selected>Non-Admin</option>
          <option value="Admin">Admin</option>
       </select>
       <?php else: ?>
       <select  name="accountType"  id="" name="accountType" >
          <option value="Non-Admin">Non-Admin</option>
          <option value="Admin" selected>Admin</option>
       </select>
       <?php endif ?>
       <hr>
       <input type="submit" name="submit" value="Update User">
       <input type="submit" name="delete" value="Delete User" onclick="return confirm('Deleting this user deletes the record. Are you sure you want to delete this item?');">

     </form>
     <?php endwhile ?>
     <p><a href="accounts.php"> Go Back </a></p>
     <?php include('footer.php') ?>
   </body>
 </html>
