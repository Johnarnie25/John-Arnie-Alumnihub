<?php
include '../../admin/db_connect.php';

$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT u.id, u.name, u.username, u.type, a.id AS alumnus_id, a.firstname, a.lastname, a.batch, a.course_id, a.avatar
        FROM users u
        LEFT JOIN alumnus_bio a ON u.alumnus_id = a.id
        WHERE u.name REGEXP '$searchTerm'
        ORDER BY u.name";

$result = $conn->query($sql);

if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

$rows = array();
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

header('Content-Type: application/json');
die(json_encode($rows));
?>
