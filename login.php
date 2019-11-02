 <!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Content Management System</title>
    <?php include('nav.php') ?>
</head>
  <body style="background-image:url('Assets/img/wood_pattern.jpg'); background-attachment:fixed">
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4" style="left: -93px; top: 0px; width: 600px; height:; opacity:.8">
          <h1 class="text-center login-title">Login Form</h1>
          <div class="account-wall">
              <form class="form-signin" action="login.html" method="post">
                <div class="input-group col-lg-offset-0">
                  <p> <label>Username: </label> <input type="text" placeholder="Username" required="required" autofocus="autofocus" class="regput form-control" name="emailAddress"></p>
                </div>
                <div class="input-group col-lg-offset-0">
                <p> <label>Password: </label> <input type="password" placeholder="Password" class="regput form-control" name="password" onpaste="return false;"></p>
                </div>
                <div class="col-lg-offset-3">
                  <input type="submit" value="Login" style="text-align:center; height:3em; width:8em; background-color:rgba(164, 107, 34, 0.5);" class="btn btn-info">
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
