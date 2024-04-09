<?php
include("0conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['gpostID'])) {
    $gpostID = $_POST['gpostID'];
    function getLikeInfo($gpostID) {
        $likeCount = getLikeCount($gpostID);
        $likedUsers = getLikedUsers($gpostID);
        $response = array(
            'likeCount' => $likeCount,
            'likedUsers' => $likedUsers
        );
        echo json_encode($response);
    }
    function getLikeCount($gpostID) {
        global $conn;
        $sql = "SELECT COUNT(*) as likeCount FROM group_likes WHERE gpostID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $gpostID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['likeCount'];
    }

    function getLikedUsers($gpostID) {
        global $conn;
        $sql = "SELECT users.username FROM group_likes 
                INNER JOIN users ON group_likes.studID = users.studID 
                WHERE group_likes.gpostID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $gpostID);
        $stmt->execute();
        $result = $stmt->get_result();
        $likedUsers = array();
        while ($row = $result->fetch_assoc()) {
            $likedUsers[] = $row['username'];
        }
        return $likedUsers;
    }
    getLikeInfo($gpostID);
}
?>
