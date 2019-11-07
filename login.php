<?php
require('connect.php');

if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

define('ADMIN_LOGIN','admin');
define('ADMIN_PASSWORD','admin');


$query = "SELECT * FROM Users";
$statement = $db->prepare($query);
$statement->execute();

if($statement-> rowCount() == 0){
  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])
  || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)
  || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD))
  {
  	header('HTTP/1.1 401 Unauthorized - No user account registered!');
  	header('WWW-Authenticate: Basic realm="Web Content Management System"');
  	exit("Access Denied: Username and password required.");
  }else{
    header("Location:adminRegister.php");
  }
}
$errorMessage = "1";
if($_POST && isset($_POST['emailAddress']) && isset($_POST["password"])){
  $emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $query = "SELECT * FROM users WHERE username = '$emailAddress'";
  $statement = $db->prepare($query);
  $statement->execute();
  if($statement->RowCount() >= 1){
    while($row = $statement->fetch()){
      if($row['username'] == $emailAddress){
        if (password_verify($password, $row['password'])) {
            $_SESSION['userId'] = $row['userId'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['lastName'] = $row['lastName'];
            $_SESSION['firstName'] = $row['firstName'];
            $_SESSION['accountType'] = $row['accountType'];
            header("Location:index.php");
        } else {
          $errorMessage = "Incorrect Password";
        }
      }
    }
  }else{
    $errorMessage = "Account does not exist.";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Content Management System</title>
    <link rel="stylesheet" href="Assets/css/myStyle.css">
    <script src='indexcss/js/login.js'></script>
</head>
  <body style="background-image:url('Assets/img/wood_pattern.jpg'); background-attachment:fixed">
    <?php include('nav.php') ?>
    <div class="container top-space-2 margin-top-2">
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <h1 class="col-md-5">Login Form</h1>
          <div class="account-wall">
              <form class="form-signin" method="post">
                <div class="input-group col-lg-10">
                  <p><input type="text" placeholder="Username" required="required" autofocus="autofocus" class="regput form-control" name="emailAddress" id="emailAddress"></p>
                </div>
                <br/>
                <div class="input-group col-lg-10">
                <p><input type="password" placeholder="Password" class="regput form-control" name="password" id="password"></p>
                <?php if(strlen($errorMessage) >= 2): ?>
                <div class='p-3 mb-2 bg-danger text-white' id='confirmError'><?= $errorMessage ?></div>
                <?php endif ?>
                </div>
                <br/>
                <div class="col-md-12">
                  <input type="submit" class="btn btn-primary col-md-3"/>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <?php include('footer.php') ?>

  </body>
</html>
