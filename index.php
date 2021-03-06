<?php
	session_start();

	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';

	if (isset($_SESSION['token'])) {
		if (!verifyLogin($_SESSION['user'], $_SESSION['token'], $_SESSION['role'], $mysqli))
			header("Location: includes/logout.php");
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
		      <a class="navbar-brand" href="">OLib</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="">Books<span class="sr-only">(current)</span></a></li>
		        <?php
		        	if (!isset($_SESSION['token'])) { 
		        		echo '<li><a href="login.php">Login</a></li>';
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

				<div class="col-md-4">
					<h3>Search</h3><hr>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputTitle" class="col-sm-2 control-label">Title</label>
							    <div class="col-sm-10">
							      	<input type="text" id="title" class="form-control" name="title" value="" placeholder="Title">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputAuthor" class="col-sm-2 control-label">Author</label>
							    <div class="col-sm-10">
							      	<input type="text" id="author" class="form-control" name="author" value="" placeholder="Author">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputCategory" class="col-sm-2 control-label">Subject</label>
							    <div class="col-sm-10">
							      	<select class="form-control" name="subject">
							      		<option value=""></option>}
									 	<?php include 'includes/get_subjects.php'; ?>
									</select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Search">
							    </div>
							</div>
							<input type="hidden" name="hasBeenSubmitted" value="true">
  						</form>
					</ul>
				</div>

				<div class="col-md-8">
				<h3>Books</h3><hr>
				<?php 
					if (isset($_REQUEST['hasBeenSubmitted'])) {
						include 'includes/search_books.php';
					}
					else {
						include 'includes/get_books.php';
					}
				?>
				</div>
			</div>
		</div>


</body>
</html>