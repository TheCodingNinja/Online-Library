<?php
	session_start();
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';

	if (isset($_SESSION['token'])) {
		if (!verifyLogin($_SESSION['user'], $_SESSION['token'], $_SESSION['role'], $mysqli))
			header("Location: includes/logout.php");
	}

	if ($_REQUEST['username'] != "") {
		if ($_REQUEST['password'] == $_REQUEST['repeat']) {
			if ($_REQUEST['hasBeenSubmitted']) {

				if ($stmt = $mysqli->query("SELECT Username FROM user")) {
					while($row = mysqli_fetch_array($stmt)) {
						if ($row['Username'] == $_REQUEST['username']) {
							$message = '<div class="alert alert-warning" role="alert">Username is already taken!</div>';
							$used = true;
						}
					}
				}

				if (!isset($used)) {
					$hashpass = hashPassword($_REQUEST['password']);
					if ($_REQUEST['admin'] != "" && password_verify($_REQUEST['admin'], ADMINPASS)) {

						$ad = 1;
						if ($mysqli->query("INSERT INTO user (Username, Password, roles_ID) VALUES ('".$_REQUEST['username']."', '".$hashpass."', '".$ad."')"))
							$message = '<div class="alert alert-success" role="alert">Admin user created, please login!</div>';
						else
							$message = '<div class="alert alert-warning" role="alert">Error!</div>';
					}
					else {
						$ad = 2;

						if ($mysqli->query("INSERT INTO user (Username, Password, roles_ID) VALUES ('".$_REQUEST['username']."', '".$hashpass."', '".$ad."')"))
							$message = '<div class="alert alert-success" role="alert">User created, please login!</div>';
						else
							$message = '<div class="alert alert-warning" role="alert">Error!</div>';
					}
				}
			}
		}
		else {
			$message = '<div class="alert alert-warning" role="alert">Passwords do not match!</div>';
		}
	}
	else {
		$message = '<div class="alert alert-warning" role="alert">Enter username!</div>';
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>OLib</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<script src="js/jquery.js" type="text/javascript"></script>
	<script src="js/bootstrap.js" type="text/javascript"></script>
	</head>
<body>
		<nav class="navbar navbar-default">
		  <div class="container">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="index.php">OLib</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li><a href="index.php">Books</a></li>
		        <?php
		        	if (!isset($_SESSION['token'])) { 
		        		echo '<li><a href="login.php">Login</a></li>';
		        		echo '<li class="active"><a href="">Create user<span class="sr-only">(current)</span></a></li>';
		        	}
		        	else {
		        		echo '<li"><a href="my_account.php">My account</a></li>';
		        	}
		        ?>
		        <?php 
		        	if (isset($_SESSION['role'])) {
		        		if ($_SESSION['role'] == 1) {
		        			echo '<li><a href="admin.php">Admin</a></li>';
		        		}
		        	}
		        ?>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		      	<?php
		      		if (!isset($_SESSION['token']))
		      			echo '<li><p class="navbar-text">Not logged in</p></li>';
		      		else {
		      			echo '<li><p class="navbar-text">Logged in as '.$_SESSION['user'].'</p></li>';
		      			echo '<li><button type="button" class="btn btn-danger navbar-btn" onclick="window.location.href=&#39;includes/logout.php&#39;">Log out</button></li>';
		      		}
		      	?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="container">
			<div class="row">

				<div class="col-md-offset-2 col-md-8">
					<?php if ($_REQUEST['hasBeenSubmitted']) {echo $message;} ?>
					<h2>Create user</h2><hr>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputUsername" class="col-sm-2 control-label">Username</label>
							    <div class="col-sm-10">
							      	<input type="text" id="username" class="form-control" name="username" value="" placeholder="Username">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputPassword" class="col-sm-2 control-label">Password</label>
							    <div class="col-sm-10">
							      	<input type="password" id="password" class="form-control" name="password" value="" placeholder="Password">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputRepeat" class="col-sm-2 control-label">Repeat</label>
							    <div class="col-sm-10">
							      	<input type="password" id="repeat" class="form-control" name="repeat" value="" placeholder="Repeat password">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputAdminPass" class="col-sm-2 control-label">Admin password</label>
							    <div class="col-sm-10">
							      	<input type="password" id="admin" class="form-control" name="admin" value="" placeholder="Admin password">
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Create">
							    </div>
							</div>
							<input type="hidden" name="hasBeenSubmitted" value="true">
  						</form>
					</ul>
				</div>
			</div>
		</div>


</body>
</html>