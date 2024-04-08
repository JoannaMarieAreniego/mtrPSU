<!-- loadPosts.php -->
<style>
.post-buttons .btn  {
display: inline-block;
padding: 10px 20px;
background-color: #007bff;
color: white;
text-decoration: none;
border-radius: 50px;
margin-right: 10px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
}
.post-buttons .btn.liked {
    background-color: yellow;
    color: #333;
}

</style>
<?php
include("0conn.php");
session_start();

$currentUserID = $_SESSION['studID'];

$sql = "SELECT posts.*, users.username AS poster_username, shared_posts.shared_by_studID, shared_posts.shared_from_studID, shared_posts.shared_at, sharer.username AS shared_by_username
FROM posts
LEFT JOIN users ON posts.studID = users.studID
LEFT JOIN shared_posts ON posts.postID = shared_posts.postID
LEFT JOIN users AS sharer ON shared_posts.shared_by_studID = sharer.studID
ORDER BY COALESCE(shared_posts.shared_at, posts.created_at) DESC
LIMIT 10"; // Limiting to 10 posts
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="post" data-post-id="<?php echo $row['postID']; ?>">
            <h2><a href="#?id=<?php echo $row['postID']; ?>"><?php echo $row['title'] ?></a></h2>
            <?php if (!empty($row['shared_by_studID'])): ?>
                <p><em>Shared by <?php echo $row['shared_by_username']; ?>  <?php echo formatSharedDate($row['shared_at']); ?></em></p>
            <?php endif; ?>
            <p><?php echo $row['content'] ?></p>
            <div class="post-container">
                <?php 
                    
                 $filePaths = explode(',', $row['file_path']);
                 foreach ($filePaths as $filePath) {
                     echo '<img src="' . $filePath . '"  class="post-image">';
                 }

                ?>
            </div>
            <p class="post-meta">By <?php echo $row['poster_username'] ?> <?php echo formatPostDate($row['created_at']); ?></p>
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
                <br> <br>
                <button class="btn <?php echo (checkUserLikedPost($row['postID'], $currentUserID)) ? 'liked' : ''; ?>" id="likeButton-<?php echo $row['postID']; ?>" onclick="likePost(<?php echo $row['postID']; ?>)">
    <?php echo (checkUserLikedPost($row['postID'], $currentUserID)) ? 'Dislike' : 'Like'; ?>
</button>

                </button>
           
                <button class="btn" onclick="window.location.href='post_details.php?id=<?php echo $row['postID']; ?>'">Comment</button>
                <button class="btn" onclick="resharePost(<?php echo $row['postID']; ?>)">Share</button>
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
            $weeks = floor($timeDiff / 604800);
            if ($weeks < 4) {
                return "$weeks week" . ($weeks > 1 ? "s" : "") . " ago";
            } else {
                $months = floor($weeks / 4);
                if ($months < 12) {
                    return "$months month" . ($months > 1 ? "s" : "") . " ago";
                } else {
                    $years = floor($months / 12);
                    return "$years year" . ($years > 1 ? "s" : "") . " ago";
                }
            }
        }
    }
    
    function formatSharedDate($sharedDate) {
        date_default_timezone_set('Asia/Manila');
    
        $currentTime = time();
        $sharedTime = strtotime($sharedDate);
        $timeDiff = $currentTime - $sharedTime;
        
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
            $weeks = floor($timeDiff / 604800);
            if ($weeks < 4) {
                return "$weeks week" . ($weeks > 1 ? "s" : "") . " ago";
            } else {
                $months = floor($weeks / 4);
                if ($months < 12) {
                    return "$months month" . ($months > 1 ? "s" : "") . " ago";
                } else {
                    $years = floor($months / 12);
                    return "$years year" . ($years > 1 ? "s" : "") . " ago";
                }
            }
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

    function resharePost(postID) {
    $.ajax({
        url: 'resharePost.php',
        method: 'POST',
        data: { postID: postID },
        success: function(response) {
            if (response.trim() === 'Error') {
                alert('Error resharing post. Please try again.');
                return;
            }
            alert('Post reshared successfully');
            $('.posts-container').prepend(response);
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert('Error resharing post. Please try again.');
        }
    });
}


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
    a {
        text-decoration: none;
    }
    
</style>
