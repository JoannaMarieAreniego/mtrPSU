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

    $sql_update = "UPDATE posts SET title = '$title', content = '$content' WHERE postID = '$post_id' AND studID = '$user_id'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Post updated successfully.";
    } else {
        echo "Error updating post: " . $conn->error;
    }
} else {
    echo "Missing post_id, title, or content data.";
}
?>
