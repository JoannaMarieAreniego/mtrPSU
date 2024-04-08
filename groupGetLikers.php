<?php
include("0conn.php");

if(isset($_POST['gpostID']) && !empty($_POST['gpostID'])) {
    $gpostID = $_POST['gpostID'];

    // Query to get like count
    $sqlCount = "SELECT COUNT(*) as likeCount FROM group_likes WHERE gpostID = ?";
    $stmtCount = $conn->prepare($sqlCount);
    $stmtCount->bind_param("i", $gpostID);
    $stmtCount->execute();
    $resultCount = $stmtCount->get_result();
    $rowCount = $resultCount->fetch_assoc();
    $likeCount = $rowCount['likeCount'];

    // Query to get usernames of likers
    $sqlUsers = "SELECT users.username FROM group_likes INNER JOIN users ON group_likes.studID = users.studID WHERE group_likes.gpostID = ?";
    $stmtUsers = $conn->prepare($sqlUsers);
    $stmtUsers->bind_param("i", $gpostID);
    $stmtUsers->execute();
    $resultUsers = $stmtUsers->get_result();

    // Fetching likers' usernames
    $likers = array();
    while ($row = $resultUsers->fetch_assoc()) {
        $likers[] = $row['username'];
    }

    // Closing statements
    $stmtCount->close();
    $stmtUsers->close();

    // Encoding result as JSON
    echo json_encode(array('likeCount' => $likeCount, 'likers' => $likers));
} else {
    echo "Error: gpostID is not set or empty";
}
?>
