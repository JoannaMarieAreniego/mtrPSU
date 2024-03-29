<?php
include("0conn.php");
session_start();

$currentUserID = $_SESSION['studID'];

$sql = "SELECT posts.*, users.username FROM posts INNER JOIN users ON posts.studID = users.studID ORDER BY posts.created_at DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="post">
            <h2><a href="post_details.php?id=<?php echo $row['postID']; ?>"><?php echo $row['title'] ?></a></h2>
            <p><?php echo $row['content'] ?></p>
            <div class="image-container">
                <?php 
                $postImages = array($row['postImage'], $row['postImage2'], $row['postImage3'], $row['postImage4'], $row['postImage5']);
                foreach($postImages as $image) {
                    if (!empty($image)) {
                        echo '<img src="' . $image . '" alt="Post Image" class="post-image">';
                    }
                }
                ?>
            </div>
            <p class="post-meta">By <?php echo $row['username'] ?> <?php echo formatPostDate($row['created_at']); ?></p>
            <div class="post-buttons">
                <div class="like-info" id="likeInfo-<?php echo $row['postID']; ?>" style="cursor: pointer;" onclick="showAllLikers(<?php echo $row['postID']; ?>)">
                    <?php
                    $likeCount = getLikeCount($row['postID']);
                    $likedUsers = getLikedUsers($row['postID']);
                    if ($likeCount > 0) {
                        if (count($likedUsers) > 0) {
                            echo implode(', ', $likedUsers);
                            if ($likeCount > 2) {
                                echo ' and others';
                            }
                        }
                    } else {
                        echo 'No likes yet';
                    }
                    ?>
                </div>
                <button id="likeButton-<?php echo $row['postID']; ?>" onclick="likePost(<?php echo $row['postID']; ?>)">
                    <?php
                    if (checkUserLikedPost($row['postID'], $currentUserID)) {
                        echo 'Liked';
                    } else {
                        echo 'Like';
                    }
                    ?>
                </button>
                <!-- Comment button -->
                <button onclick="window.location.href='post_details.php?id=<?php echo $row['postID']; ?>'">Comment</button>
                <!-- Reshare button -->
                <button onclick="resharePost(<?php echo $row['postID']; ?>)">Reshare</button>
            </div>
        </div>
        <?php
    }
} else {
    echo "No posts found.";
}
?>

<?php
    function getLikedUsers($postId) {
        include("0conn.php");

        $sql = "SELECT users.username FROM likes INNER JOIN users ON likes.studID = users.studID WHERE likes.postID = ? LIMIT 2";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $likedUsers = array();
        while ($row = $result->fetch_assoc()) {
            $likedUsers[] = $row['username'];
        }
        $stmt->close();

        return $likedUsers;
    }

    function getLikeCount($postId) {
        include("0conn.php");

        $sql = "SELECT COUNT(*) as likeCount FROM likes WHERE postID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $likeCount = $row['likeCount'];
        $stmt->close();

        return $likeCount;
    }
?>

<?php
    function checkUserLikedPost($postId, $userId) {
        include("0conn.php");
    
        $sql = "SELECT * FROM likes WHERE postID = ? AND studID = ?";
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("ii", $postId, $userId); 
        $stmt->execute();
    
        $result = $stmt->get_result(); 
    
        $liked = $result->num_rows > 0;
    
        $stmt->close();
    
        return $liked;
    }

    function formatPostDate($postDate) {
        date_default_timezone_set('Asia/Manila');

        $currentTime = time();
        $postTime = strtotime($postDate);
        $timeDiff = $currentTime - $postTime;
        
        if ($timeDiff < 60) {
            return "a few seconds ago";
        } elseif ($timeDiff < 3600) {
            $minutes = floor($timeDiff / 60);
            return "$minutes minute" . ($minutes > 1 ? "s" : "") . " ago";
        } elseif ($timeDiff < 86400) {
            $hours = floor($timeDiff / 3600);
            return "$hours hour" . ($hours > 1 ? "s" : "") . " ago";
        } elseif ($timeDiff < 604800) {
            $days = floor($timeDiff / 86400);
            return "$days day" . ($days > 1 ? "s" : "") . " ago";
        } else {
            return date("F j, Y", $postTime);
        }
    }
?>

<script>
    function showAllLikers(postID) {
        $.ajax({
            url: 'getLikers.php',
            method: 'POST',
            data: { postID: postID },
            success: function(response) {
                var data = JSON.parse(response);
                var likeCount = data.likeCount;
                var likers = data.likers;

                var likersHTML = '<div class="likers-popup">';
                likersHTML += '<span class="close-btn" onclick="closeLikersPopup()">×</span>';
                likersHTML += '<h3>Total Likes: ' + likeCount + '</h3>';
                likersHTML += '<ul>';
                for (var i = 0; i < likers.length; i++) {
                    likersHTML += '<li>' + likers[i] + '</li>';
                }
                likersHTML += '</ul>';
                likersHTML += '</div>';
                $('body').append(likersHTML);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function closeLikersPopup() {
        $('.likers-popup').remove();
    }
</script>

</script>


<style>
    .likers-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 20px;
        z-index: 9999;
    }

    .likers-popup ul {
        list-style-type: none; 
        padding: 0;
    }

    .likers-popup li {
        margin-bottom: 5px;
    }

    .like-info {
        cursor: pointer;
        text-decoration: underline;
        color: #007bff;
    }

    .like-info:hover {
        text-decoration: none;
        color: #0056b3;
    }
</style>
