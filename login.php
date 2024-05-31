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

if (isset($_POST['multisave'])) {
    
  // Getting the account information
  $username = $_POST['username'];
  $email = $_POST['email'];

  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  
  // Getting the personal information
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $birthday = $_POST['birthday'];
  $sex = $_POST['sex'];

  // Getting the address information
  $street = $_POST['user_street'];
  $barangay = $_POST['barangay_text'];
  $city = $_POST['city_text'];
  $province = $_POST['region_text'];

 // Handle file upload
 $target_dir = "uploads/";
 $original_file_name = basename($_FILES["profile_picture"]["name"]);
 
 // NEW CODE: Initialize $new_file_name with $original_file_name
  $new_file_name = $original_file_name; 
 
 
  $target_file = $target_dir . $original_file_name;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $uploadOk = 1;
 
 // Check if file already exists and rename if necessary
// Check if file already exists and rename if necessary
if (file_exists($target_file)) {
 // Generate a unique file name by appending a timestamp
 $new_file_name = pathinfo($original_file_name, PATHINFO_FILENAME) . '_' . time() . '.' . $imageFileType;
 $target_file = $target_dir . $new_file_name;
} else {
 // Update $target_file with the original file name
 $target_file = $target_dir . $original_file_name;
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
  // Check if file is an actual image or fake image
  $check = getimagesize($_FILES["profile_picture"]["tmp_name"]);
  if ($check === false) {
      echo "File is not an image.";
      $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["profile_picture"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }

  // Allow certain file formats
  if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  } else {
      if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
          echo "The file " . htmlspecialchars($new_file_name) . " has been uploaded.";

          // Save the user data and the path to the profile picture in the database
          $profile_picture_path = 'uploads/'.$new_file_name; // Save the new file name (without directory)
          
          $userID = $con->signupUser($firstname, $lastname, $birthday, $sex, $email, $username, $password, $profile_picture_path);

          if ($userID) {
              // Signup successful, insert address into users_address table
              if ($con->insertAddress($userID, $street, $barangay, $city, $province)) {
                  // Address insertion successful, redirect to login page
                  header('location:index.php');
                  exit; // Stop further execution
              } else {
                  // Address insertion failed, display error message
                  $error = "Error occurred while signing up. Please try again.";
              }
          } else {
              // Signup failed, display error message
              echo "Sorry, there was an error signing up.";
          }
      } else {
          // File upload failed, display error message
          echo "Sorry, there was an error uploading your file.";
      }
  }
}





?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=\, initial-scale=1.0">
  <!-- Link for styles -->
  <link rel="stylesheet" href="styling/style.css">
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
    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
            <div class="valid-feedback">Looks good!</div>
            <div class="invalid-feedback">Please enter a valid username.</div>
            <div id="usernameFeedback" class="invalid-feedback"></div>

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

 </body>
 </html>

 