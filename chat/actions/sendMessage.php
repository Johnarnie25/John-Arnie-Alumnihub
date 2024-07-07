<?php
include '../../admin/db_connect.php';

$senderId = isset($_POST['sender_id']) ? $_POST['sender_id'] : null;
$receiverId = isset($_POST['receiver_id']) ? $_POST['receiver_id'] : null;
$message = isset($_POST['message']) ? $_POST['message'] : '';

if ($senderId && $receiverId && $message) {
    $message = mysqli_real_escape_string($conn, $message);

    $sql = "INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES ('$senderId', '$receiverId', '$message')";
    if ($conn->query($sql) === TRUE) {
        $response = array('status' => 'success', 'message' => 'Message sent successfully');
        die(json_encode($response));

    } else {
        $response = array('status' => 'error', 'message' => 'Error: ' . $conn->error);
        die(json_encode($response));
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid data');
    die(json_encode($response));
}
?>
