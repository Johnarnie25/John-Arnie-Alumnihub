<?php
include '../../admin/db_connect.php';

$currentUserId = isset($_GET['user_id']) ? $_GET['user_id'] : null;

if ($currentUserId) {
    $sql = "SELECT u.id, u.name, u.username, u.type, a.id AS alumnus_id, a.firstname, a.lastname, a.batch, a.course_id, a.avatar,
            MAX(cm.timestamp) AS latest_timestamp,
            SUBSTRING_INDEX(GROUP_CONCAT(cm.message ORDER BY cm.timestamp DESC), ',', 1) AS latest_message
            FROM users u
            LEFT JOIN alumnus_bio a ON u.alumnus_id = a.id
            LEFT JOIN chat_messages cm ON (u.id = cm.sender_id AND cm.receiver_id = '$currentUserId')
                                        OR (u.id = cm.receiver_id AND cm.sender_id = '$currentUserId')
            WHERE cm.id IS NOT NULL
            GROUP BY u.id, u.name, u.username, u.type, a.id, a.firstname, a.lastname, a.batch, a.course_id, a.avatar
            ORDER BY latest_timestamp DESC";

    $result = $conn->query($sql);

    if ($result === false) {
        $response = array('status' => 'error', 'message' => 'Error executing the query: ' . $conn->error);
        die(json_encode($response));
    } else {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        $response = array('status' => 'success', 'users' => $users);
        die(json_encode($response));
    }
} else {
    $response = array('status' => 'error', 'message' => 'User not authenticated');
    die(json_encode($response));
}
?>
