<!-- addLike.php -->
<?php
include("0conn.php");
session_start();

    if(isset($_SESSION['studID'])) {
        $postID = mysqli_real_escape_string($conn, $_POST['postID']);
        $studID = $_SESSION['studID'];
        $isLiked = $_POST['isLiked'];

        $checkQuery = "SELECT * FROM likes WHERE postID = '$postID' AND studID = '$studID'";
        $checkResult = $conn->query($checkQuery);

        if($checkResult) {
            if($checkResult->num_rows > 0) {
                $deleteQuery = "DELETE FROM likes WHERE postID = '$postID' AND studID = '$studID'";
                if($conn->query($deleteQuery) === TRUE) {
                    echo "Like removed successfully.";
                } else {
                    echo "Error removing like: " . $conn->error;
                }
            } else {
                $insertQuery = "INSERT INTO likes (postID, studID, likeCreated) VALUES ('$postID', '$studID', NOW())";
                if($conn->query($insertQuery) === TRUE) {
                    echo "Like added successfully.";
                } else {
                    echo "Error adding like: " . $conn->error;
                }
            }
        } else {
            echo "Query execution error: " . $conn->error;
        }
    } else {
        echo "User not logged in.";
    }
?>


