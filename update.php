<?php
session_start();

if (!isset($_SESSION['studID'])) {
    echo "You are not logged in. Please log in to update your post.";
    exit;
}

include("0conn.php");

$user_id = $_SESSION['studID'];

if(isset($_POST['post_id']) && isset($_POST['title']) && isset($_POST['content'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE postID = ? AND studID = ?");
    $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);

    if ($stmt->execute()) {
        echo "Post updated successfully.";
    } else {
        echo "Error updating post: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Missing post_id, title, or content data.";
}
?>
