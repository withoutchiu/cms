<?php


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Web Content Management System</title>
    <?php include('nav.php') ?>
  </head>
  <body  style="background-image:url('Assets/img/bg.jpg'); background-attachment:fixed">

  <header id="myCarousel" class="carousel slide">
       <!-- Indicators -->
  <ol class="carousel-indicators">
     <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
     <li data-target="#myCarousel" data-slide-to="1"></li>
     <li data-target="#myCarousel" data-slide-to="2"></li>
     <li data-target="#myCarousel" data-slide-to="3"></li>
  </ol>

   <!-- Wrapper for slides -->
   <div class="carousel-inner">
       <div class="item active">
           <div class="fill" style="background-image:url('Assets/img/elements/8.jpg');">
           </div>
           <div class="carousel-caption" style="background-color: rgba(0, 0, 0, 0.5); font-size:medium">
             Maintain the natural timber look
             Biowood Wood-Plastic Composite architectural products are a sustainable timber alternative with added benefits such as durability and strength.
             Best of all, our products are low maintenance and environmentally friendly meaning that you spend less time worrying about them and more time enjoying the benefits of our projects.
           </div>
       </div>

       <div class="item">
           <div class="fill" style="background-image:url('Assets/img/elements/3.jpg');">
           </div>
           <div class="carousel-caption" style="background-color: rgba(0, 0, 0, 0.5);font-size:medium">
             Biowood Composite Wood
             Wood-Plastic Composite architectural products. Decking, flooring, fencing, wall panel, ceiling, sunshading, screening, industrial special services and more.
           </div>
       </div>

       <div class="item">
           <div class="fill" style="background-image:url('Assets/img/elements/6.jpg');">
           </div>
           <div class="carousel-caption" style="background-color: rgba(0, 0, 0, 0.5); font-size:medium">
             BioWood specializes in providing construction solutions for building systems and the DIY market. BioWood products are easy to install and maintain.
             They have consistent quality and finish, and require no sanding, priming or sealing. BioWood is favorable to be used for interiors or exteriors for any kind of residential or commercial project.
           </div>
       </div>

       <div class="item">
           <div class="fill" style="background-image:url('Assets/img/elements/5.jpg'); background-repeat:no-repeat;">
           </div>
           <div class="carousel-caption" style="background-color: rgba(0, 0, 0, 0.5); font-size:medium">
             BioWood products have the look and feel of natural timber, from the color to the grain. They behave like wood and can be shaped with conventional woodworking methods.
             It comes in different colors and uses innovative fastening systems.
           </div>
       </div>
     </div>

       <!-- Controls -->
       <a class="left carousel-control" href="#myCarousel" data-slide="prev">
           <span class="icon-prev"></span>
       </a>
       <a class="right carousel-control" href="#myCarousel" data-slide="next">
           <span class="icon-next"></span>
       </a>
   </header>

   <div class="test" style="position:static">
      <form style="text-align:center; width: 94%; height:130%; margin-left:3%; margin-bottom:2%; margin-top:5%" class="auto-style1">
        <div style="height:80%; width:98%;" class="auto-style4">
        <br>
        <h4 class="auto-style2"><img src= "Assets/img/csi.jpg" width="10%" height="10%"><br>
          <b>Creative And Solutions <br>Innovations, Phil., Inc. </b>
              </h4>
                <em>
                  <strong><br>
                  </strong>
                </em>
              <span class="auto-style2">
                <strong>If you are looking for an architectural reconstituted composite wood building solution that is not only beautiful to look at, timber alternative, but also robust, versatile and designed to withstand the harsh Australian and International climate conditions, then look no further than our very own Biowood brand architectural reconstituted composite wood.
                We have an extensive range of environmentally friendly reconstituted composite wood building products that are ideal for residential or commercial use and can provide you with innovative solutions for all your architectural wood needs such as decking, privacy screening, flooring, wall paneling, soffits, ceiling, cladding, facades, street furniture and louver application.
                Feel free to browse around and take the time to learn more about us and discover what we have to offer our customers.	<br><br>

                        Going green has never looked better!
                BioWood Composite Wood is wood engineered to near perfection. BioWood enhances our living environment. It is a superior timber alternative that is elegant, natural, and renewable.
                Its composition helps reduce carbon footprint with its stored carbon and low embodied energy, resulting in a sustainable and resource-efficient product that benefits both customers and the environment.
                Biowood adds the best value to your investment. Not only are you choosing a high quality wood substitute, you are also keeping the world greener.
                And going green has never looked better!
                  <br>
                </strong>
              </span>
      </div>
     </form>
    </div>
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>
    <?php include('footer.php') ?>
  </body>
</html>
