<?php
session_start();

if (!isset($_SESSION['studID'])) {
    echo "You are not logged in. Please log in to delete posts.";
    exit;
}

include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $sql = "DELETE FROM posts WHERE postID = '$post_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Post deleted successfully";
    } else {
        echo "Error deleting post: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
