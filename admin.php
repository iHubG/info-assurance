<?php 
require 'db.php';

$adminUsername = 'testadmin';
$adminPassword = 'admin_password@12345'; // Replace with actual password input from your form

// Hash the password
$hashedPassword = password_hash($adminPassword, PASSWORD_DEFAULT);

// Insert admin record into the database
$stmt = $pdo->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
$stmt->execute([$adminUsername, $hashedPassword]);

echo "Admin added successfully.";