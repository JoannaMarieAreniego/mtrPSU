<?php
include("0conn.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['postID'];
    $currentUserId = $_SESSION['studID'];
    
    $sql = "SELECT studID FROM posts WHERE postID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $sharedFromUserId = $row['studID'];
    
    $sql = "INSERT INTO shared_posts (postID, shared_by_studID, shared_from_studID) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $postId, $currentUserId, $sharedFromUserId);

    if ($stmt->execute()) {
        echo 'Success';
    } else {
        echo 'Error';
    }
} else {
    echo 'Invalid request';
}
?>
