<?php
require_once '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $course_id = intval($_POST['course_id']);
    $file = $_FILES['material'];
    $allowed = ['pdf', 'mp4'];
    $maxSize = 20 * 1024 * 1024;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        die('Invalid file type.');
    }
    if ($file['size'] > $maxSize) {
        die('File too large.');
    }
    $filename = uniqid() . '.' . $ext;
    $path = '../uploads/' . $filename;
    if (move_uploaded_file($file['tmp_name'], $path)) {
        $stmt = $conn->prepare("INSERT INTO materials (course_id, title, path, type) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('isss', $course_id, $title, $filename, $ext);
        $stmt->execute();
        echo 'Upload successful!';
    } else {
        echo 'Upload failed.';
    }
}
