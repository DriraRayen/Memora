<?php
session_start();
// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
   header("Location: ../index.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sign Up</title>
   <link rel="stylesheet" href="..\css\SignIn.css">
   <link rel="stylesheet" href="..\css\button.css">
   <link rel="icon" href="..\img\logo.png" type="image/x-icon">
   <script src="https://kit.fontawesome.com/61523b4b4d.js" crossorigin="anonymous"></script>
   <script type="text/javascript" src="..\js\validation.js" defer></script>
</head>

<body>
   <form action="../php/base-signup.php" method="POST" class="form-box">
      <section>
         <h1>Sign Up</h1>
         <div class="name-row">
            <div class="input-box">
               <input type="text" id="firstname_input" name="firstname" placeholder="First Name" required>
            </div>
            <div class="input-box">
               <input type="text" id="lastname_input" name="lastname" placeholder="Last Name" required>
            </div>
         </div>
         <div class="input-box">
            <input type="email" id="email_input" name="email" placeholder="Email" required>
            <i class="fas fa-envelope"></i>
         </div>
         <div class="input-box">
            <input type="password" id="password_input" name="password" placeholder="Password" required>
            <i class="fa-solid fa-lock"></i>
         </div>
         <div class="input-box">
            <input type="password" id="confirm_password_input" name="confirm_password" placeholder="Confirm Password"
               required>
            <i class="fa-solid fa-lock"></i>
         </div>
         <div class="remember-forgot" id="remember-forgot-singup">
            <label><input type="checkbox" id="terms_checkbox" required>I accept the terms and conditions</label>
         </div>
         <button type="submit" class="btx-blue-blue">Sign Up</button>
         <div class="register-link">
            <p>Already have an account? <a href="signin.php">Sign in</a></p>
         </div>
      </section>
   </form>
</body>

</html>