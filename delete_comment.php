<?php
require '0conn.php';

// Start the session to access the current user's ID
session_start();

// Check if the current user ID is set in the session
if (!isset($_SESSION['studID'])) {
    echo "User ID not set.";
    exit();
}

$currentUserID = $_SESSION['studID'];

if (isset($_POST['delete'])) {
    $commentID = filter_input(INPUT_POST, 'commentID', FILTER_VALIDATE_INT);
    if ($commentID === false) {
        echo "Invalid comment ID.";
        exit();
    }

    // Check if the current user is the owner of the comment
    $checkQuery = "SELECT * FROM comments WHERE commentID = ? AND studID = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $commentID, $currentUserID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Delete the comment
        $deleteQuery = "DELETE FROM comments WHERE commentID = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $commentID);
        if ($stmt->execute()) {
            header("Location: 3newsfeed.php"); 
        } else {
            echo "Error deleting comment: " . $conn->error;
        }
    } else {
        echo "You are not authorized to delete this comment.";
    }
} else {
    echo "Invalid request.";
}
?>
