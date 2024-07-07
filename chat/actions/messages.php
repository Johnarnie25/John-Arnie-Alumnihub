<?php
include '../../admin/db_connect.php';

$currentUserId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

$friendId = isset($_GET['friend_id']) ? $_GET['friend_id'] : null;

if ($currentUserId && $friendId) {
    $sql = "SELECT * FROM chat_messages
            WHERE (sender_id = '$currentUserId' AND receiver_id = '$friendId')
            OR (sender_id = '$friendId' AND receiver_id = '$currentUserId')
            ORDER BY timestamp ASC";

    $result = $conn->query($sql);

    if ($result === false) {
        $response = array('status' => 'error', 'message' => 'Error executing the query: ' . $conn->error);
        die(json_encode($response));
    } else {
        $messages = array();
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }

        $response = array('status' => 'success', 'messages' => $messages);
        die(json_encode($response));
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid user IDs');
    die(json_encode($response));
}

?>
