<?php
include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postID']) && isset($_POST['status'])) {
    $postID = $_POST['postID'];
    $status = $_POST['status'];

    $query = "UPDATE reports SET status = '$status' WHERE postID = '$postID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Status updated successfully.";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}


?>
