<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';

	session_start();
	if (isset($_SESSION['token'])) {
		if (!verifyLogin($_SESSION['user'], $_SESSION['token'], $_SESSION['role'], $mysqli))
			header("Location: includes/logout.php");
	}

	if ($_REQUEST['username'] != "") {
		if ($_REQUEST['password'] != "") {
			if ($_REQUEST['hasBeenSubmitted']) {
				if ($stmt = $mysqli->query("SELECT ID, Username, Password, roles_ID FROM user")) {
					while ($row = mysqli_fetch_array($stmt)) {
						if ($row['Username'] == $_REQUEST['username'] && password_verify($_REQUEST['password'], $row['Password'])) {
							$token = password_hash($_REQUEST['username'].$row['Password'], PASSWORD_DEFAULT, array("cost" => 10));
							$_SESSION['token'] = $token;
							$_SESSION['user'] = $_REQUEST['username'];
							$_SESSION['role'] = $row['roles_ID'];
							$mysqli->query("INSERT INTO token (Token, user_ID) VALUES ('".$token."', '".$row['ID']."')");
							if (isset($_SESSION['token'])) $message = '<div class="alert alert-success" role="alert">You are logged in!</div>';
						}
						else {
							$message = '<div class="alert alert-warning" role="alert">Incorrect Username/Password!</div>';
						}
					}
				}
			}
		}
		else {
			$message = '<div class="alert alert-warning" role="alert">Enter password!</div>';
		}
	}
	else {
		$message = '<div class="alert alert-warning" role="alert">Enter username!</div>';
	}

	if (isset($_SESSION['token']))
		$message = '<div class="alert alert-success" role="alert">You are logged in!</div>';
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
		        		echo '<li class="active"><a href="">Login<span class="sr-only">(current)</span></a></li>';
		        		echo '<li><a href="create_user.php">Create user</a></li>';
		        	}
		        	else {
		        		echo '<li><a href="my_account.php">My account</a></li>';
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

					<?php 
					
						if (!isset($_SESSION['token'])):
						if ($_REQUEST['hasBeenSubmitted']) {echo $message;} 
					?>
					<h2>Login</h2><hr>
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
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Login">
							    </div>
							</div>
							<input type="hidden" name="hasBeenSubmitted" value="true">
  						</form>
					</ul>
					<?php 
						else:
							echo $message;
						endif; 
					?>
				</div>
			</div>
		</div>


</body>
</html>