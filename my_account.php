<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';

	session_start();
	if (isset($_SESSION['token'])) {
		if (!verifyLogin($_SESSION['user'], $_SESSION['token'], $_SESSION['role'], $mysqli))
			header("Location: includes/logout.php");
	}

	if (isset($_REQUEST['changeUsername'])) {
		if ($_REQUEST['newUsername'] != "") {
			if ($stmt = $mysqli->query("SELECT Username FROM user")) {
				while($row = mysqli_fetch_array($stmt)) {
					if ($row['Username'] == $_REQUEST['newUsername']) {
						$message = '<div class="alert alert-warning" role="alert">Username is already taken!</div>';
						$used = true;
					}
				}

				if (!isset($used)) {
					if ($stmt2 = $mysqli->query("SELECT * FROM user WHERE Username='".$_SESSION['user']."' LIMIT 1")) {
						$row2 = mysqli_fetch_array($stmt2);
						$mysqli->query("UPDATE user SET Username='".$_REQUEST['newUsername']."' WHERE ID='".$row2['ID']."'");
						$_SESSION['user'] = $_REQUEST['newUsername'];

						$token = password_hash($_REQUEST['newUsername'].$row2['Password'], PASSWORD_DEFAULT, array("cost" => 10));
						$_SESSION['token'] = $token;

						if ($mysqli->query("UPDATE token SET Token='".$token."' WHERE user_ID='".$row2['ID']."'")) {
							$message = '<div class="alert alert-success" role="alert">Username changed!</div>';
						}
					}
				}
			}
		}
		else {
			$message = '<div class="alert alert-warning" role="alert">Please enter username!</div>';
		}
	}
	else if (isset($_REQUEST['changePassword'])) {
		if ($_REQUEST['oldPass'] != "") {
			if ($stmt = $mysqli->query("SELECT * FROM user WHERE Username='".$_SESSION['user']."'")) {
				$row = mysqli_fetch_array($stmt);
				if (password_verify($_REQUEST['oldPass'], $row['Password'])) {
					if ($_REQUEST['newPass'] == $_REQUEST['newPassRepeat']) {
						if ($stmt2 = $mysqli->query("SELECT * FROM user WHERE Username='".$_SESSION['user']."' LIMIT 1")) {
						$row2 = mysqli_fetch_array($stmt2);
						$hashpass = hashPassword($_REQUEST['newPass']);

						$mysqli->query("UPDATE user SET Password='".$hashpass."' WHERE ID='".$row2['ID']."'");

						$token = password_hash($_SESSION['user'].$hashpass, PASSWORD_DEFAULT, array("cost" => 10));
						$_SESSION['token'] = $token;

						if ($mysqli->query("UPDATE token SET Token='".$token."' WHERE user_ID='".$row2['ID']."'")) {
							$message = '<div class="alert alert-success" role="alert">Password changed!</div>';
						}
					}
					}
					else {
						$message = '<div class="alert alert-warning" role="alert">new passwords does not match!</div>';
					}
				}
				else {
					$message = '<div class="alert alert-warning" role="alert">Wrong old password!</div>';
				}
			}
		}
		else {
			$message = '<div class="alert alert-warning" role="alert">Please enter the old password!</div>';
		}
	}
	else if (isset($_REQUEST['deleteAcc'])) {
		session_start();
		include_once 'db_connect.php';
		if ($stmt = $mysqli->query("SELECT ID FROM user WHERE Username='".$_SESSION['user']."'")) {
			while($row = mysqli_fetch_array($stmt)) {
				$mysqli->query("DELETE FROM token WHERE user_ID='".$row['ID']."'");
				$mysqli->query("DELETE FROM user WHERE ID='".$row['ID']."'");
			}
		}

		session_unset('token');
		session_unset('user');
		session_destroy();
		header("Location: index.php");
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
		        		echo '<li><a href="create_user.php">Create user</a></li>';
		        	}
		        	else {
		        		echo '<li class="active"><a href="">My account<span class="sr-only">(current)</span></a></li>';
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
						if (isset($message))
						echo $message;

						if (isset($_SESSION['token'])):
					?>
					<h1>My account</h1><hr>
					<h2>Change Username</h2>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputNewUsername" class="col-sm-2 control-label">New username</label>
							    <div class="col-sm-10">
							      	<input type="text" id="newUsername" class="form-control" name="newUsername" value="" placeholder="New username">
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Change">
							    </div>
							</div>
							<input type="hidden" name="changeUsername" value="true">
  						</form>
					</ul>
					<br><br><br>
					<h2>Change Password</h2>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputOldPassword" class="col-sm-2 control-label">Old password</label>
							    <div class="col-sm-10">
							      	<input type="password" id="oldPass" class="form-control" name="oldPass" value="" placeholder="Old password">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputNewPassword" class="col-sm-2 control-label">New password</label>
							    <div class="col-sm-10">
							      	<input type="password" id="newPass" class="form-control" name="newPass" value="" placeholder="New password">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputNewPasswordRepeat" class="col-sm-2 control-label">Repeat new password</label>
							    <div class="col-sm-10">
							      	<input type="password" id="newPassRepeat" class="form-control" name="newPassRepeat" value="" placeholder="Repeat new password">
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Change">
							    </div>
							</div>
							<input type="hidden" name="changePassword" value="true">
  						</form>
					</ul>
					<br><br><br>
					<h2>Delete account</h2>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-danger btn-lg" value="Delete!">
							    </div>
							</div>
							<input type="hidden" name="deleteAcc" value="true">
  						</form>
					</ul>
					<br><br><br>
					<h2>Rented books</h2>
					<?php
						include_once 'includes/get_rents.php';
						endif;
					?>
				</div>
			</div>
		</div>


</body>
</html>