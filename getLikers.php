<?php
include("0conn.php");

if(isset($_POST['postID']) && !empty($_POST['postID'])) {
    $postID = $_POST['postID'];

    // Get total like count
    $sqlCount = "SELECT COUNT(*) as likeCount FROM likes WHERE postID = ?";
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bind_param("i", $postID);
    $stmtCount->execute();
    $resultCount = $stmtCount->get_result();
    $rowCount = $resultCount->fetch_assoc();
    $likeCount = $rowCount['likeCount'];

    // Get usernames of users who liked the post
    $sqlUsers = "SELECT users.username FROM likes INNER JOIN users ON likes.studID = users.studID WHERE likes.postID = ?";
    $stmtUsers = $conn->prepare($sqlUsers);
    $stmtUsers->bind_param("i", $postID);
    $stmtUsers->execute();
    $resultUsers = $stmtUsers->get_result();

    $likers = array();
    while ($row = $resultUsers->fetch_assoc()) {
        $likers[] = $row['username'];
    }

    $stmtCount->close();
    $stmtUsers->close();
    echo json_encode(array('likeCount' => $likeCount, 'likers' => $likers));
} else {
    echo "Error: postID is not set or empty";
}
?>
