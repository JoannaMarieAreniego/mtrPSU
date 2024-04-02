<?php
session_start();

if (!isset($_SESSION['studID'])) {
    echo "You are not logged in.";
    exit;
}

include("0conn.php");

$user_id = $_SESSION['studID'];

if (isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];


    $check_sql = "SELECT * FROM shared_posts WHERE postID = '$post_id' AND shared_by_studID = '$user_id'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        $delete_sql = "DELETE FROM shared_posts WHERE postID = '$post_id' AND shared_by_studID = '$user_id'";
        if ($conn->query($delete_sql) === TRUE) {
            echo "Post deleted successfully.";
        } else {
            echo "Error deleting post: " . $conn->error;
        }
    } else {
        
    }
} else {
    echo "Post ID not provided.";
}

$conn->close();
?>
