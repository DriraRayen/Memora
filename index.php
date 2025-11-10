<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$isCreator = $isLoggedIn && isset($_SESSION['user_creator']) && $_SESSION['user_creator'] == 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Memora</title>
   <link rel="stylesheet" href="css/main.css">
   <link rel="stylesheet" href="css/button.css">
   <link rel="icon" href="img/logo.png" type="image/x-icon">
   <script src="js/navigation.js" defer></script>
   <script src="js/true-categories.js" defer></script>
   <?php if ($isLoggedIn): ?>
      <script src="js/logout.js" defer></script>
   <?php endif; ?>
</head>

<body>
   <header>
      <nav>
         <span>
            <img src="img/logo.png" alt="">
            <h1>Memora</h1>
         </span>
         <span <?php if ($isLoggedIn)
            echo 'style="padding-right:110px;"'; ?>>
            <a href="index.php">Home</a>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php' : 'html/signin.php'; ?>">Browse</a>
            <a
               href="<?php echo $isLoggedIn ? ($isCreator ? 'html/create.php' : 'html/contact.php') : 'html/signin.php'; ?>">Create</a>
            <a
               href="<?php echo $isLoggedIn ? ($isCreator ? 'html/contact.php' : 'html/contact.php') : 'html/signin.php'; ?>"><?php echo $isCreator ? 'Contact' : 'Become Creator'; ?></a>
         </span>
         <span id="user-header">
            <?php if ($isLoggedIn): ?>
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
            <?php else: ?>
               <button class="btx-blue-reverse" onclick="window.location.href='html/signin.php'">Login</button>
               <button class="btx-blue" onclick="window.location.href='html/signup.php'">Sign Up</button>
            <?php endif; ?>
         </span>
      </nav>
   </header>
   <div class="hero">
      <div class="hero-content">
         <h2 class="very-big-title">One Platform,<br><span class="blue">Endless Possibilities</span></h2>
         <p>From passive reading to active recall, our solution empowers you to work smarter not harder. <br>
            Discover the
            endless possibilities waiting for you</p>
         <div class="button-holder">
            <button class="btx-blue"
               onclick="window.location.href='<?php echo $isLoggedIn ? 'html/browse.php' : 'html/signin.php'; ?>'">GET
               STARTED</button>
            <button class="btx-blue-reverse"
               onclick="window.location.href='<?php echo $isLoggedIn ? 'html/contact.php' : 'html/signin.php'; ?>'">CONTACT</button>
         </div>
      </div>
      <div class="hero-image">
      </div>
   </div>
   <div class="stats">
      <div class="stats-content">
         <h4 class="medium-title">500 +</h4>
         <p>Users Since Launch</p>
      </div>
      <div class="stats-content">
         <h4 class="medium-title">75 +</h4>
         <p>Creators And Growing</p>
      </div>
      <div class="stats-content">
         <h4 class="medium-title">700 +</h4>
         <p>Stunning Flashcards Created</p>
      </div>
      <div class="stats-content">
         <h4 class="medium-title">5k +</h4>
         <p>Media Features</p>
      </div>
   </div>
   <div class="why">
      <h2 class="big-title"><span class="blue">Why</span> Choose Us<span class="blue">?</span></h2>
      <div class="why-content">
         <div class="why-card">
            <img src="img/Free.svg" alt="">
            <h4 class="medium-title">Full Free Access</h4>
            <p>Enjoy everything Memora has to offer — completely free!</p>
         </div>
         <div class="why-card">
            <img src="img/Customizable.svg" alt="">
            <h4 class="medium-title">Customizable</h4>
            <p>Personalize your flashcards with images, text, and colors to make them truly your own.</p>
         </div>
         <div class="why-card">
            <img src="img/Community.svg" alt="">
            <h4 class="medium-title">Community Driven</h4>
            <p>Join a vibrant community of learners and creators who share their knowledge and resources.</p>
         </div>
      </div>
   </div>
   <div class="main">
      <h2 class="big-title"><span class="blue">What </span>Can You Learn <span class="blue">!</span></h2>
      <div class="main-content" id="flashcard-sets">
         <!-- Dynamic content will be loaded here -->
      </div>
   </div>

   <footer>
      <div>
         <div>
            <h4>You can find us on</h4>
            <div><img src="img/facebook.png" alt="">
               <a>Facebook.com</a>
            </div>
            <div><img src="img/instagram.png" alt="">
               <a>Instagram.com</a>
            </div>
            <div><img src="img/mail.png" alt="">
               <a>email@domain.com</a>
            </div>
         </div>
         <div class="gap-footer">
            <h4>Memora</h4>
            <a href="index.php">Home</a>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php' : 'html/signin.php'; ?>">Browse</a>
            <a href="<?php echo $isLoggedIn ? 'html/create.php' : 'html/signin.php'; ?>">Create</a>
            <a href="<?php echo $isLoggedIn ? 'html/contact.php' : 'html/signin.php'; ?>">Contact</a>
         </div>
         <div class="gap-footer">
            <h4>Categories</h4>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php?category_id=1' : 'html/signin.php'; ?>">History</a>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php?category_id=2' : 'html/signin.php'; ?>">Geography</a>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php?category_id=3' : 'html/signin.php'; ?>">Language</a>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php?category_id=4' : 'html/signin.php'; ?>">Science</a>
            <a href="<?php echo $isLoggedIn ? 'html/browse.php?category_id=5' : 'html/signin.php'; ?>">Literature</a>
         </div>
      </div>
      <p>© 2025 Memora. All rights reserved.</p>
   </footer>
</body>

</html>