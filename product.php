<?php
require('connect.php');


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
                  <h1 class="page-header">Products.</h1>
                  <h4>If admin => Click here to add product</h4>
            </div>
          </div>
        <!-- /.row -->

        <!-- Projects Row -->

        <div class="row">
            <div class="col-md-4 img-portfolio">
                <a href="Assets/img/Category/ceiling.jpg" data-lightbox="product-1">
                    <img class="img-responsive img-hover" src="Assets/img/Category/ceiling.jpg" data-lightbox="product-1">
                </a>
                <h3>
                    <a href= productCeiling.html>Ceiling</a>
                    <a id="updateCategoriesBtn">if admin => Update</a>
                </h3>
                <p class="auto-style7">With BioWood's range of durable ceiling products, you may now stylise your home or building to compliment and enhance the interior and exterior appearance.</p>
            </div>

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
            </div>

        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">

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
        </div>

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
