<?php
session_start(); // Start the session
require 'connexion.php';

// Check if connection failed
if ($conn->connect_error) {
    echo "<script>
        alert('Database Error\\n\\nCannot connect to database. Please try again later or contact support.');
        window.location.href = '../html/signin.php';
    </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Escape user input to prevent SQL injection
    $email = $conn->real_escape_string($email);

    // Query to check if the email exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify the password using password_verify()
        if (password_verify($password, $user['password'])) {
            // Store user information in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_firstname'] = $user['firstname'];
            $_SESSION['user_lastname'] = $user['lastname'];
            $_SESSION['user_creator'] = $user['creator']; // Store creator status
            echo "<script>
            alert('Welcome Back!\\n\\nYou have successfully signed in to Memora.\\nRedirecting to your dashboard...');
            window.location.href = '../index.php';
          </script>";
            exit();
        } else {
            // Incorrect password
            echo "<script>
                    alert('Incorrect Password\\n\\nThe password you entered is incorrect.\\n\\nPlease try again or click \\'Forgot Password\\' to reset it.');
                    window.location.href = '../html/signin.php';
                  </script>";
            exit();
        }
    } else {
        // Email not found
        echo "<script>
                alert('Account Not Found\\n\\nNo account exists with this email address.\\n\\nWould you like to create a new account?');
                window.location.href = '../html/signup.php';
              </script>";
        exit();
    }
}

// Close the database connection
$conn->close();
?>