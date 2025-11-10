<?php
if (isset($_GET['set_id'])) {
    $id = $_GET['set_id'];
    echo "<script>console.log('ID: $id');</script>";
    // Include the database connection file
    require '../php/connexion.php'; // Adjust the path as necessary

    // Start the session
    session_start(); // Start the session at the very beginning 

    $isCreator = isset($_SESSION['user_creator']) && $_SESSION['user_creator'] == 1;

    // Check if user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>
                    alert('Sign In Required\\n\\nYou need to be logged in to access flashcard sets.\\n\\nPlease sign in to continue learning!');
                    window.location.href = 'signin.php';
                  </script>";
        exit();
    } else {
        // Debugging: Log the user_id
        error_log("User ID: " . $_SESSION['user_id']);
    }

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch flashcard set details from the database using the provided set ID
    $query = "SELECT * FROM flashcard_sets WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $set_details = $result->fetch_assoc();
        $flashcards_query = "SELECT * FROM flashcards WHERE set_id = ?";
        $stmt_flashcards = $conn->prepare($flashcards_query);
        $stmt_flashcards->bind_param("i", $id);
        $stmt_flashcards->execute();
        $flashcards_result = $stmt_flashcards->get_result();
        $flashcards = [];

        while ($row = $flashcards_result->fetch_assoc()) {
            $flashcards[] = $row;
        }
    } else {
        echo "<script>
                alert('Flashcard Set Not Found\\n\\nThis flashcard set doesn\\'t exist or you don\\'t have permission to access it.\\n\\nPlease check the link and try again.');
                window.location.href = 'browse.php';
              </script>";
        exit();
    }
} else {
    echo "<script>
            alert('Invalid Request\\n\\nNo flashcard set was specified.\\n\\nPlease select a flashcard set from the browse page.');
            window.location.href = 'browse.php';
          </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="..\css\main.css">
    <link rel="stylesheet" href="..\css\button.css">
    <link rel="stylesheet" href="..\css\create.css">
    <link rel="stylesheet" href="..\css\custom-input.css">
    <link rel="stylesheet" href="..\css\flipper.css">
    <link rel="icon" href="..\img\logo.png" type="image/x-icon">
    <link rel="stylesheet" href="..\css\quiz.css">
    <script src="..\js\navigation.js"></script>
    <script src="..\js\quiz.js"></script>
    <script src=..\js\logout.js></script>
    <title>Revise</title>
    <style>
        .flash-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 255, 0, 0.5);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .flash-overlay.active {
            opacity: 1;
        }

        .wrong-flash-effect {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 0, 0, 0.5);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .wrong-flash-effect.active {
            opacity: 1;
        }

        .hint {
            display: none;
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 10px;
        }

        .hint.visible {
            display: block;
        }

        .hint-toggle {
            cursor: pointer;
        }
    </style>
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
    <?php
    // Assuming database connection and flashcard data are already fetched as in your provided code
    // $flashcards contains the array of flashcard data from the database
    // $id contains the set_id from $_GET['set_id']
    
    // Start output buffering to capture HTML
    ob_start();
    ?>

    <div class="revise">
        <h2 class="big-title"><span class="blue">Lets</span> Revise <span class="blue">!</span></h2>
        <div class="revise-holder">
            <?php if (!empty($flashcards)): ?>
                <div class="flip-card">
                    <div class="flip-card-inner" id="flipCard">
                        <div class="flashcard flip-card-front">
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
                            <p class="question"><?php echo htmlspecialchars($flashcards[0]['question']); ?></p>
                            <button class="btx-blue"
                                onclick="document.getElementById('flipCard').classList.toggle('flipped')">Flip</button>
                        </div>
                        <div class="flashcard flip-card-back">
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
                            <p class="answer"><?php echo htmlspecialchars($flashcards[0]['answer']); ?></p>
                            <button class="btx-blue-reverse"
                                onclick="document.getElementById('flipCard').classList.toggle('flipped')">Flip</button>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <p>No flashcards found in this set.</p>
            <?php endif; ?>
        </div>
        <div class="revise-holder-2">
            <button class="btx-blue-reverse" id="back-button">BACK</button>
            <div class="scroll-holder">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="32" viewBox="0 0 25 32" fill="none">
                    <path
                        d="M2.47108 20.0993C-0.243769 18.1011 -0.243772 14.0438 2.47108 12.0456L17.0361 1.32536C20.3378 -1.10472 25 1.25269 25 5.35221V26.7927C25 30.8922 20.3378 33.2496 17.0361 30.8196L2.47108 20.0993Z"
                        fill="white" />
                </svg>
                <p class="scroll"><span id="current-number-flashcard">01</span>/ <span
                        id="total-number-flashcard"><?php echo sprintf("%02d", count($flashcards)); ?></span>
                </p>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="32" viewBox="0 0 25 32" fill="none">
                    <path
                        d="M22.5289 12.0456C25.2438 14.0438 25.2438 18.1011 22.5289 20.0993L7.96387 30.8195C4.66224 33.2496 0 30.8922 0 26.7927L0 5.35219C0 1.25268 4.66223 -1.10473 7.96386 1.32535L22.5289 12.0456Z"
                        fill="white" />
                </svg>
            </div>
            <button class="btx-blue-reverse" id="quiz-button">QUIZ</button>
        </div>
    </div>

    <?php
    // Output the buffered content
    ob_end_flush();
    ?>
    <!-- Quiz Parameters -->
    <div class="container" id="quiz-container" style="display:none;">
        <form id="quiz-form">
            <div class="quiz">
                <h2 class="medium-title"><span class="blue">Quiz </span>Parameters</h2>
                <div class="quiz-parameter-holder">
                    <div class="quiz-parameter">
                        <div>
                            <input type="radio" name="quiz-level" id="quiz-level-easy" value="easy" checked
                                onchange="updateQuizOptions(this.value)">
                            <label for="quiz-level-easy">Easy</label>
                        </div>
                        <div>
                            <input type="radio" name="quiz-level" id="quiz-level-medium" value="medium"
                                onchange="updateQuizOptions(this.value)">
                            <label for="quiz-level-medium">Medium</label>
                        </div>
                        <div>
                            <input type="radio" name="quiz-level" id="quiz-level-hard" value="hard"
                                onchange="updateQuizOptions(this.value)">
                            <label for="quiz-level-hard">Hard</label>
                        </div>
                    </div>
                    <div class="quiz-parameter">
                        <div>
                            <input type="checkbox" name="quiz-type" id="quiz-type-mc" value="multiple-choice" checked
                                disabled>
                            <label for="quiz-type-mc">Multiple Choice</label>
                        </div>
                        <div>
                            <input type="checkbox" name="quiz-type" id="quiz-type-timer" value="timer">
                            <label for="quiz-type-timer">Timer</label>
                        </div>
                        <div>
                            <input type="checkbox" name="quiz-type" id="quiz-type-hint" value="hint">
                            <label for="quiz-type-hint">Hints</label>
                        </div>
                    </div>
                </div>
                <div class="button-holder">
                    <button class="btx-blue" type="submit" id="start-button">Start</button>
                    <button class="btx-blue-reverse" id="cancel-button" type="button">Cancel</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quiz Execution -->
    <div class="container" id="quiz-execute" style="display: none;">
        <h2 class="big-title"><span class="blue">Quiz</span> Time <span class="blue">!</span></h2>
        <div class="flash-group">
            <div class="flip-card">
                <div class="flip-card-inner" id="flipCard">
                    <div class="flashcard flip-card-front">
                        <div class="flash-header">
                            <svg class="hint-toggle" xmlns="http://www.w3.org/2000/svg" width="43" height="43"
                                viewBox="0 0 43 43" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M26.617 28.1041L26.4378 28.552C23.233 29.6224 19.767 29.6224 16.5622 28.552L16.383 28.1041C16.2128 27.692 16.1268 27.4842 15.9781 27.2942C15.8312 27.1025 15.5732 26.909 15.0572 26.5238C13.2504 25.1711 11.9153 23.2841 11.241 21.1302C10.5667 18.9763 10.5874 16.6647 11.3002 14.5233C12.0131 12.3818 13.3818 10.519 15.2125 9.19891C17.0432 7.87884 19.243 7.16846 21.5 7.16846C23.757 7.16846 25.9568 7.87884 27.7875 9.19891C29.6182 10.519 30.9869 12.3818 31.6998 14.5233C32.4126 16.6647 32.4333 18.9763 31.759 21.1302C31.0847 23.2841 29.7496 25.1711 27.9428 26.5238C27.4268 26.909 27.1688 27.1025 27.0219 27.2942C26.875 27.486 26.789 27.6902 26.617 28.1041ZM17.6479 32.5474C17.8032 33.4934 17.8916 34.4478 17.9131 35.4105C17.9149 35.5377 17.9514 35.662 18.0186 35.77C18.0859 35.8779 18.1813 35.9655 18.2947 36.0232C19.2899 36.5209 20.3873 36.78 21.5 36.78C22.6127 36.78 23.7101 36.5209 24.7053 36.0232C24.8187 35.9655 24.9141 35.8779 24.9814 35.77C25.0486 35.662 25.0851 35.5377 25.0869 35.4105C25.1084 34.4478 25.1968 33.4934 25.3521 32.5474C22.8105 33.0687 20.1895 33.0687 17.6479 32.5474Z"
                                    fill="white" />
                            </svg>
                            <p>Front</p>
                            <p class="flash-number">01</p>
                        </div>
                        <p class="question">
                            <?php echo !empty($flashcards) ? htmlspecialchars($flashcards[0]['question']) : ''; ?>
                        </p>
                        <span class="hint"
                            id="hint-text"><?php echo !empty($flashcards) ? htmlspecialchars($flashcards[0]['hint']) : ''; ?></span>
                    </div>
                    <div class="flashcard flip-card-back">
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
                        <p class="answer">
                            <?php echo !empty($flashcards) ? htmlspecialchars($flashcards[0]['option_1']) : ''; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="flashcard" id="flashcard-quiz">
                <div class="flash-header" id="flash-header-1">
                    <p><span class="Difficulty">Hard</span> Mode</p>
                </div>
                <button class="btx-white-reverse" id="answer-1"></button>
                <button class="btx-white-reverse" id="answer-2"></button>
                <button class="btx-white-reverse" id="answer-3"></button>
                <button class="btx-white-reverse" id="answer-4"></button>
            </div>
        </div>
        <div class="revise-holder-2">
            <button class="btx-blue-reverse" id="cancel-button-2">Cancel</button>
            <div class="scroll-holder">
                <p class="scroll"><span class="flash-number">01</span>/ <span
                        id="total-number-flashcard"><?php echo sprintf("%02d", count($flashcards)); ?></span></p>
            </div>
            <div id="timer-container" class="timer btx-blue-reverse"></div>
            <button class="btx-blue-reverse" id="flip-button">Skip</button>
        </div>
    </div>

    <!-- Quiz Results -->
    <div class="container" id="quiz-result" style="display: none;">
        <div class="quiz">
            <h2 class="big-title"><span class="blue">Great</span> Job <span class="blue">!</span></h2>
            <div class="quiz-result-holder">
                <div class="quiz-result">
                    <div class="quiz-stats">
                        <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                            <path
                                d="M12.1875 33.75H10.4375C10.0894 33.75 9.75556 33.6117 9.50942 33.3656C9.26328 33.1194 9.125 32.7856 9.125 32.4375V24.5625C9.125 24.2144 9.26328 23.8806 9.50942 23.6344C9.75556 23.3883 10.0894 23.25 10.4375 23.25H12.1875C12.5356 23.25 12.8694 23.3883 13.1156 23.6344C13.3617 23.8806 13.5 24.2144 13.5 24.5625V32.4375C13.5 32.7856 13.3617 33.1194 13.1156 33.3656C12.8694 33.6117 12.5356 33.75 12.1875 33.75ZM24.4375 33.75H22.6875C22.3394 33.75 22.0056 33.6117 21.7594 33.3656C21.5133 33.1194 21.375 32.7856 21.375 32.4375V19.3125C21.375 18.9644 21.5133 18.6306 21.7594 18.3844C22.0056 18.1383 22.3394 18 22.6875 18H24.4375C24.7856 18 25.1194 18.1383 25.3656 18.3844C25.6117 18.6306 25.75 18.9644 25.75 19.3125V32.4375C25.75 32.7856 25.6117 33.1194 25.3656 33.3656C25.1194 33.6117 24.7856 33.75 24.4375 33.75ZM30.5625 33.75H28.8125C28.4644 33.75 28.1306 33.6117 27.8844 33.3656C27.6383 33.1194 27.5 32.7856 27.5 32.4375V13.1875C27.5 12.8394 27.6383 12.5056 27.8844 12.2594C28.1306 12.0133 28.4644 11.875 28.8125 11.875H30.5625C30.9106 11.875 31.2444 12.0133 31.4906 12.2594C31.7367 12.5056 31.875 12.8394 31.875 13.1875V32.4375C31.875 32.7856 31.7367 33.1194 31.4906 33.3656C31.2444 33.6117 30.9106 33.75 30.5625 33.75ZM18.3125 33.75H16.5625C16.2144 33.75 15.8806 33.6117 15.6344 33.3656C15.3883 33.1194 15.25 32.7856 15.25 32.4375V8.8125C15.25 8.4644 15.3883 8.13056 15.6344 7.88442C15.8806 7.63828 16.2144 7.5 16.5625 7.5H18.3125C18.6606 7.5 18.9944 7.63828 19.2406 7.88442C19.4867 8.13056 19.625 8.4644 19.625 8.8125V32.4375C19.625 32.7856 19.4867 33.1194 19.2406 33.3656C18.9944 33.6117 18.6606 33.75 18.3125 33.75Z"
                                fill="white" />
                        </svg>
                        <p><span id="correct-number-flashcard">01</span>/ <span
                                id="total-number-flashcard"><?php echo sprintf("%02d", count($flashcards)); ?></span>
                        </p>
                    </div>
                    <div class="quiz-stats">
                        <svg xmlns="http://www.w3.org/2000/svg" width="42" height="42" viewBox="0 0 42 42" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M36.3125 29.2495C36.3103 29.3334 36.3022 29.417 36.288 29.4998C36.3249 29.6897 36.3193 29.8855 36.2717 30.0731C36.224 30.2607 36.1355 30.4354 36.0124 30.5848C35.8893 30.7341 35.7347 30.8544 35.5597 30.937C35.3847 31.0196 35.1935 31.0624 35 31.0625H10.5C10.2127 31.0625 9.92828 31.1191 9.66288 31.229C9.39748 31.3389 9.15633 31.5001 8.9532 31.7032C8.75008 31.9063 8.58895 32.1475 8.47901 32.4129C8.36908 32.6783 8.3125 32.9627 8.3125 33.25C8.3125 33.5373 8.36908 33.8217 8.47901 34.0871C8.58895 34.3525 8.75008 34.5937 8.9532 34.7968C9.15633 34.9999 9.39748 35.1611 9.66288 35.271C9.92828 35.3809 10.2127 35.4375 10.5 35.4375H35C35.3481 35.4375 35.6819 35.5758 35.9281 35.8219C36.1742 36.0681 36.3125 36.4019 36.3125 36.75C36.3125 37.0981 36.1742 37.4319 35.9281 37.6781C35.6819 37.9242 35.3481 38.0625 35 38.0625H10.5C9.22365 38.0625 7.99957 37.5555 7.09705 36.653C6.19453 35.7504 5.6875 34.5264 5.6875 33.25V8.75C5.6875 7.47365 6.19453 6.24957 7.09705 5.34705C7.99957 4.44453 9.22365 3.9375 10.5 3.9375H33.95C35.2555 3.9375 36.3125 4.9945 36.3125 6.3V29.2495ZM15.75 10.9375C15.4019 10.9375 15.0681 11.0758 14.8219 11.3219C14.5758 11.5681 14.4375 11.9019 14.4375 12.25C14.4375 12.5981 14.5758 12.9319 14.8219 13.1781C15.0681 13.4242 15.4019 13.5625 15.75 13.5625H26.25C26.5981 13.5625 26.9319 13.4242 27.1781 13.1781C27.4242 12.9319 27.5625 12.5981 27.5625 12.25C27.5625 11.9019 27.4242 11.5681 27.1781 11.3219C26.9319 11.0758 26.5981 10.9375 26.25 10.9375H15.75Z"
                                fill="white" />
                        </svg>
                        <p class="topic"><?php echo htmlspecialchars($set_details['title'] ?? 'Unknown'); ?></p>
                    </div>
                    <div class="quiz-stats">
                        <svg xmlns="http://www.w3.org/2000/svg" width="41" height="42" viewBox="0 0 41 42" fill="none">
                            <path
                                d="M17.9378 27.5625H23.0628L20.5003 22.3125L17.9378 27.5625ZM14.5212 22.75C15.4607 22.75 16.2654 22.4076 16.935 21.7228C17.6047 21.0379 17.939 20.2137 17.9378 19.25C17.9367 18.2863 17.6024 17.4627 16.935 16.779C16.2677 16.0953 15.463 15.7523 14.5212 15.75C13.5793 15.7477 12.7752 16.0907 12.109 16.779C11.4427 17.4673 11.1079 18.291 11.1045 19.25C11.1011 20.209 11.4359 21.0333 12.109 21.7228C12.7821 22.4123 13.5861 22.7547 14.5212 22.75ZM26.4795 22.75C27.4191 22.75 28.2237 22.4076 28.8934 21.7228C29.563 21.0379 29.8973 20.2137 29.8962 19.25C29.895 18.2863 29.5608 17.4627 28.8934 16.779C28.226 16.0953 27.4214 15.7523 26.4795 15.75C25.5376 15.7477 24.7336 16.0907 24.0673 16.779C23.4011 17.4673 23.0662 18.291 23.0628 19.25C23.0594 20.209 23.3942 21.0333 24.0673 21.7228C24.7404 22.4123 25.5445 22.7547 26.4795 22.75ZM10.2503 38.5V31.0625C9.13992 30.5667 8.16446 29.9034 7.32396 29.0728C6.48346 28.2421 5.77165 27.3012 5.18854 26.25C4.60543 25.1988 4.16411 24.0759 3.86458 22.8812C3.56505 21.6866 3.41586 20.4762 3.417 19.25C3.417 14.6417 5.01144 10.8646 8.20033 7.91875C11.3892 4.97292 15.4892 3.5 20.5003 3.5C25.5114 3.5 29.6114 4.97292 32.8003 7.91875C35.9892 10.8646 37.5837 14.6417 37.5837 19.25C37.5837 20.475 37.4345 21.6854 37.1361 22.8812C36.8377 24.0771 36.3964 25.2 35.8121 26.25C35.2279 27.3 34.5161 28.2409 33.6767 29.0728C32.8373 29.9046 31.8619 30.5678 30.7503 31.0625V38.5H25.6253V35H22.2087V38.5H18.792V35H15.3753V38.5H10.2503Z"
                                fill="white" />
                        </svg>
                        <p class="difficulty"><span class="Difficulty">Hard</span></p>
                    </div>
                </div>
                <div class="score-holder-out">
                    <div class="score-holder-in">
                        <div class="score-percentage"><span class="score"><span id="score-percentage">0</span><span
                                    class="blue">%</span></span></div>
                    </div>
                </div>
            </div>
            <div class="button-holder">
                <button class="btx-blue" id="score-button">Confirm</button>
                <button class="btx-white-reverse" id="retry-button">Retake</button>
            </div>
        </div>
    </div>

    <!-- Flash Overlay for Correct Answer -->
    <div class="flash-overlay" id="flash-overlay"></div>
    <div class="flash-image"></div>
    <div class="wrong-flash-effect" id="wrong-flash-effect"></div>
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
    <!-- JavaScript -->
    <script>
        <?php
        echo "const flashcards = " . (isset($flashcards) ? json_encode($flashcards) : '[]') . ";";
        ?>
        const hint = document.getElementById('quiz-type-hint');
        const timer = document.getElementById('quiz-type-timer');
        const mc = document.getElementById('quiz-type-mc');

        function updateQuizOptions(level) {
            switch (level) {
                case "easy":
                    hint.checked = true;
                    timer.checked = false;
                    mc.checked = true;
                    hint.disabled = true;
                    timer.disabled = true;
                    mc.disabled = true;
                    break;
                case "medium":
                    hint.checked = true;
                    timer.checked = true;
                    mc.checked = true;
                    hint.disabled = true;
                    timer.disabled = true;
                    mc.disabled = true;
                    break;
                case "hard":
                    hint.checked = false;
                    timer.checked = true;
                    mc.checked = true;
                    hint.disabled = true;
                    timer.disabled = true;
                    mc.disabled = true;
                    break;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const reviseDiv = document.querySelector(".revise");
            const quizContainer = document.getElementById('quiz-container');
            const quizExecute = document.getElementById('quiz-execute');
            const quizResult = document.getElementById('quiz-result');
            const startButton = document.getElementById('start-button');
            const cancelButton = document.getElementById('cancel-button-2');

            const flipButton = document.getElementById('flip-button');
            const timerContainer = document.getElementById('timer-container');
            const flipCardInners = document.getElementsByClassName('flip-card-inner');
            const answerButtons = [
                document.getElementById('answer-1'),
                document.getElementById('answer-2'),
                document.getElementById('answer-3'),
                document.getElementById('answer-4')
            ];
            const flashOverlay = document.getElementById('flash-overlay');
            const wrongFlashEffect = document.getElementById('wrong-flash-effect');
            const currentNumber = document.getElementById('current-number-flashcard');
            const totalNumber = document.getElementById('total-number-flashcard');
            const correctNumber = document.getElementById('correct-number-flashcard');
            const scorePercentage = document.getElementById('score-percentage');
            const difficultyEl = document.querySelector('.Difficulty');
            const scoreButton = document.getElementById('score-button');
            const retryButton = document.getElementById('retry-button');

            let currentIndex = 0;
            let correctAnswers = 0;
            let timer;
            let hintVisible = false;
            const timerDurations = { easy: 0, medium: 15, hard: 10 }; // Seconds

            // Shuffle array function
            function shuffle(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            // Update quiz card
            function updateQuizCard(index, level) {
                const card = flashcards[index];
                const questionEl = document.querySelector('#quiz-execute .question');
                const answerEl = document.querySelector('#quiz-execute .answer');
                const hintEl = document.getElementById('hint-text');

                if (questionEl && answerEl && hintEl && currentNumber) {
                    // Debug log to verify the question being set
                    console.log('Setting question to:', card.question || 'No question available');
                    questionEl.textContent = card.question || 'No question available';
                    answerEl.textContent = card.option_1 || 'No answer available';
                    hintEl.textContent = card.hint || 'No hint available';
                    currentNumber.textContent = (index + 1).toString().padStart(2, '0');
                    document.querySelectorAll('.flash-number').forEach(el => {
                        el.textContent = (index + 1).toString().padStart(2, '0');
                    });

                    // Show/hide hint based on level and reset visibility
                    hintEl.classList.remove('visible');
                    hintVisible = false;
                    hintEl.style.display = ['easy', 'medium'].includes(level) ? 'block' : 'none';

                    // Randomize answer options (option_1 is correct)
                    const answers = [card.option_1, card.option_2, card.option_3, card.option_4].filter(Boolean);
                    const shuffledAnswers = shuffle([...answers]);
                    answerButtons.forEach((btn, i) => {
                        btn.textContent = shuffledAnswers[i] || 'Option not available';
                        btn.dataset.correct = shuffledAnswers[i] === card.option_1 ? 'true' : 'false';
                    });

                    // Reset flip state to ensure the front is visible initially
                    flipCardInners[1].classList.remove('flipped');

                    // Set timer or skip button based on level
                    clearInterval(timer);
                    timerContainer.style.display = timerDurations[level] > 0 ? 'block' : 'none';
                    flipButton.style.display = timerDurations[level] > 0 ? 'none' : 'block';

                    if (timerDurations[level] > 0) {
                        let timeLeft = timerDurations[level];
                        timerContainer.textContent = `0:${timeLeft.toString().padStart(2, '0')}`;
                        timer = setInterval(() => {
                            timeLeft--;
                            timerContainer.textContent = `0:${timeLeft.toString().padStart(2, '0')}`;
                            if (timeLeft <= 0) {
                                clearInterval(timer);
                                flipCardInners[1].classList.add('flipped'); // Targets the second flipCard
                                setTimeout(nextQuestion, 1000);
                            }
                        }, 1000);
                    }

                }
            }

            // Flash effect for correct answer
            function showFlashEffect() {
                flashOverlay.classList.add('active');
                setTimeout(() => {
                    flashOverlay.classList.remove('active');
                }, 300);
            }

            // Flash effect for wrong answer
            function showWrongFlashEffect() {
                wrongFlashEffect.classList.add('active');
                setTimeout(() => {
                    wrongFlashEffect.classList.remove('active');
                }, 300);
            }

            // Move to next question
            function nextQuestion() {
                currentIndex++;
                if (currentIndex < flashcards.length) {
                    updateQuizCard(currentIndex, selectedLevel);
                } else {
                    // Show results
                    quizExecute.style.display = 'none';
                    quizResult.style.display = 'block';
                    correctNumber.textContent = correctAnswers.toString().padStart(2, '0');
                    const percentage = Math.round((correctAnswers / flashcards.length) * 100);
                    scorePercentage.textContent = percentage;
                    difficultyEl.textContent = selectedLevel.charAt(0).toUpperCase() + selectedLevel.slice(1);

                    // Dynamically update the circular progress bar
                    const scoreHolderOut = document.querySelector('.score-holder-out');
                    setTimeout(() => {
                        scoreHolderOut.style.background = `conic-gradient(#31c1e1 ${percentage}%, white 0%)`;
                    }, 100);
                }
            }

            // Start quiz
            let selectedLevel = 'easy';
            startButton.addEventListener('click', (e) => {
                e.preventDefault();
                selectedLevel = document.querySelector('input[name="quiz-level"]:checked').value;
                updateQuizOptions(selectedLevel);
                difficultyEl.textContent = selectedLevel.charAt(0).toUpperCase() + selectedLevel.slice(1);

                quizContainer.style.display = 'none';
                quizExecute.style.display = 'block';
                if (flashcards.length > 0) {
                    updateQuizCard(0, selectedLevel);
                }
            });

            // Cancel quiz
            cancelButton.addEventListener('click', () => {
                clearInterval(timer);
                quizExecute.style.display = 'none';
                quizContainer.style.display = 'block';
            });

            // Skip button (move to next flashcard without flipping)
            flipButton.addEventListener('click', () => {
                clearInterval(timer);
                nextQuestion();
            });

            // Answer selection
            answerButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (btn.dataset.correct === 'true') {
                        correctAnswers++;
                        showFlashEffect();
                        clearInterval(timer);
                        flipCardInners[1].classList.add('flipped');
                        setTimeout(nextQuestion, 1000);
                    } else {
                        showWrongFlashEffect();
                        clearInterval(timer);
                        flipCardInners[1].classList.add('flipped');
                        setTimeout(nextQuestion, 1000);
                    }
                });
            });

            // Confirm results
            scoreButton.addEventListener('click', () => {
                window.location.href = 'revise.php?set_id=<?php echo $id; ?>';
            });

            // Retry quiz
            retryButton.addEventListener('click', () => {
                currentIndex = 0;
                correctAnswers = 0;
                quizResult.style.display = 'none';
                quizContainer.style.display = 'block';
            });

            // Add hint toggle on SVG click
            const hintTrigger = document.querySelector('.hint-toggle');
            hintTrigger.addEventListener('click', () => {
                if (hintEl.style.display !== 'none') {
                    hintVisible = !hintVisible;
                    hintEl.classList.toggle('visible', hintVisible);
                }
            });
        });
    </script>

    <script src="../js/flashcard.js"></script>
</body>

</html>