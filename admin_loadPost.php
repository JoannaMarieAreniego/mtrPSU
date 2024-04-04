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
            <h2><a href="admin_post_details.php?id=<?php echo $row['postID']; ?>"><?php echo $row['title'] ?></a></h2>
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
        </div>
        <?php
    }
} else {
    echo "No posts found.";
}
?>

<?php
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
?>


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
