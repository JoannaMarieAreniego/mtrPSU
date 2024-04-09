<?php
include("0conn.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postID'];
    $currentUserId = $_SESSION['studID'];
    $reason = $_POST['reason']; // Added line to retrieve reason from POST data

    $sql = "INSERT INTO reports (postID, reporterID, reason, status) VALUES (?, ?, ?, 'Pending')"; // Updated SQL query to include reason and set status to 'Pending'
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $postId, $currentUserId, $reason); // Updated bind_param to include reason

    if ($stmt->execute()) {
        echo 'Success';
    } else {
        echo 'Error';
    }
} else {
    echo 'Invalid request';
}
?>
