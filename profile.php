<?php
session_start();

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}


include("0conn.php");

$user_id = $_SESSION['studID'];

$sql = "SELECT * FROM posts WHERE studID = '$user_id' ORDER BY created_at DESC";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Profile</title>

    <style>    
   body {
    font-family: "Arial Black", sans-serif;
    background-color: #f8f9fa;
    color: #343a40;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh; 
}

.container {
    padding: 20px;
    min-width: 1200px;
    margin: 0 auto;
}

footer {
            background-color: #0927D8;
            color: #f8f9fa;
            padding: 20px;
            width: 100%;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .names {
            text-align: center;
        }

        .left-content {
            flex: 1;
            text-align: left; /* Align content to the left */
        }

        .right-content {
            text-align: right; /* Align content to the right */
        }

        .left-content p,
        .right-content p {
            margin: 0;
        }


        .container {
            max-width: 1100px;
            margin: 120px auto 20px;
            padding: 0 20px;
        }

        .post {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            position: relative;
        }

        .post h2 {
            margin-bottom: 10px;
        color: #007bff;
        cursor: pointer;
        }

        .post p {
            margin-bottom: 15px;
        }

        .post-meta {
            color: #6c757d;
            font-size: 0.8rem;
        }
      .btn-delete {
            font-family: "Arial Black", sans-serif;
            font-size: 14px;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
            background-color: #7D0A0A;
        }

        .btn-edit {
            position: absolute;
            top: 10px;
            right: 120px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 0 10px;
            }
        }
        .post-img {
            max-width: 100%;
            height: 200px; 
            object-fit: cover;
            border-radius: 8px;
        }

    </style>
</head>
<body>


<header>
    <div class="logo">
        <img src="images/psuLOGO.png" alt="">
    </div>
    <h1>Pangasinan State University</h1>
    <nav>
        <a href="profile.php" class="btn active">Profile</a>
        <a href="3newsfeed.php" class="btn">Newsfeed</a>
        <a href="createPost.php" class="btn">Create Post</a>
        <a href="faq.php" class="btn">FAQs</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>

<div class="container">
    <h1>My Posts</h1>
    <?php
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
             <div class="post" id="post_<?php echo $row['postID'] ?>">
                <h2><?php echo $row['title'] ?></a></h2>
                <p><?php echo $row['content'] ?></p>
                <?php if ($row['postImage']): ?>
                    <img src="<?php echo $row['postImage'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row['postImage2']): ?>
                    <img src="<?php echo $row['postImage2'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row['postImage3']): ?>
                    <img src="<?php echo $row['postImage3'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row['postImage4']): ?>
                    <img src="<?php echo $row['postImage4'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row['postImage5']): ?>
                    <img src="<?php echo $row['postImage5'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>

                <p class="post-meta">Posted: <?php echo formatPostDate($row['created_at']); ?></p>

                <a href="#" class="btn btn-edit" onclick="editPost(<?php echo $row['postID'] ?>)" >Edit</a>
                <button class="btn btn-delete" id="deleteBtn_<?php echo $row['postID'] ?>" onclick="deletePost(<?php echo $row['postID'] ?>)">Delete</button>
            </div>
            <?php
        }
    } else {
        echo "No posts found.";
    }
    ?>
</div>
<div class="container">

<?php 
$user_id = $_SESSION['studID'];

// Query to retrieve shared posts by the current user
$sql_shared = "SELECT posts.*, shared_posts.shared_at 
               FROM shared_posts 
               INNER JOIN posts ON shared_posts.postID = posts.postID 
               WHERE shared_posts.shared_by_studID = '$user_id' 
               ORDER BY shared_posts.shared_at DESC";

$result_shared = $conn->query($sql_shared);
?>

<h1>My Shared Posts</h1>
    <?php
    if ($result_shared !== false && $result_shared->num_rows > 0) {
        while ($row_shared = $result_shared->fetch_assoc()) {
            ?>
            <div class="post" id="post_<?php echo $row_shared['postID'] ?>">
                <h2><?php echo $row_shared['title'] ?></h2>
                <p><?php echo $row_shared['content'] ?></p>
                <?php if ($row_shared['postImage']): ?>
                    <img src="<?php echo $row_shared['postImage'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row_shared['postImage2']): ?>
                    <img src="<?php echo $row_shared['postImage2'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row_shared['postImage3']): ?>
                    <img src="<?php echo $row_shared['postImage3'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row_shared['postImage4']): ?>
                    <img src="<?php echo $row_shared['postImage4'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <?php if ($row_shared['postImage5']): ?>
                    <img src="<?php echo $row_shared['postImage5'] ?>" alt="Post Image" class="post-img">
                <?php endif; ?>
                <p class="post-meta">Shared: <?php echo formatPostDate($row_shared['shared_at']); ?></p>
                <button class="btn btn-delete" onclick="deleteSharedPost(<?php echo $row_shared['postID'] ?>)">Delete</button>
            </div>
            <?php
        }
    } else {
        echo "No shared posts found.";
    }
    ?>
</div>

    <footer>
        <div class="footer-content">
            <div class="left-content">
                <p>Pangasinan State University</p>
            </div>
            <div class="right-content">
                <p id="copyright"></p>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var currentYear = new Date().getFullYear();
                        document.getElementById('copyright').innerText = '© ' + currentYear + ' PSUnian Space';
                    });
                </script>
            </div>
        </div>
        <div class="names">
            <p>Janela Tamayo and Joanna Marie Areniego</p>
        </div>
    </footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function editPost(postId) {
        window.location.href = "editPost.php?post_id=" + postId;
    }

    function deletePost(postId) {
    if (confirm("Are you sure you want to delete this post?")) {
        $.ajax({
            url: 'delete.php',
            method: 'POST',
            data: { post_id: postId },
            success: function(response){
                alert(response);
                $('#post_' + postId).remove();
            }
        });
    }
}
function deleteSharedPost(postId) {
        if (confirm("Are you sure you want to delete this shared post?")) {
            $.ajax({
                url: 'deleteSharedPost.php',
                method: 'POST',
                data: { post_id: postId },
                success: function(response){
                    alert(response);
                    $('#post_' + postId).remove();
                    location.reload();
                }
            });
        }
    }
</script>
</body>
</html>

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
