<?php
	include_once 'includes/db_connect.php';
	include_once 'includes/functions.php';

	session_start();
	if (isset($_SESSION['token'])) {
		if (!verifyLogin($_SESSION['user'], $_SESSION['token'], $_SESSION['role'], $mysqli))
			header("Location: includes/logout.php");
	}

	if ($_REQUEST['changeCopies']) {
		include 'includes/change_copies.php';
	}
	else if ($_REQUEST['addBook']) {
		include 'includes/add_book.php';
	}
	else if ($_REQUEST['deleteBook']) {
		include 'includes/delete_book.php';
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
		        		echo '<li><a href="my_account.php">My account</a></li>';
		        	}
		        ?>
		        <?php 
		        	if (isset($_SESSION['role'])) {
		        		if ($_SESSION['role'] == 1) {
		        			echo '<li class="active"><a href="">Admin<span class="sr-only">(current)</span></a></li>';
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
					?>
					<h1>Admin Settings</h1><hr>
					<h2>Change number of copies</h2>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputBook" class="col-sm-2 control-label">Book</label>
							    <div class="col-sm-10">
							      	<select class="form-control" name="book">
									 	<?php include 'includes/get_titles.php'; ?>
									</select>
							    </div>
							</div>
  							<div class="form-group">
							    <label for="inputNumber" class="col-sm-2 control-label">Number of copies</label>
							    <div class="col-sm-10">
							      	<input type="text" id="copies" class="form-control" name="copies" value="" placeholder="Number of copies">
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Change">
							    </div>
							</div>
							<input type="hidden" name="changeCopies" value="true">
  						</form>
					</ul>
					<br><br><br>
					<h2>Add book to library</h2>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputTitle" class="col-sm-2 control-label">Title</label>
							    <div class="col-sm-10">
							      	<input type="text" id="title" class="form-control" name="title" value="" placeholder="Title">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputDesc" class="col-sm-2 control-label">Description</label>
							    <div class="col-sm-10">
							     	<textarea class="form-control" id="description" name="description" placeholder="Description" style="resize: none;"></textarea>
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputAuthor" class="col-sm-2 control-label">Author</label>
							    <div class="col-sm-10">
							      	<input type="text" id="author" class="form-control" name="author" value="" placeholder="Author">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputPages" class="col-sm-2 control-label">Number of pages</label>
							    <div class="col-sm-10">
							      	<input type="text" id="pages" class="form-control" name="pages" value="" placeholder="Pages">
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputSubjects" class="col-sm-2 control-label">Subjects</label>
							    <div class="col-sm-10">
							     	<textarea class="form-control" id="subjects" name="subjects" placeholder="Type subjects seperated by a comma and no space just before/after the comma" style="resize: none;"></textarea>
							    </div>
							</div>
							<div class="form-group">
							    <label for="inputCopies" class="col-sm-2 control-label">Number of copies</label>
							    <div class="col-sm-10">
							      	<input type="text" id="copies" class="form-control" name="copies" value="" placeholder="Number of copies">
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-primary" value="Add">
							    </div>
							</div>
							<input type="hidden" name="addBook" value="true">
  						</form>
					</ul>
					<br><br><br>
					<h2>Delete book from library</h2>
					<ul class="nav nav-pills nav-stacked">
  						<form class="form-horizontal" action="" method="POST">
  							<div class="form-group">
							    <label for="inputBook" class="col-sm-2 control-label">Book</label>
							    <div class="col-sm-10">
							      	<select class="form-control" name="book">
									 	<?php include 'includes/get_titles.php'; ?>
									</select>
							    </div>
							</div>
							<div class="form-group">
							    <div class="col-sm-offset-2 col-sm-10">
							      	<input type="submit" id="Submit" class="btn btn-danger" value="Delete">
							    </div>
							</div>
							<input type="hidden" name="deleteBook" value="true">
  						</form>
					</ul>
				</div>
			</div>
		</div>


</body>
</html>