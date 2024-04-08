<!-- groupLoadPosts.php -->
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

if (!isset($_GET['groupID'])) {
    echo "Error: groupID parameter is not set at groupLoadPost.php.";
    exit;
}

$groupID = $_GET['groupID'];

if (!isset($_GET['lastPostID'])) {
    $sql = "SELECT group_posts.*, users.username AS poster_username
            FROM group_posts
            LEFT JOIN users ON group_posts.studID = users.studID
            WHERE group_posts.groupID = ?
            ORDER BY group_posts.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $groupID);
} else {
    $lastPostID = $_GET['lastPostID'];
    $sql = "SELECT group_posts.*, users.username AS poster_username
            FROM group_posts
            LEFT JOIN users ON group_posts.studID = users.studID
            WHERE group_posts.groupID = ? AND group_posts.gpostID < ?
            ORDER BY group_posts.created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $groupID, $lastPostID);
}

$result = $stmt->execute();

if (!$result) {
    echo "Error executing query: " . $stmt->error;
    exit;
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="post" data-post-id="<?php echo $row['gpostID']; ?>">
            <h2><a href="group_post_details.php?id=<?php echo $row['gpostID']; ?>&groupID=<?php echo $groupID; ?>"><?php echo $row['title'] ?></a></h2>
            <?php if (!empty($row['studID'])): ?>
                <p><em>Shared by <?php echo $row['studID']; ?>  <?php echo formatSharedDate($row['created_at']); ?></em></p>
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
                <div class="like-info" id="likeInfo-<?php echo $row['gpostID']; ?>" style="cursor: pointer;" onclick="gshowAllLikers(<?php echo $row['gpostID']; ?>)">
                    <?php
                    $likeCount = ggetLikeCount($row['gpostID']);
                    $likedUsers = ggetLikedUsers($row['gpostID']);
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
                <button class="btn <?php echo (gcheckUserLikedPost($row['gpostID'], $currentUserID)) ? 'liked' : ''; ?>" id="likeButton-<?php echo $row['gpostID']; ?>" onclick="glikePost(<?php echo $row['gpostID']; ?>)">
                    <?php echo (gcheckUserLikedPost($row['gpostID'], $currentUserID)) ? 'Dislike' : 'Like'; ?>
                </button>
                <button class="btn" onclick="window.location.href='post_details.php?id=<?php echo $row['gpostID']; ?>'">Comment</button>
            </div>
        </div>
        <?php
    }
} else {
    echo "No posts found.";
}
?>

<?php
function ggetLikedUsers($gpostId) {
    include("0conn.php");
    $sql = "SELECT users.username FROM group_likes INNER JOIN users ON group_likes.studID = users.studID WHERE group_likes.gpostID = ? LIMIT 2";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gpostId);
    $stmt->execute();
    $result = $stmt->get_result();
    $likedUsers = array();
    while ($row = $result->fetch_assoc()) {
        $likedUsers[] = $row['username'];
    }
    $stmt->close();
    return $likedUsers;
}


function ggetLikeCount($gpostId) {
    include("0conn.php");

    $sql = "SELECT COUNT(*) as likeCount FROM group_likes WHERE gpostID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gpostId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $likeCount = $row['likeCount'];
    $stmt->close();

    return $likeCount;
}
?>


<?php
function gcheckUserLikedPost($gpostId, $currentUserID) {
    include("0conn.php");

    $sql = "SELECT * FROM group_likes WHERE gpostID = ? AND studID = ?";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ii", $gpostId, $currentUserID); 
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
    function glikePost(gpostID) {
    var likeButton = $('#likeButton-' + gpostID);
    var isLiked = likeButton.hasClass('liked');
    
    $.ajax({
        url: 'groupAddLike.php',
        method: 'POST',
        data: { gpostID: gpostID, isLiked: isLiked ? 0 : 1 },
        success: function(response) {
            console.log(response);
            if (isLiked) {
                likeButton.removeClass('liked').text('Like');
            } else {
                likeButton.addClass('liked').text('Liked');
            }
            gupdateLikeInfo(gpostID);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}

    function gshowAllLikers(gpostID) {
        $.ajax({
            url: 'groupGetLikers.php',
            method: 'POST',
            data: { gpostID: gpostID },
            success: function(response) {
                var data = JSON.parse(response);
                var likeCount = data.likeCount;
                var likers = data.likers;

                var likersHTML = '<div class="likers-popup">';
                likersHTML += '<span class="close-btn" onclick="gcloseLikersPopup()">×</span>';
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

    function gcloseLikersPopup() {
        $('.likers-popup').remove();
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
