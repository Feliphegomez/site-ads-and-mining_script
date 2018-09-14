<?php
	include('../api/autoload.php');
	
	if(!isset($_SESSION['nick']) && !isset($_SESSION['hash'])){
		$page = "login";
	}else{
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}else{
			$page = "home";
		}
	}	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	</head>

	<body>
		<?php include("templates/navbar.php"); ?>
		<div class="container">
			<?php 
				
				$file = "templates/{$page}.php";
				if(file_exists($file)){
					include($file);
				}else{
					# include('config/docs/site/errors/404.php');
				}
			?>
		</div>
	</body>
</html>