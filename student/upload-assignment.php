<?php
require_once '../includes/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = intval($_POST['course_id']);
    $title = $conn->real_escape_string($_POST['assignment_title']);
    $file = $_FILES['assignment_file'];
    $allowed = ['pdf', 'docx', 'zip'];
    $maxSize = 10 * 1024 * 1024;
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) {
        die('Invalid file type.');
    }
    if ($file['size'] > $maxSize) {
        die('File too large.');
    }
    $filename = uniqid() . '.' . $ext;
    $path = '../submissions/' . $filename;
    if (move_uploaded_file($file['tmp_name'], $path)) {
        $stmt = $conn->prepare("INSERT INTO submissions (course_id, title, path, type, submitted_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param('isss', $course_id, $title, $filename, $ext);
        $stmt->execute();
        echo 'Assignment submitted successfully!';
    } else {
        echo 'Upload failed.';
    }
}
