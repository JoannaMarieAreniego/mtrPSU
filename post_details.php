<?php
include("0conn.php");
session_start();
$currentUserID = $_SESSION['studID'];

if (!isset($_SESSION['studID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $postID = $_GET['id'];

    $sql = "SELECT posts.*, users.username FROM posts INNER JOIN users ON posts.studID = users.studID WHERE postID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Post not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}

if(isset($_POST['postID']) && isset($_POST['isLiked'])) {
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
}

// Handle comment submission
if(isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $studID = $_SESSION['studID'];

    $insertQuery = "INSERT INTO comments (postID, studID, comment, commentCreated) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $postID, $studID, $comment);

    if ($stmt->execute()) {
    } else {
        echo "Error adding comment: " . $conn->error;
    }
}

// Handle comment deletion
if(isset($_POST['delete_comment'])) {
    $commentID = $_POST['delete_comment'];

    $deleteQuery = "DELETE FROM comments WHERE commentID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $commentID);

    if ($stmt->execute()) {
    } else {
        echo "Error deleting comment: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Post Details</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        header {
            background-color: #343a40;
            color: #f8f9fa;
            padding: 20px;
            text-align: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        .container {
            max-width: 1200px;
            margin: 120px auto 20px;
            padding: 0 20px;
        }

        .post {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .post h2 {
            margin-bottom: 10px;
            color: #007bff;
        }

        .post p {
            margin-bottom: 15px;
        }

        .post-meta {
            color: #6c757d;
            font-size: 0.8rem;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 10px;
        }

        .post-image {
            max-width: 100%;
            height: 200px;
            object-fit: cover; 
        }

        footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
        }
        .btn.active {
            background-color: yellow;
            color: black
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>PSU</h1>
        <a href="profile.php" class="btn">Profile</a>
        <a href="3newsfeed.php" class="btn active">Newsfeed</a>
        <a href="createPost.php" class="btn">Create Post</a>
        <a href="logout.php" class="btn">Logout</a>
    </header>

    <div class="container">
        <div class="post">
            <h2><?php echo $row['title']; ?></h2>
            <p><?php echo $row['content']; ?></p>
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

        <!-- Comments section -->
        <h2>Comments</h2>
        <?php
        // DISPLAY COMMENT
        $commentsQuery = "SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.studID = users.studID WHERE postID = ?";
        $stmt = $conn->prepare($commentsQuery);
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($comment = $result->fetch_assoc()) {
                echo "<p>{$comment['username']}: {$comment['comment']}</p>";
                //DELETE COMMENT
                if ($comment['studID'] == $currentUserID) {
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='delete_comment' value='{$comment['commentID']}'>";
                    echo "<button type='submit'>Delete</button>";
                    echo "</form>";
                }
            }
        } else {
            echo "No comments yet.";
        }
        ?>

        <!-- Comment form -->
        <h3>Add Comment</h3>
        <form action="post_details.php?id=<?php echo $postID; ?>" method="post">
            <textarea name="comment" rows="4" cols="50"></textarea><br>
            <button type="submit">Submit Comment</button>
        </form>
    </div>
    <footer>
        <p>Pangasinan State University lorem epsum</p>
        <p>&copy; 2023 Jane</p>
    </footer>

    <script>
        function toggleLike(postID) {
            var likeButton = document.getElementById("likeButton-" + postID);
            var likeValue = (likeButton.innerText.trim() === 'Like') ? 1 : 0;
            console.log("PostID: " + postID); 
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "post_details.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log("Response: " + xhr.responseText);
                        if (likeValue === 1) {
                            likeButton.innerText = 'Unlike';
                        } else {
                            likeButton.innerText = 'Like';
                        }
                    } else {
                        console.error("Error: " + xhr.status);
                    }
                }
            };
            xhr.send("postID=" + postID + "&isLiked=" + likeValue);
        }

        function likePost(postID, isLiked) {
            console.log("Like button clicked for postID: " + postID);
            var likeButton = $("#likeButton-" + postID);
            var isLiked = likeButton.hasClass('liked');
            $.ajax({
                url: 'post_details.php?id=' + postID,
                method: 'POST',
                data: { postID: postID, isLiked: (isLiked ? 0 : 1) },
                success: function(response) {
                    console.log(response); 
                    if (isLiked) {
                        likeButton.removeClass('liked').text('Like');
                    } else {
                        likeButton.addClass('liked').text('Liked');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
</script>
</body>
</html>

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
            return date("F j, Y", $postTime);
        }
    }
?>

