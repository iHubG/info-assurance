<?php
session_start();

require 'db.php';

$errors = [];

// Validate username
if (empty($_POST['username'])) {
    $errors['username'] = "Username is required";
} else {
    $username = $_POST['username'];
}

// Validate password
if (empty($_POST['password'])) {
    $errors['password'] = "Password is required";
} else {
    $password = $_POST['password'];
}

// Redirect if there are errors
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: admin.view.php");
    exit(); // Exit immediately after redirection
}

// Function to sanitize input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    try {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, start a new session
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Clear remember cookie if exists
            setcookie('admin_credentials', '', time() - 3600, '/');

            if (isset($_POST['rememberMe'])){
                // Set a cookie to remember the username (not the password for security)
                $cookieData = ['username' => $username];
                $cookieValue = json_encode($cookieData);
                setcookie('admin_credentials', $cookieValue, time() + (86400 * 7), "/"); // Cookie lasts for 7 days
            }

            // Redirect to the dashboard
            header('Location: admin-student.view.php');
            exit();
        } else {
            $errors['login'] = "Invalid username or password";
        }
    } catch (PDOException $e) {
        // Handle database errors
        $errors['login'] = 'An error occurred: ' . $e->getMessage();
    }

    // Save errors in session for displaying on the form
    $_SESSION['errors'] = $errors;
    $_SESSION['form_data'] = $_POST;

    // Redirect back to the login page
    header("Location: admin.view.php");
    exit();
}

