<?php
include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['postID'])) {
    $postID = $_POST['postID'];
    function getLikeInfo($postID) {
        $likeCount = getLikeCount($postID);

        $likedUsers = getLikedUsers($postID);
        $response = array(
            'likeCount' => $likeCount,
            'likedUsers' => $likedUsers
        );
        echo json_encode($response);
    }
    function getLikeCount($postID) {
        global $conn;
        $sql = "SELECT COUNT(*) as likeCount FROM likes WHERE postID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['likeCount'];
    }

    function getLikedUsers($postID) {
        global $conn;
        $sql = "SELECT users.username FROM likes INNER JOIN users ON likes.studID = users.studID WHERE likes.postID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        $likedUsers = array();
        while ($row = $result->fetch_assoc()) {
            $likedUsers[] = $row['username'];
        }
        return $likedUsers;
    }
    getLikeInfo($postID);
}
?>
