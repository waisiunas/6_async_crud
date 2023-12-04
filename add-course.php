<?php
require_once './database/connection.php';

$_POST = json_decode(file_get_contents("php://input"), true);

if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $duration = htmlspecialchars($_POST['duration']);

    if (empty($name)) {
        echo json_encode(['nameError' => "Enter course name from PHP!"]);
    } elseif(empty($duration)) {
        echo json_encode(['durationError' => "Enter course duration from PHP!"]);
    } else {
        $sql = "INSERT INTO `courses`(`name`, `duration`) VALUES ('$name','$duration')";
        if ($conn->query($sql)) {
            echo json_encode(['success' => "Magic has been spelled!"]);
        } else {
            echo json_encode(['failure' => "Magic has failed to spell!"]);
        }
    }
}

?>