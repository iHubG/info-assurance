<?php

session_start();
require 'db.php';

if (isset($_POST['update'])) {
    // Check if the student ID is provided
    if (isset($_POST['id_update'])) {
        // Sanitize the student ID
        $studentID = filter_var($_POST['id_update'], FILTER_SANITIZE_NUMBER_INT);

        // Validate session username (if necessary)
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }

        // Sanitize and validate other inputs
        $firstName = htmlspecialchars($_POST['firstName']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $dbirth = htmlspecialchars($_POST['dbirth']);
        $username = htmlspecialchars($_POST['username']);

        // Prepare the update query for the student's profile
        $updateProfileQuery = "UPDATE student SET first_name = :first_name, last_name = :last_name, date_of_birth = :date_of_birth, username = :username WHERE id = :id";
        $statement = $pdo->prepare($updateProfileQuery);
        // Bind parameters for the student's profile update
        $statement->bindParam(':first_name', $firstName);
        $statement->bindParam(':last_name', $lastName);
        $statement->bindParam(':date_of_birth', $dbirth);
        $statement->bindParam(':username', $username);
        $statement->bindParam(':id', $studentID);
  
        // Execute the update query
        if ($statement->execute()) {
            header('Location: admin-student.view.php');
            exit(); // Ensure script execution stops after redirect
        } else {
            // Handle update failure
            $status = 'Failed to update student.';
        }
    } else {
        // student ID is not provided
        $status = 'Student ID is not provided.';
    }
}

// Display status message if needed
if (isset($status)) {
    echo htmlspecialchars($status);
}

