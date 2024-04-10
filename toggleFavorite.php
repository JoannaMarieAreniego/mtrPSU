<?php
include("0conn.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['studID'])) {
    echo "Error: User not logged in";
    exit;
}

// Get the post ID from the request
if (!isset($_POST['postID'])) {
    echo "Error: Post ID not provided";
    exit;
}

$postID = $_POST['postID'];
$userID = $_SESSION['studID'];

// Check if the post is already in the favorites
$stmt = $conn->prepare("SELECT * FROM favorites WHERE postID = ? AND studID = ?");
$stmt->bind_param("is", $postID, $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Remove post from favorites if it already exists
    $deleteStmt = $conn->prepare("DELETE FROM favorites WHERE postID = ? AND studID = ?");
    $deleteStmt->bind_param("is", $postID, $userID);
    if ($deleteStmt->execute()) {
        echo "Post removed from favorites";
    } else {
        echo "Error removing post from favorites";
    }
} else {
    // Add post to favorites
    $insertStmt = $conn->prepare("INSERT INTO favorites (studID, postID) VALUES (?, ?)");
    $insertStmt->bind_param("si", $userID, $postID);
    if ($insertStmt->execute()) {
        echo "Post added to favorites";
    } else {
        echo "Error adding post to favorites";
    }
}

$stmt->close();
$conn->close();
?>
