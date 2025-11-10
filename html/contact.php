<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isCreator = $isLoggedIn && isset($_SESSION['user_creator']) && $_SESSION['user_creator'] == 1;

// Redirect to signin if not logged in
if (!$isLoggedIn) {
   header("Location: signin.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <script src="..\js\contact.js"></script>
   <link rel="stylesheet" href="..\css\main.css" />
   <link rel="stylesheet" href="..\css\contact.css" />
   <link rel="stylesheet" href="..\css\button.css">
   <script src="..\js\navigation.js"></script>
   <script src="..\js\logout.js"></script>
   <link rel="icon" href="..\img\logo.png" type="image/x-icon">
   <title>Contact Us</title>
</head>

<body>
   <header>
      <nav>
         <span>
            <img src="..\img\logo.png" alt="">
            <h1>Memora</h1>
         </span>
         <span style="padding-right:110px;">
            <a href="../index.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="<?php echo $isCreator ? 'create.php' : 'contact.php'; ?>">Create</a>
            <a href="contact.php"><?php echo $isCreator ? 'Contact' : 'Become Creator'; ?></a>
         </span>
         <span id="user-header">
            <div class="profile-container">
               <svg class="profile-logo" xmlns="http://www.w3.org/2000/svg" width="42" height="40" viewBox="0 0 42 40"
                  fill="none">
                  <g clip-path="url(#clip0_121_715)">
                     <path
                        d="M28.2639 17.5C28.2639 21.65 24.8208 25 20.5556 25C16.2903 25 12.8472 21.65 12.8472 17.5C12.8472 13.35 16.2903 10 20.5556 10C24.8208 10 28.2639 13.35 28.2639 17.5Z"
                        fill="#31C1E1" />
                     <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M41.1111 20C41.1111 31.05 31.9125 40 20.5556 40C9.19861 40 0 31.05 0 20C0 8.95 9.19861 0 20.5556 0C31.9125 0 41.1111 8.95 41.1111 20ZM10.2778 34.375C10.6889 33.71 14.6715 27.5 20.5299 27.5C26.3625 27.5 30.3708 33.725 30.7819 34.375C33.1712 32.7675 35.1234 30.6193 36.4706 28.1153C37.8178 25.6113 38.5197 22.8264 38.516 20C38.516 10.325 30.4736 2.5 20.5299 2.5C10.5861 2.5 2.54375 10.325 2.54375 20C2.54375 25.95 5.60139 31.225 10.2778 34.375Z"
                        fill="#31C1E1" />
                  </g>
                  <defs>
                     <clipPath id="clip0_121_715">
                        <rect width="41.1111" height="40" fill="white" />
                     </clipPath>
                  </defs>
               </svg>
               <div class="profile-dropdown">
                  <div class="profile-info">
                     <p class="profile-name">
                        <?php echo htmlspecialchars($_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']); ?>
                     </p>
                     <p class="profile-email"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                  </div>
                  <button class="btx-blue logout-btn" onclick="handleLogout()">Logout</button>
               </div>
            </div>
         </span>
      </nav>
   </header>
   <section class="contact" id="contact">
      <h2 class="heading"> <?php echo $isCreator ? 'Contact <span>Us</span> !' : 'Become <span>Creator</span> !'; ?></h2>
      <div class="container-contact">
         <form name="form1" action="https://api.web3forms.com/submit" method="POST">
            <input type="hidden" name="access_key" value="ae80fd77-91dc-45f7-9f55-5474379144ac">
            <div class="row">
               <div class="input-field">
                  <input type="text" placeholder="Full Name" name="fname" required />
               </div>
               <div class="input-field">
                  <input type="email" placeholder="Email address" name="email" required />
               </div>
            </div>

            <div class="row">
               <div class="input-field">
                  <input type="number" placeholder="Mobile Number" name="tel" required />
               </div>
               <div class="input-field">
                  <input type="text" placeholder="Email subject" name="sub" required />
               </div>
            </div>
            <div class="textarea-field">
               <textarea cols="30" rows="10" placeholder="Your Message" required></textarea>
            </div>
            <div class="button-holder">
               <button type="submit" class="btx-blue-blue">SEND</button>
            </div>
         </form>
      </div>
   </section>
   <div class="flash-image"></div>
   <footer>
      <div>
         <div>
            <h4>you can find us on</h4>
            <div><img src="../img/facebook.png" alt="">
               <a>Facebook.com</a>
            </div>
            <div><img src="../img/instagram.png" alt="">
               <a>Instagram.com</a>
            </div>
            <div><img src="../img/mail.png" alt="">
               <a>email@domaine.com</a>
            </div>
         </div>
         <div class="gap-footer">
            <h4>Memora</h4>
            <a href="../index.php">Home</a>
            <a href="browse.php">Browse</a>
            <a href="create.php">Create</a>
            <a href="contact.php">Contact</a>
         </div>
         <div class="gap-footer">
            <h4>Categories</h4>
            <a href="browse.php">History</a>
            <a href="browse.php">Geography</a>
            <a href="browse.php">Language</a>
            <a href="browse.php">Science</a>
            <a href="browse.php">Literature</a>
         </div>
      </div>
      <p>© 2025 Memora. All rights reserved.</p>
   </footer>
</body>

</html>