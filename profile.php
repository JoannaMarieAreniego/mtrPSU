<?php
session_start();

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}


include("0conn.php");

$user_id = $_SESSION['studID'];

$sql = "SELECT * FROM posts WHERE studID = '$user_id' AND report != 'approved' ORDER BY created_at DESC";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">
    <title>Profile</title>

    <style>    
   body {
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

    .dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown button */
.dropbtn {
  background-color: #3498db;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 10px 15px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
  background-color: #f1f1f1;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  background-color: #2980b9;
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
    <div class="dropdown">
        <a href="profile.php" class="btn active">Profile</a>
        <div class="dropdown-content">
        <a href="userProfile.php">Profile</a>
        <a href="profile.php">Posts</a>
        <a href="favorites.php">Favorites</a>
  </div>
    </div>
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
                <?php
                $filePaths = explode(',', $row['file_path']);
                 foreach ($filePaths as $filePath) {
                     echo '<img src="' . $filePath . '" class="post-img">';
                 }
                 ?>
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

                <?php
                $filePaths = explode(',', $row_shared['file_path']);
                 foreach ($filePaths as $filePath) {
                     echo '<img src="' . $filePath . '" class="post-img">';
                 }
                 ?>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    function editPost(postId) {
        window.location.href = "editPost.php?post_id=" + postId;
    }
    function deletePost(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete.php',
                method: 'POST',
                data: { post_id: postId },
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: response,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#post_' + postId).remove();
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: xhr.responseText,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            });
        }
    });
}

function deleteSharedPost(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You will not be able to recover this shared post!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'deleteSharedPost.php',
                method: 'POST',
                data: { post_id: postId },
                success: function(response){
                    Swal.fire(
                        'Deleted!',
                        'Your shared post has been deleted.',
                        'success'
                    ).then(() => {
                        $('#post_' + postId).remove();
                        location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire(
                'Cancelled',
                'Your shared post is safe :)',
                'error'
            );
        }
    });
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
