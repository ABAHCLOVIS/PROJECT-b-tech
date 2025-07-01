<?php
require_once 'includes/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash, $role);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['role'] = $role;
            if ($role === 'admin') {
                header('Location: admin/dashboard.html');
            } else {
                header('Location: student/dashboard.html');
            }
            exit();
        } else {
            echo 'Invalid credentials.';
        }
    } else {
        echo 'Invalid credentials.';
    }
}
