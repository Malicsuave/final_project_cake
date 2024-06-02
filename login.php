<?php
 session_start();
 if (empty($_SESSION['username'])) {
  header('location:login.php');
 }
 require_once('classes/database.php');
 $con=new database();
 $error = "";


if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $result = $con->check($username, $password);  

if($result) {
      $_SESSION['username'] = $result['username'];
      $_SESSION['User_Id'] = $result['User_Id'];
  if ($result['account_type']==0){
     header('location:index.php');
  }
  else if ($result['account_type']==1){
      header('location:index.php');
  }
}
  else{
$error = "Incorrect username or password ";
  }
}


?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=\, initial-scale=1.0">
 
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./bootstrap-4.5.3-dist/css/bootstrap.css">
  <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.css">
  <!-- Link for styles -->
  <link rel="stylesheet" href="./styling/style.css">
  
  <!-- Link for fontawesome -->
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  

  <title>Cake</title>
 </head>
 <body class="bg1">
 <div class="bouncing-blobs-container">
  <div class="bouncing-blobs-glass"></div>
  <div class="bouncing-blobs">
    <div class="bouncing-blob bouncing-blob--blue"></div>
    <div class="bouncing-blob bouncing-blob--blue"></div>
    <div class="bouncing-blob bouncing-blob--blue"></div>
    <div class="bouncing-blob bouncing-blob--white"></div>
    <div class="bouncing-blob bouncing-blob--purple"></div>
    <div class="bouncing-blob bouncing-blob--purple"></div>
    <div class="bouncing-blob bouncing-blob--pink"></div>
  </div>
</div>

 <h2>Welcome to Marga's Cake</h2>
<div class="container" id="container">
	<div class="form-container sign-up-container">
  <form id="registration-form" method="post" action="" enctype="multipart/form-data" novalidate>

			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				<a href="#" class="social"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				<a href="#" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			</div>
			<span>or use your email for registration</span>
    <div>
    <div class="form-group">
    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid username.</div>
            <div id="usernameFeedback" class="invalid-feedback"></div>

    </div>
    <div class="form-group">
    <input type="text" class="form-control" name="email" id="email" placeholder="Enter email" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid email.</div>
            <div id="emailFeedback" class="invalid-feedback"></div>

    </div>
    <div class="form-group">

    <input type="text" class="form-control" name="password" id="password" placeholder="Enter password" required>
            <div class="valid-feedback">Looks good!</div>
           

    </div>
  
    </div>
      
</form>
		
	</div>
	<div class="form-container sign-in-container">
		<form method="POST">
			<h1>Sign in</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fa fa-facebook" aria-hidden="true"></i></a>
				<a href="#" class="social"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
				<a href="#" class="social"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
			</div>
			<span>or use your account</span>
			<input type="text" class="form-control" name="username" placeholder="Enter username">
      <input type="password" class="form-control" name="password" placeholder="Enter password">
      <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
			<a href="#">Forgot your password?</a>
			<button type="submit" name="login">Sign In</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Hello, Friend!</h1>
				<p>Enter your personal details and start journey with us</p>
				<button class="ghost" id="signUp">Sign Up</button>
			</div>
		</div>
	</div>
</div>

<footer>
	<p>
		Created with <i class="fa fa-heart"></i> by
		<a target="_blank" href="https://florin-pop.com">Florin Pop</a>
		- Read how I created this and how you can join the challenge
		<a target="_blank" href="https://www.florin-pop.com/blog/2019/03/double-slider-sign-in-up-form/">here</a>.
	</p>
</footer>


<!-- This is area is for script -->
<script src="script/login.js"></script>
<script src="./bootstrap-5.3.3-dist/js/bootstrap.js"></script>

 </body>
 </html>

 