<?php  include('config.php'); ?>
<?php  include('includes/reg_login.php'); ?>
<?php  include('includes/head.php'); ?>
	<title>OTA Creators | Sign in </title>
</head>  
<style type="text/css">body{
	overflow: hidden;
	
}</style>
<section class="lgcontainer">
	<img  class="logo" src="<?php echo BASE_URL . 'static/images/logo.png'?>">
	<div class="loginbox">
		<form method="post" action="login.php" >
			<h2>Take your seat creator !</h2>
			<?php include(ROOT_PATH . '/includes/error.php') ?>
			<input type="text" name="username"  value="" placeholder="Username">
			<input type="password" name="password" placeholder="Password">
			<button type="submit" class="btn" name="login_btn">Login</button>
		
		</form>  
	</div>
</section>
