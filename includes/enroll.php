<?php
require_once 'db.php';
function enroll_student($user_id, $course_id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM enrollments WHERE user_id=? AND course_id=?");
    $stmt->bind_param('ii', $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        return ['status'=>'error','message'=>'Already enrolled'];
    }
    $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $user_id, $course_id);
    if ($stmt->execute()) {
        return ['status'=>'success','message'=>'Enrolled successfully'];
    } else {
        return ['status'=>'error','message'=>'Enrollment failed'];
    }
}
// Example usage:
// $response = enroll_student(1, 2);
// echo json_encode($response);
