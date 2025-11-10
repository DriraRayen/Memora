<?php

require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the HTML form
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>
                alert('Password Mismatch\\n\\nThe passwords you entered do not match. Please make sure both password fields are identical.');
                window.location.href = '../html/signup.php';
              </script>";
        exit();
    } else {
        // Escape user input to prevent SQL injection
        $firstname = $conn->real_escape_string($firstname);
        $lastname = $conn->real_escape_string($lastname);
        $email = $conn->real_escape_string($email);

        // Check if the email already exists
        $check_email_sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($check_email_sql);

        if ($result->num_rows > 0) {
            // Email already exists
            echo "<script>
                    alert('Email Already Registered\\n\\nThis email address is already associated with an account.\\n\\nPlease sign in or use a different email address.');
                    window.location.href = '../html/signup.php';
                  </script>";
            exit();
        } else {
            // Hash the password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into the database
            $sql = "INSERT INTO users (firstname, lastname, email, password) VALUES ('$firstname', '$lastname', '$email', '$hashed_password')";

            if ($conn->query($sql) === TRUE) {
                echo "<script>
                        alert('Welcome to Memora!\\n\\nYour account has been created successfully.\\nRedirecting you to the login page...');
                        window.location.href = '../html/signin.php';
                      </script>";
                exit();
            } else {
                // Handle database insertion error
                echo "<script>
                        alert('Registration Failed\\n\\nWe encountered an error while creating your account.\\n\\nPlease try again in a few moments or contact support if the problem persists.');
                        window.location.href = '../html/signup.php';
                      </script>";
                exit();
            }
        }
    }
}

// Close the database connection
$conn->close();
?>