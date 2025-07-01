<?php
require_once 'includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $department = $conn->real_escape_string($_POST['department']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];
    if ($password !== $confirm) {
        die('Passwords do not match.');
    }
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        die('Email already exists.');
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 'student';
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, department, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssssss', $fullname, $email, $phone, $department, $hash, $role);
    if ($stmt->execute()) {
        echo 'Registration successful!';
    } else {
        echo 'Registration failed.';
    }
}
