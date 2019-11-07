<?php
require('connect.php');
session_Start();
//ORDER BY Date DESC LIMIT 5
$titlePage = "Products";
$accountType = "";
$userId = "";
if(!isset($_GET['sortBy'])){
  $query = "SELECT * FROM categories";
  $statement = $db->prepare($query);
  $statement->execute();
}
if(isset($_GET['sortBy']) AND $_GET['sortBy'] == "Title"){
  $query = "SELECT * FROM categories ORDER BY CategoryTitle";
  $statement = $db->prepare($query);
  $statement->execute();
  $titlePage = "Products by Title";
}
if(isset($_GET['sortBy']) AND $_GET['sortBy'] == "Update"){
  $query = "SELECT * FROM categories ORDER BY updatedDate DESC";
  $statement = $db->prepare($query);
  $statement->execute();
  $titlePage = "Products by Latest Update";
}
if(isset($_GET['sortBy']) AND $_GET['sortBy'] == "Create"){
  $query = "SELECT * FROM categories ORDER BY createdDate";
  $statement = $db->prepare($query);
  $statement->execute();
  $titlePage = "Products by Created Date";
}

if(isset($_SESSION['userId'])){
  $accountType = $_SESSION['accountType'];
  $userId = $_SESSION['userId'];
}
// if(isset($_GET['sortBy']) == "discussed"){
//   $query = "SELECT * FROM categorie ORDER BY CategoryTitle";
//   $statement = $db->prepare($query);
//   $statement->execute();
// }
?>
﻿<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Content Management System</title>
    <link rel="stylesheet" type="text/css" href="indexcss/css/myStyle.css">
</head>
<body style="background-image:url('Assets/img/bg.jpg'); background-attachment:fixed">
  <?php include('nav.php') ?>
    <br>
    <!-- Page Content -->
    <div class="test">
		<form style="text-align:center; width: 94%; height:130%; margin-left:3%; margin-bottom:2%; margin-top:5%" class="auto-style1">

    <div class="container">

	<div class="test" style="position:static">
		<form style="text-align:center; margin-left:23%; bottom:10%; width: 58%; height:70%;" class="auto-style1">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                  <?php if($_GET) ?>
                  <h1 class="page-header"><?=$titlePage ?></h1>
                  <?php if(isset($_SESSION['userId'])): ?>
                    <h4><a href="categories.php?action=insert">Click here to add product</a></h4>
                  <?php endif ?>
            </div>
          </div>
        <!-- /.row -->

        <!-- Projects Row -->

        <div class="row">
          <?php if($statement->rowCount() == 0): ?>
            <h2>No categories yet.</h2>
          <?php  else: ?>
            <?php if(isset($_SESSION['userId'])): ?>
                <div class="col-md-offset-4 col-md-4 img-portfolio">
                  <form method="GET">
                      <div class="col-md-8">
                        <select class="form-control" id="sortBy" name="sortBy">
                          <option>Sort By...</option>
                          <option value="Title">Sort by Title</option>
                          <option value="Update">Sort by latest Update</option>
                          <option value="Create">Sort by Created Update</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <input type="submit" value="Search" class="btn btn-primary">
                      </div>
                  </form>
                </div>
              </div>
            <?php endif ?>
            <?php while($row = $statement->fetch()): ?>
            <div class="col-md-4 img-portfolio">
                <a href="<?=$row['categoryImage']?>" data-lightbox="product-1">
                    <img class="img-responsive img-hover img-thumbnail img-smaller" src="<?=substr($row['categoryImage'],0, -4) . "_medium" . substr($row['categoryImage'], -4)?>" data-lightbox="product-1" >
                </a>
                <h3>
                    <a href=""><?=$row['categoryTitle'] ?></a>
                  <?php if($accountType == 'Admin' OR $userId == $row['updatedBy']): ?>
                    <a href="categories.php?action=update&id=<?=$row['categoryId']?>" class="btn btn-primary" id="">Update</a>
                  <?php endif ?>
                </h3>
                <p class="auto-style7"><?=$row['categoryDescription']?></p>
            </div>
            <?php endwhile ?>
          <?php endif ?>

            <!--
            <div class="col-md-4 img-portfolio">
                <a href="img/Category/deck.jpg" data-lightbox="product-1">
                    <img class="img-responsive img-hover" src="Assets/img/Category/deck.jpg" >
                </a>
                <h3>
                    <a href="productDecking.html">Decking</a>
                </h3>
                <p class="auto-style7">Durable, sleek, easy to install, and low maintenance. BioWood Decking is the ideal product for indoor and outdoor use, as it is made to withstand the elements of nature.</p>
            </div>

            <div class="col-md-4 img-portfolio">
                <a href="img/Category/door.jpg" data-lightbox="product-1">
                    <img class="img-responsive img-hover" src="Assets/img/Category/door.jpg" >
                </a>
                <h3>
                    <a href="productDoorProfile.html">Door Profile</a>
                </h3>
                <p class="auto-style7">Smooth, aesthetically pleasing design and finish. BioWood door profiles and frames have an integrated architrave with fine curved edges and a finish that enhances their overall appeal.</p>
            </div>-->

        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <!--<div class="row">

                   <div class="col-md-4 img-portfolio">
                <a href="img/Category/facade.jpg" data-lightbox="product-1">
                    <img class="img-responsive img-hover" src="Assets/img/Category/facade.jpg" >
                </a>
                <h3>
                    <a href="productFaçadeScreen.html">Façade Screen</a>
                </h3>
                <p class="auto-style7">Low maintenance, sleek appearance, easy installation. BioWood façade screens are intelligent additions to any building for style and protection.</p>
            </div>

            <div class="col-md-4 img-portfolio">
                <a href="img/Category/finishacc.jpg" data-lightbox="product-1">
                    <img class="img-responsive img-hover" src="Assets/img/Category/finishacc.jpg" >
                </a>
                <h3>
                    <a href="productFinishingAcc.html">Finishing Accessories</a>
                </h3>
                <p class="auto-style7">BioWood decorative Finishing Accessories may be used for decking, flooring, cladding, or ceiling applications.</p>
            </div>

            <div class="col-md-4 img-portfolio">
                <a href="img/Category/halflogs.jpg" data-lightbox="product-1">
                    <img class="img-responsive img-hover" src="Assets/img/Category/halflogs.jpg" >
                </a>
                <h3>
                    <a href="productHalfLogs.html">Half Logs</a>
                </h3>
                <p class="auto-style7">Simply rugged, lightweight, and durable. BioWood Half Log profiles provide a tasteful country facade look.</p>
            </div>
        </div>-->

        <!-- Projects Row -->

        <!-- Pagination -->
        <div class="row text-center">
            <div class="col-lg-12" style="left: 0px; top: 0px">
                <ul class="pagination">
                    <li>
                        <a href="product1.html">&laquo;</a>
                    </li>
                    <li class="active">
                       <a href="product1.html">1</a>
                    </li>
                    <li>
                        <a href="product2.html">2</a>
                    </li>
                    <li>
                        <a href="product3.html">3</a>
                    </li>
                    <li>
                        <a href="product3.html">&raquo;</a>
                    </li>
                </ul>
            </div>
        <!-- /.row -->
        <!-- Footer -->
            <div class="row text-center">
                <div class="col-lg-12">
                </div>
            </div>
       </div>
     </form>
    </div>
  </div>
</form>
<?php include('footer.php') ?>

</div>
</body>
</html>
