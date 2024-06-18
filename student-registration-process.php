<?php

require 'db.php';
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate form fields
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dbirth = $_POST['dbirth'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Function to insert a new instructor record
    function insertStudent($pdo, $fname, $lname, $dbirth, $username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO student (first_name, last_name, date_of_birth, username, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$fname, $lname, $dbirth, $username, $hashedPassword]);
        return $pdo->lastInsertId();
    }

      // Function to check if username already exists
      function isUsernameExists($pdo, $username) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM student WHERE username = ?");
        $stmt->execute([$username]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Check if username already exists
    if (isUsernameExists($pdo, $username)) {
        // Username already exists, return an error message
        http_response_code(400); // Bad Request
        echo "Username already exists";
        exit;
    }

    // Get the current date and time
    $dateCreated = date('Y-m-d H:i:s');

    // Read existing JSON data from credentials.json
    $existing_data = file_get_contents('./student_credentials.json');
    $existing_credentials = json_decode($existing_data, true);

    // Append new instructor credentials to existing data
    $student_credentials = array(
        'fname' => $fname,
        'lname' => $lname,
        'dbirth' => $dbirth,
        'username' => $username,
        'password' => '*******',
        'date_created' => $dateCreated,
    );
    $existing_credentials[] = $student_credentials;

    // Encode the combined data as JSON
    $json_data = json_encode($existing_credentials, JSON_PRETTY_PRINT);

    // Write JSON data back to credentials.json
    $result = file_put_contents('./student_credentials.json', $json_data);

    require 'db.php';
    
    // Insert the new student record
    $studentId = insertStudent($pdo, $fname, $lname, $dbirth, $username, $password);

} else {
    // If there are validation errors, return them as JSON
    http_response_code(400); // Set HTTP response status code to 400 (Bad Request)
    echo json_encode($errors); // Return validation errors as JSON
}


