<?php
	include_once "includes/db_connect.php";
	$category = isset($_REQUEST['category']) ? $_REQUEST['category'] : "";
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Forum</title>
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
		      <a class="navbar-brand" href="#">Everything</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="#">Posts <span class="sr-only">(current)</span></a></li>
		        <li><a href="create_category.php">Create category</a></li>
		        <li><a href="create_post.php">Create post</a></li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>

		<div class="container">
			<div class="row">

				<div class="col-md-3">
					<h3>Categories</h3>
					<ul class="nav nav-pills nav-stacked">
  						<?php
  							include_once 'includes/load_categories.php';
  						?>
					</ul>
				</div>

				<div class="col-md-9">
					<?php 
						include_once 'includes/load_posts.php'; 
					?>
				</div>
			</div>
		</div>


</body>
</html>