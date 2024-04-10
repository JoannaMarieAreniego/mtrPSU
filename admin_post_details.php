<?php
include("0conn.php");
session_start();
$currentUserID = $_SESSION['studID'];

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Post Details</title>
    <style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Use the full height of the viewport */
}

.container {
    min-width: 1000px;
    margin: 0 auto; /* Center horizontally */
    padding:10px;
    height: 50;
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
            text-align: left;
        }

        .right-content {
            text-align: right;
        }

        .left-content p,
        .right-content p {
            margin: 0;
        }

        .btn.active {
            background-color: yellow;
            color: black
        }

        .btn:hover {
            background-color: #0056b3;
        }
        footer {
    background-color: #0927D8;
    color: #f8f9fa;
    text-align: center;
    padding: 20px;
    margin-top: 20px;
 
    left: 0;
    bottom: 0;
    width: 100%;
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
        <a href="dashboard.php" class="btn">Dashboard</a>
        <a href="admin_newsfeed.php" class="btn active">Newsfeed</a>
        <div class="dropdown">
        <a href="reportedPost.php" class="btn active">Reports</a>
        <div class="dropdown-content">
        <a href="reportedPost.php">Pending</a>
        <a href="rejectedPost.php">Rejected</a>
        <a href="manageAccount.php" class="btn">Manage Accounts</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
    </header>

    <div class="container">
        <div class="post">
            <h2><?php echo $row['title']; ?></h2>
            <p><?php echo $row['content']; ?></p>
            <div class="image-container">
            <?php 
                    
                    $filePaths = explode(',', $row['file_path']);
                    foreach ($filePaths as $filePath) {
                        echo '<img src="' . $filePath . '"  class="post-image">';
                    }
   
                   ?>
            </div>
            <p class="post-meta">By <?php echo $row['username'] ?> <?php echo formatPostDate($row['created_at']); ?></p>
            <?php if ($_SESSION['studID'] == 'admin') { ?>
                <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete this post?');">
                <input type="hidden" name="delete_post" value="<?php echo $row['postID']; ?>">
                <button class="btnd" type="submit" class="btn">Delete Post</button>
            </form>
            <?php } ?>
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

<?php
if(isset($_POST['delete_post'])){
    $deletePostID = $_POST['delete_post'];
    
    $deleteQuery = "DELETE FROM posts WHERE postID = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $deletePostID);
    
    if ($stmt->execute()) {
        // Show alert and redirect
        echo '<script>alert("Post deleted successfully."); window.location.href = "admin_newsfeed.php";</script>';
        exit();
    } else {
        echo "Error deleting post: " . $conn->error;
    }
}
?>



