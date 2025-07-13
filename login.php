<?php
require_once 'includes/db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    // Demo accounts
    $demo = [
      'admin' => ['code' => '1234'],
      'lecturer' => ['email' => 'lecturer@demo.com', 'password' => 'lecturer123'],
      'student' => ['matricule' => 'S123456', 'password' => 'student123']
    ];
    if ($role === 'student') {
        $matricule = $_POST['matricule'];
        $password = $_POST['password'];
        if ($matricule === $demo['student']['matricule'] && $password === $demo['student']['password']) {
            $_SESSION['user_id'] = 1;
            $_SESSION['role'] = 'student';
            header('Location: student/dashboard.html');
            exit;
        }
        echo '<script>window.onload=function(){document.getElementById("errorMsg").textContent="Invalid matricule or password.";}</script>';
    } elseif ($role === 'lecturer') {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if ($email === $demo['lecturer']['email'] && $password === $demo['lecturer']['password']) {
            $_SESSION['user_id'] = 2;
            $_SESSION['role'] = 'lecturer';
            header('Location: lecturer-dashboard.html');
            exit;
        }
        echo '<script>window.onload=function(){document.getElementById("errorMsg").textContent="Invalid email or password.";}</script>';
    } elseif ($role === 'admin') {
        $admin_code = $_POST['admin_code'];
        if ($admin_code === $demo['admin']['code']) {
            $_SESSION['role'] = 'admin';
            header('Location: admin/dashboard.html');
            exit;
        } else {
            echo '<script>window.onload=function(){document.getElementById("errorMsg").textContent="Invalid admin code.";}</script>';
        }
    }
}
