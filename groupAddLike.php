<?php
include("0conn.php");
session_start();

if(isset($_SESSION['studID'])) {
    $gpostID = mysqli_real_escape_string($conn, $_POST['gpostID']);
    $studID = $_SESSION['studID'];
    $isLiked = $_POST['isLiked'];

    if ($isLiked == 1) {
        $insertQuery = "INSERT INTO group_likes (gpostID, studID, likeCreated) VALUES ('$gpostID', '$studID', NOW())";
        if($conn->query($insertQuery) === TRUE) {
            echo "Like added successfully.";
        } else {
            echo "Error adding like: " . $conn->error;
        }
        $response = array(
            'success' => true,
            'likeCount' => ggetLikeCount($gpostID) // Kunin ang like count gamit ang function na ito
        );
        echo json_encode($response);
    } else {
        $deleteQuery = "DELETE FROM group_likes WHERE gpostID = '$gpostID' AND studID = '$studID'";
        if($conn->query($deleteQuery) === TRUE) {
            echo "Like removed successfully.";
        } else {
            echo "Error removing like: " . $conn->error;
        }
    }
} else {
    echo "User not logged in.";
}
?>
