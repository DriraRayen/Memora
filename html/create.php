<?php
session_start(); // Start the session at the very beginning 

require '../php/connexion.php';

$isCreator = isset($_SESSION['user_creator']) && $_SESSION['user_creator'] == 1;

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>
            alert('Access Restricted\\n\\nYou must be logged in to create flashcard sets.\\n\\nPlease sign in to continue.');
            window.location.href = 'signin.php';
          </script>";
    exit();
}

// Check if the user is a creator
$user_id = $_SESSION['user_id'];
$sql = "SELECT creator FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if ($user['creator'] != 1) {
        echo "<script>
                if (data.creator != 1) {
                alert('Creator Access Only\\n\\nThis page is only accessible to content creators.\\n\\nContact us if you\\'d like to become a creator!');
                window.location.href = '../html/contact.php';
            }
                window.location.href = '../index.php';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Account Error\\n\\nWe couldn\\'t find your account information.\\n\\nPlease sign in again.');
            window.location.href = 'signin.php';
          </script>";
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\main.css">
    <link rel="stylesheet" href="..\css\button.css">
    <link rel="stylesheet" href="..\css\create.css">
    <script src="../js/create.js"></script>
    <script src="..\js\navigation.js"></script>
    <script src=..\js\logout.js></script>
    <link rel="icon" href="..\img\logo.png" type="image/x-icon">
    <title>Create</title>
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
                    <svg class="profile-logo" xmlns="http://www.w3.org/2000/svg" width="42" height="40"
                        viewBox="0 0 42 40" fill="none">
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
                            <p class="profile-name"><?php echo htmlspecialchars($_SESSION['user_firstname'] . ' ' . $_SESSION['user_lastname']); ?></p>
                            <p class="profile-email"><?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
                        </div>
                        <button class="btx-blue logout-btn" onclick="handleLogout()">Logout</button>
                    </div>
                </div>
            </span>
        </nav>
    </header>
    <div class="create-card">
        <h2 class="big-title"><span class="blue">Flash</span>card <span class="blue">Set </span>Buil<span
                class="blue">der</span></h2>
        <div class="container">
            <form action="../php/create-set.php" method="POST">
                <div id="create-1">
                    <input type="text" id="title-input" name="title-input"
                        placeholder="Enter a title, like “WW1 -chapter 1: Reasons and motives ”" required>
                    <select class="custom-select" name="categorie-input" id="categorie-input" required>
                        <option value="1">History</option>
                        <option value="2">Geography</option>
                        <option value="3">Math</option>
                        <option value="4">Science</option>
                        <option value="5">Language</option>
                        <option value="6">Art</option>
                        <option value="7">Music</option>
                        <option value="8">Literature</option>
                        <option value="9">Technology</option>
                    </select>
                    <input type="text" id="description-input" name="description-input"
                        placeholder="Add a description...">
                    <div class="button-holder">
                        <button class="btx-blue" id="next-button-1">Start</button>
                        <button type="reset" class="btx-blue-reverse" id="back-button-1">Reset</button>
                    </div>
                </div>
                <div id="create-2">
                    <div class="flash-group">
                        <div class="flashcard flash-front">
                            <div class="flash-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.617 28.1041L26.4378 28.552C23.233 29.6224 19.767 29.6224 16.5622 28.552L16.383 28.1041C16.2128 27.692 16.1268 27.4842 15.9781 27.2942C15.8312 27.1025 15.5732 26.909 15.0572 26.5238C13.2504 25.1711 11.9153 23.2841 11.241 21.1302C10.5667 18.9763 10.5874 16.6647 11.3002 14.5233C12.0131 12.3818 13.3818 10.519 15.2125 9.19891C17.0432 7.87884 19.243 7.16846 21.5 7.16846C23.757 7.16846 25.9568 7.87884 27.7875 9.19891C29.6182 10.519 30.9869 12.3818 31.6998 14.5233C32.4126 16.6647 32.4333 18.9763 31.759 21.1302C31.0847 23.2841 29.7496 25.1711 27.9428 26.5238C27.4268 26.909 27.1688 27.1025 27.0219 27.2942C26.875 27.486 26.789 27.6902 26.617 28.1041ZM17.6479 32.5474C17.8032 33.4934 17.8916 34.4478 17.9131 35.4105C17.9149 35.5377 17.9514 35.662 18.0186 35.77C18.0859 35.8779 18.1813 35.9655 18.2947 36.0232C19.2899 36.5209 20.3873 36.78 21.5 36.78C22.6127 36.78 23.7101 36.5209 24.7053 36.0232C24.8187 35.9655 24.9141 35.8779 24.9814 35.77C25.0486 35.662 25.0851 35.5377 25.0869 35.4105C25.1084 34.4478 25.1968 33.4934 25.3521 32.5474C22.8105 33.0687 20.1895 33.0687 17.6479 32.5474Z"
                                        fill="white" />
                                </svg>
                                <p>Front</p>
                                <p class="flash-number">01</p>
                            </div>
                            <textarea id="question-input" name="question-input" placeholder="Add a question..."
                                required></textarea>

                        </div>
                        <div class="flashcard flash-back">
                            <div class="flash-header">
                                <svg xmlns="http://www.w3.org/2000/svg" width="43" height="43" viewBox="0 0 43 43"
                                    fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M26.617 28.1041L26.4378 28.552C23.233 29.6224 19.767 29.6224 16.5622 28.552L16.383 28.1041C16.2128 27.692 16.1268 27.4842 15.9781 27.2942C15.8312 27.1025 15.5732 26.909 15.0572 26.5238C13.2504 25.1711 11.9153 23.2841 11.241 21.1302C10.5667 18.9763 10.5874 16.6647 11.3002 14.5233C12.0131 12.3818 13.3818 10.519 15.2125 9.19891C17.0432 7.87884 19.243 7.16846 21.5 7.16846C23.757 7.16846 25.9568 7.87884 27.7875 9.19891C29.6182 10.519 30.9869 12.3818 31.6998 14.5233C32.4126 16.6647 32.4333 18.9763 31.759 21.1302C31.0847 23.2841 29.7496 25.1711 27.9428 26.5238C27.4268 26.909 27.1688 27.1025 27.0219 27.2942C26.875 27.486 26.789 27.6902 26.617 28.1041ZM17.6479 32.5474C17.8032 33.4934 17.8916 34.4478 17.9131 35.4105C17.9149 35.5377 17.9514 35.662 18.0186 35.77C18.0859 35.8779 18.1813 35.9655 18.2947 36.0232C19.2899 36.5209 20.3873 36.78 21.5 36.78C22.6127 36.78 23.7101 36.5209 24.7053 36.0232C24.8187 35.9655 24.9141 35.8779 24.9814 35.77C25.0486 35.662 25.0851 35.5377 25.0869 35.4105C25.1084 34.4478 25.1968 33.4934 25.3521 32.5474C22.8105 33.0687 20.1895 33.0687 17.6479 32.5474Z"
                                        fill="white" />
                                </svg>
                                <p>Back</p>
                                <p class="flash-number">01</p>
                            </div>
                            <textarea id="answer-input" name="answer-input" placeholder="Add an answer..."
                                required></textarea>

                        </div>
                    </div>

                    <div id="quiz-1" class="quiz container">
                        <h2 class="medium-title">Add <span>Quiz</span> Parameters</h2>
                        <div class="input-holder">
                            <input type="text" name="correct-option" id="correct-option"
                                placeholder="Add the correct option..." required>
                            <input type="text" name="wrong-option-1" id="wrong-option-1"
                                placeholder="Add a wrong option..." required>
                        </div>
                        <div class="input-holder">
                            <input type="text" name="wrong-option-2" id="wrong-option-2"
                                placeholder="Add a wrong option..." required>
                            <input type="text" name="wrong-option-3" id="wrong-option-3"
                                placeholder="Add a wrong option..." required>
                        </div>

                    </div>
                    <div id="quiz-2" class="quiz container">
                        <div class="header-title">
                            <svg xmlns="http://www.w3.org/2000/svg" width="59" height="59" viewBox="0 0 59 59"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M36.521 38.5616L36.2752 39.1761C31.8778 40.6448 27.1222 40.6448 22.7248 39.1761L22.479 38.5616C22.2455 37.9961 22.1275 37.711 21.9234 37.4504C21.7218 37.1873 21.3678 36.9218 20.6598 36.3933C18.1808 34.5373 16.3489 31.9481 15.4237 28.9927C14.4985 26.0373 14.5269 22.8657 15.505 19.9274C16.4831 16.9891 18.3611 14.4332 20.873 12.6219C23.3849 10.8106 26.4032 9.83594 29.5 9.83594C32.5968 9.83594 35.6151 10.8106 38.127 12.6219C40.6389 14.4332 42.5169 16.9891 43.495 19.9274C44.4731 22.8657 44.5015 26.0373 43.5763 28.9927C42.6511 31.9481 40.8192 34.5373 38.3402 36.3933C37.6322 36.9218 37.2782 37.1873 37.0766 37.4504C36.875 37.7134 36.757 37.9937 36.521 38.5616ZM24.2146 44.6582C24.4276 45.9562 24.5489 47.2657 24.5784 48.5866C24.5809 48.7612 24.631 48.9317 24.7232 49.0799C24.8155 49.228 24.9465 49.3482 25.102 49.4274C26.4675 50.1102 27.9733 50.4657 29.5 50.4657C31.0267 50.4657 32.5325 50.1102 33.898 49.4274C34.0535 49.3482 34.1845 49.228 34.2767 49.0799C34.369 48.9317 34.4191 48.7612 34.4216 48.5866C34.4511 47.2657 34.5724 45.9562 34.7854 44.6582C31.2981 45.3735 27.7019 45.3735 24.2146 44.6582Z"
                                    fill="white" />
                            </svg>
                            <h2 class="medium-title">Add <span class="blue">a</span> Hint</h2>
                            <svg xmlns="http://www.w3.org/2000/svg" width="59" height="59" viewBox="0 0 59 59"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M36.521 38.5616L36.2752 39.1761C31.8778 40.6448 27.1222 40.6448 22.7248 39.1761L22.479 38.5616C22.2455 37.9961 22.1275 37.711 21.9234 37.4504C21.7218 37.1873 21.3678 36.9218 20.6598 36.3933C18.1808 34.5373 16.3489 31.9481 15.4237 28.9927C14.4985 26.0373 14.5269 22.8657 15.505 19.9274C16.4831 16.9891 18.3611 14.4332 20.873 12.6219C23.3849 10.8106 26.4032 9.83594 29.5 9.83594C32.5968 9.83594 35.6151 10.8106 38.127 12.6219C40.6389 14.4332 42.5169 16.9891 43.495 19.9274C44.4731 22.8657 44.5015 26.0373 43.5763 28.9927C42.6511 31.9481 40.8192 34.5373 38.3402 36.3933C37.6322 36.9218 37.2782 37.1873 37.0766 37.4504C36.875 37.7134 36.757 37.9937 36.521 38.5616ZM24.2146 44.6582C24.4276 45.9562 24.5489 47.2657 24.5784 48.5866C24.5809 48.7612 24.631 48.9317 24.7232 49.0799C24.8155 49.228 24.9465 49.3482 25.102 49.4274C26.4675 50.1102 27.9733 50.4657 29.5 50.4657C31.0267 50.4657 32.5325 50.1102 33.898 49.4274C34.0535 49.3482 34.1845 49.228 34.2767 49.0799C34.369 48.9317 34.4191 48.7612 34.4216 48.5866C34.4511 47.2657 34.5724 45.9562 34.7854 44.6582C31.2981 45.3735 27.7019 45.3735 24.2146 44.6582Z"
                                    fill="white" />
                            </svg>
                        </div>
                        <input type="text" id="hint" name="hint" placeholder="Add a hint ..." required>

                    </div>
                    <div id="button-holder-2">
                        <div class="button-holder">
                            <button class="btx-white-reverse" id="back-button-2">Back</button>
                            <button class="btx-white" id="next-button-2">Next</button>
                        </div>
                        <div class="button-holder">
                            <button class="btx-white" id="add-falshcard">Add One More</button>
                            <button type="submit" class="btx-white-reverse">Finish Set</button>
                        </div>


                    </div>
                </div>

            </form>
        </div>
        <div class="flash-image"></div>
    </div>
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
                <a href="contact.php">contact</a>
            </div>
            <div class="gap-footer">
                <h4>Categories</h4>
                <a href="#">History</a>
                <a href="">Geography</a>
                <a href="">Language</a>
                <a href="">Science</a>
                <a href="">Literature</a>
            </div>
        </div>
        <p>© 2025 Memora. All rights reserved.</p>
    </footer>
</body>

</html>