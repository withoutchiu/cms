<?php
require('connect.php');
$errorMessage = "1";
if($_POST && isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['emailAddress'])){
  $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
	$lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
	$emailAddress = filter_input(INPUT_POST, 'emailAddress', FILTER_VALIDATE_EMAIL);
  $type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);
  $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $passwordConfirm = filter_input(INPUT_POST, 'password_confirmation', FILTER_SANITIZE_STRING);
  // Validate password strength
  $uppercase = preg_match('@[A-Z]@', $password);
  $lowercase = preg_match('@[a-z]@', $password);
  $number    = preg_match('@[0-9]@', $password);
  $specialChars = preg_match('@[^\w]@', $password);

  echo $firstName;
  echo $lastName;
  echo $emailAddress;
  echo $type;
  echo $password;
  if((strlen($firstName) > 0) && (strlen($lastName) > 0) && (strlen($emailAddress) > 0)){
    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $errorMessage = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        echo $errorMessage;
    }else{
      if($password == $passwordConfirm){
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $query = "INSERT INTO users(firstName, lastName, username, password, accountType)
                              VALUES (:firstName, :lastName, :username, :password, :accountType)";
          $statement = $db->prepare($query);
          $statement->bindValue(':firstName', $firstName);
          $statement->bindValue(':lastName', $lastName);
          $statement->bindValue(':username', $emailAddress);
          $statement->bindValue(':password', $hashed_password);
          $statement->bindValue(':accountType', $type);
          $statement->execute();
          header("Location:index.php");
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <title>Register Page</title>
    <!-- Bootstrap Core CSS -->
    <link href='Assets/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link href='Assets/css/modern-business.css' rel='stylesheet'>
    <!-- Custom Fonts -->
    <link href='Assets/font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
    <script src='indexcss/js/adminRegister.js'></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src='WebsiteContent/Categories/html5shiv.js'></script>
        <script src='WebsiteContent/Categories/respond.min.js'></script>
    <![endif]-->
    <style>
      /* The message box is shown when the user clicks on the password field */
      #message {
        display:none;
        background: #f1f1f1;
        color: #000;
        position: relative;
        padding: 20px;
        margin-top: 10px;
      }

      #message p {
        padding: 10px 35px;
        font-size: 18px;
      }

      /* Add a green text color and a checkmark when the requirements are right */
      .valid {
        color: green;
      }

      .valid:before {
        position: relative;
        left: -35px;
        content: "✔";
      }

      /* Add a red text color and an "x" when the requirements are wrong */
      .invalid {
        color: red;
      }

      .invalid:before {
        position: relative;
        left: -35px;
        content: "✖";
      }
    </style>
</head>
<body>
    <?php include('nav.php') ?>
    <br/>
    <br/>
		<div class='col-xs-10 col-sm-8 col-md-4 col-sm-offset-2 col-md-offset-4'>
        	<div class='panel panel-default'>
        		<div class='panel-heading'>
			    		<h1 class='panel-title' style='font-size:x-large; text-align:center'>Account Registeration</h1>
			 			</div>
			 			<div class='panel-body'>
			    		<form method="post">
			    			<div class='row'>
			    				<div class='col-xs-6 col-sm-6 col-md-6'>
			    					<div class='form-group'>
			               				<input type='text' name='firstName' id='firstName' placeholder='Input First Name'  autocomplete='off' class='form-control input-lg' required>
			    					</div>
			    				</div>
			    				<div class='col-xs-6 col-sm-6 col-md-6'>
			    					<div class='form-group'>
			    						<input type='text' name='lastName' id='lastName' placeholder='Input Last Name'  autocomplete='off'  class='form-control input-lg' pattern='[A-Za-z]{1,}' title='Letters only' required>
			    					</div>
			    				</div>
			    			</div>
			    			<input type='text' name='type' id='type' class='form-control input-lg' readonly value='Non-Admin' style="display:none">
			    			<div class='form-group'>
			    				<input type='email' name='emailAddress' id='emailAddress' class='form-control input-lg' pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder='Email Address' required>
			    				<u><i style='font-size:16px;'> *This will serve as your username for logging in.</i></u>
			    			</div>

			    			<div class='row'>
			    				<div class='col-xs-6 col-sm-6 col-md-6'>
			    					<div class='form-group'>
			    						<input type='password' name='password' required id='password' class='form-control input-lg' placeholder='Password' pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters">
			    					</div>
			    				</div>

			    				<div class='col-xs-6 col-sm-6 col-md-6'>
			    					<div class='form-group'>
			    						<input type='password' name='password_confirmation' placeholder='Re-type Password'  id='password_confirmation' class='form-control input-lg' required>
			    					</div>
			    				</div>
			    			</div>
                <div class='p-3 mb-2 bg-danger text-white' id='confirmError'>Password does not match. Please try Again.</div>
                <div class='p-3 mb-2 bg-success text-white' id='confirmSuccess'>Password Match!</div>
                <div class='p-3 mb-2 bg-danger text-white' id='confirmSuccess'><?= $errorMessage ?></div>
                <br/>
						<div class='col-lg-offset-5'>
			    			<input type='submit' name='register' id='register' value='Register' class='btn btn-info btn-block input-lg' style='width:100px; font-size: large;'>
			    		</div>
			    			<br>
			    		</form>
              <div id="message">
                <h3>Password must contain the following:</h3>
                <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                <p id="number" class="invalid">A <b>number</b></p>
                <p id="length" class="invalid">Minimum <b>8 characters</b></p>
              </div>
			    	</div>
	    		</div>
    		</div>
