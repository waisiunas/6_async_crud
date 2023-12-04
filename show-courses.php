<?php
require_once './database/connection.php';
$sql = "SELECT * FROM `courses`";
$result = $conn->query($sql);
$courses = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($courses);