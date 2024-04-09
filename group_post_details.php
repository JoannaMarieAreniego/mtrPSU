<?php
include("0conn.php");
session_start();
$currentUserID = $_SESSION['studID'];

if (!isset($_SESSION['studID'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $gpostID = $_GET['id'];

    $sql = "SELECT group_posts.*, groups.groupname, users.username FROM group_posts INNER JOIN groups ON group_posts.groupID = groups.groupID INNER JOIN users ON group_posts.studID = users.studID WHERE gpostID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gpostID);
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
if(isset($_POST['gpostID']) && isset($_POST['isLiked'])) {
    $postID = mysqli_real_escape_string($conn, $_POST['gpostID']);
    $studID = $_SESSION['studID'];
    $isLiked = $_POST['isLiked'];

    $checkQuery = "SELECT * FROM group_likes WHERE gpostID = '$gpostID' AND studID = '$studID'";
    $checkResult = $conn->query($checkQuery);

    if($checkResult) {
        if($checkResult->num_rows > 0) {
            $deleteQuery = "DELETE FROM group_likes WHERE gpostID = '$gpostID' AND studID = '$studID'";
            if($conn->query($deleteQuery) === TRUE) {
                echo "Like removed successfully.";
            } else {
                echo "Error removing like: " . $conn->error;
            }
        } else {
            $insertQuery = "INSERT INTO group_likes (gpostID, studID, likeCreated) VALUES ('$gpostID', '$studID', NOW())";
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


if(isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $studID = $_SESSION['studID'];

    $insertQuery = "INSERT INTO group_comments (gpostID, studID, comment, commentCreated) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $gpostID, $studID, $comment);

    if ($stmt->execute()) {
    } else {
        echo "Error adding comment: " . $conn->error;
    }
}

if(isset($_POST['delete_comment'])) {
    $commentID = $_POST['delete_comment'];

    $deleteQuery = "DELETE FROM group_comments WHERE gcommentID = ?";
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
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Post Details</title>
    <style>

.container {
        max-width: 1200px;
        margin: 80px auto 20px;
        padding: 20px;
      
    }
    .con {
        margin: 10px auto 10px;
        padding: 40px;
    border: 1px solid #007bff;
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
        cursor: pointer;
    }

    footfooter {
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



    .post p {
        margin-bottom: 15px;
    }

    .post-meta {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .container {
            max-width: 1100px;
            margin: 120px auto 20px;
            padding: 0 20px;
        }

    .post-image {
        max-width: 100%;
        height: 200px;
        object-fit: cover; 
        border-radius: 8px;
    }



    .post-buttons {
        top: 10px;
        right: 10px;
    }

    .post-buttons button {
        margin-left: 5px;
        padding: 5px 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        cursor: pointer;
    }
    .btns {
padding: 10px 20px;
background-color: #FFDA27;
color: black;
text-decoration: none;
border-radius: 50px;
margin-right: 10px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
}

button:hover {
    background-color: #0056b3;
}

form {
    margin-top: 20px;
}

textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    resize: vertical;
}


    </style>
</head>
<body>
    
   <header>
        <div class="logo">
            <img src="images/psuLOGO.png" alt="">
        </div>
        <h1>PSUnian Space</h1>
        <nav>
            <a href="3newsfeed.php" class="btn">Home</a>
            <a href="groupFeed.php" class="btn">Group Feed</a>
            <a href="groups.php" class="btn active">Groups</a>
            <a href="createGroup.php" class="btn">Create Group</a>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </header>

    <div class="container">
        <div class="post">
            <h2><?php echo $row['title']; ?></h2>
            <p><?php echo $row['content']; ?></p>
            <div class="post-container">
                <?php 
                    
                 $filePaths = explode(',', $row['file_path']);
                 foreach ($filePaths as $filePath) {
                     echo '<img src="' . $filePath . '"  class="post-image">';
                 }

                ?>
            <p class="post-meta">By <?php echo $row['username'] ?> <?php echo formatPostDate($row['created_at']); ?></p>
            <button class="btn" id="likeButton-<?php echo $row['gpostID']; ?>" onclick="glikePost(<?php echo $row['gpostID']; ?>)">
                <?php
                    if (gcheckUserLikedPost($row['gpostID'], $currentUserID)) {
                        echo 'Dislike';
                    } else {
                        echo 'Like';
                    }
                ?>
            </button>
        </div>

        <div class="con">
        <?php
            $commentsQuery = "SELECT group_comments.*, users.username FROM group_comments INNER JOIN users ON group_comments.studID = users.studID WHERE gpostID = ?";
            $stmt = $conn->prepare($commentsQuery);
            $stmt->bind_param("i", $gpostID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($comment = $result->fetch_assoc()) {
                    ?>
                    <div class="con">
                        <?php
                        echo "<p>{$comment['username']} commented: <br> {$comment['comment']}</p>";
                        // DELETE COMMENT
                        if ($comment['studID'] == $currentUserID) {
                            echo "<form action='' method='post'>";
                            echo "<input type='hidden' name='delete_comment' value='{$comment['gcommentID']}'>";
                            echo "<button class='btnd' type='submit'>Delete Comment</button>";
                            echo "</form>";
                        }
                        ?>
                    </div>
                    <?php
                }
            } else {
                echo "No comments yet.";
            }
            ?>

<div class="con">
        <!-- Comment form -->
        <h3>Add Comment</h3>
        <form action="group_post_details.php?id=<?php echo $gpostID; ?>" method="post">
            <textarea name="comment" rows="4" cols="50"></textarea><br>
            <button type="submit" class="btns">Submit Comment</button>
        </form>
    </div>
    </div>
    </div>
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

    <script>
        function toggleLike(gpostID) {
            var likeButton = document.getElementById("likeButton-" + gpostID);
            var likeValue = (likeButton.innerText.trim() === 'Like') ? 1 : 0;
            console.log("PostID: " + gpostID); 
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "group_post_details.php", true);
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
            xhr.send("gpostID=" + gpostID + "&isLiked=" + likeValue);
        }

        function glikePost(gpostID) {
            console.log("Like button clicked for gpostID: " + gpostID);
            var likeButton = $("#likeButton-" + gpostID);
            var isLiked = likeButton.text().trim() === 'Like';
            $.ajax({
                url: 'group_post_details.php?id=' + gpostID,
                method: 'POST',
                data: { gpostID: gpostID, isLiked: (isLiked ? 1 : 0) },
                success: function(response) {
                    console.log(response);
                    var trimmedResponse = $.trim(response);
                    if (trimmedResponse === 'Like added successfully.') {
                        likeButton.text('Dislike');
                    } else if (trimmedResponse === 'Like removed successfully.') {
                        likeButton.text('Like');
                    } else {
                        if (isLiked) {
                            likeButton.text('Dislike');
                        } else {
                            likeButton.text('Like');
                        }
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
    function gcheckUserLikedPost($gpostId, $userId) {
        include("0conn.php");
    
        $sql = "SELECT * FROM group_likes WHERE gpostID = ? AND studID = ?";
        $stmt = $conn->prepare($sql);
    
        $stmt->bind_param("ii", $gpostId, $userId);
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

