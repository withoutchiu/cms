<?php

if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}
$accountType = "";
$username = "";
$lastName = "";
$firstName = "";

if(isset($_SESSION['accountType']) && !empty($_SESSION['accountType'])) {
  $accountType = $_SESSION['accountType'];
}
if(isset($_SESSION['username']) && !empty($_SESSION['username'])) {
  $username = $_SESSION['username'];
}

if(isset($_SESSION['lastName']) && !empty($_SESSION['lastName'])) {
  $lastName = $_SESSION['lastName'];
}

if(isset($_SESSION['firstName']) && !empty($_SESSION['firstName'])) {
  $firstName = $_SESSION['firstName'];
}


 ?>
<link rel="stylesheet" type="text/css" href="indexcss/css/page.css">
<link rel="stylesheet" href="indexcss/css/topnavdesign.css">
<link href="Assets/css/lightbox.css" rel="stylesheet">

<link href="Assets/bootstrap.min.css" rel="stylesheet">
<link href="Assets/css/modern-business.css" rel="stylesheet">
<link href="Assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<link href='indexcss/css/bgndGallery.css' rel='stylesheet' type='text/css'>
<link href='indexcss/css/myStyle.css' rel='stylesheet' type='text/css'>
<script src="Assets/js/jquery-1.11.0.min.js"></script>
<script src="Assets/js/lightbox.min.js"></script>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" style="opacity:0.9; margin-bottom: 20px;">
<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <!--<a href="../index.jsp"></a>-->
      </button>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
     <ul class="nav navbar-nav navbar-left">
          <li>
              <a href="index.php">Home</a>
          </li>
          <li>
              <a href="product.php">Products</a>
          </li>
          <li>
              <a href="">About</a>
          </li>
          <li>
              <a href="">Contact Us</a>
          </li>
          <?php if(!(isset($_SESSION['userId']))): ?>
            <li>
                <a href="register.php">Register User</a>
            </li>
          <?php endif ?>
          <?php if(isset($_SESSION['userId'])): ?>
            <li>
                <a><p style="color:white">Welcome back, <?= $firstName ?> <?= $lastName ?>.</p></a>
            </li>
          <?php endif ?>
          </ul>
       <ul class="nav navbar-nav navbar-right">
       <!-- <li>
           <a href= register.php>Add Page</a>
       </li> -->
       <?php if(isset($_SESSION['accountType']) AND $_SESSION['accountType'] == 'Admin'): ?>
         <li>
           <a href="">Manage Users Account</a>
         </li>
       <?php endif ?>
       <li>
          <?php if(isset($_SESSION['userId'])): ?>
           <a href="logout.php">logout</a>
          <?php else: ?>
           <a href="login.php">Login</a>
         <?php endif ?>
       </li>
       </ul>
  </div>
  <!-- /.navbar-collapse -->
</div>
<!-- /.container -->
</nav>
