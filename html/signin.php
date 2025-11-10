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
   <title>Sign In</title>
   <link rel="stylesheet" href="..\css\SignIn.css">
   <link rel="stylesheet" href="..\css\button.css">
   <link rel="icon" href="..\img\logo.png" type="image/x-icon">
   <script src="https://kit.fontawesome.com/61523b4b4d.js" crossorigin="anonymous"></script>
   <script type="text/javascript" src="..\js\signin.js" defer></script>
</head>

<body>
   <form action="../php/verify-login.php" method="POST" class="form-box">
      <section>
         <h1>Sign In</h1>
         <div class="input-box">
            <input type="email" name="email" placeholder="Email" id="email_input" required>
            <i class="fa-solid fa-user"></i>
         </div>
         <div class="input-box">
            <input type="password" name="password" placeholder="Password" id="password_input" required>
            <i class="fa-solid fa-lock"></i>
         </div>
         <div class="remember-forgot">
            <label><input type="checkbox" id="remember_checkbox">Remember me</label>
            <a href="#">Forgot password?</a>
         </div>
         <button type="submit" class="btx-blue-blue">Sign In</button>
         <div class="register-link">
            <p>No account yet? <a href="signup.php">Sign Up</a></p>
         </div>
      </section>
   </form>
</body>

</html>