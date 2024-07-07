<?php
include 'admin/db_connect.php';
$json = file_get_contents('php://input');
$data = json_decode($json,true);

$newPassword = isset($data['newPassword']) ? $data['newPassword'] : '';
$email = isset($data['email']) ? $data['email'] : '';

if (empty($newPassword) || empty($email)) {
    die('Invalid input.');
} else {
    $hashedPassword = md5($newPassword);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    $result = $stmt->execute();

    if ($result) {
        die('Password reset successfully.');
    } else {
        die('Password reset failed. Please try again.');
    }

}
?>
