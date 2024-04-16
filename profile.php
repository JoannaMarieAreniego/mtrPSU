<?php
session_start();

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}


include("0conn.php");

$user_id = $_SESSION['studID'];

$sqls = "SELECT * FROM posts WHERE studID = '$user_id' AND report != 'approved' ORDER BY created_at DESC";
$results = $conn->query($sqls);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Responsive Profile Page</title>
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css?version=005" />
    <link rel="stylesheet" href="style.css?version=004">
    <style>
       

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
       
        .post-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    object-fit: cover; /* Optional: maintain aspect ratio and crop if necessary */
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
        .button {
    padding: 10px 20px;
    text-decoration: none;
    color: #333;
}

.button.active {
    background-color: #FFDA27;
 /* Change to the desired highlight color */
    color: black; /* Change to the desired text color */
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
        <a href="userProfile.php" class="button">Profile</a>
        <a href="profile.php" class="button active">Shared Posts</a>
        <a href="favorites.php" class="button">Favorites</a>
  </div>
    </div>
        <a href="3newsfeed.php" class="btn">Newsfeed</a>
        <a href="createPost.php" class="btn">Create Post</a>
        <a href="groups.php" class="btn">Groups</a>
        <a href="faq.php" class="btn">FAQs</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>
    <div class="header__wrapper">
    <div class="h"></div>
      <div class="cols__container">
        <div class="left__col">
          <div class="img__container">
            <img src="img/user.jpeg" alt="Anna Smith" />
            <span></span>
          </div>
          <?php


$user_id = $_SESSION['studID'];

$sql = "SELECT * FROM users WHERE studID = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch the row as an associative array
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $username = $row['username'];
    $password = $row['password'];
    $email = $row['email'];
    $course = $row['course'];
    $bio = $row['bio']; // Access the username property from the array
} else {
    // Handle the case when no rows are returned
    // You might want to display an error message or redirect the user
}

?>

          <h2><?php echo $fname . " " . $lname  ?></h2>
          <p><?php echo $course ?> </p>
          <p><?php echo $email ?></p>

          <ul class="about">
            
          </ul>

          <div class="content">
            <p>
              <?php echo $bio ?> 
            </p>

            <ul>
              <!-- <li><i class="fab fa-twitter"></i></li>
              <i class="fab fa-pinterest"></i>
              <i class="fab fa-facebook"></i>
              <i class="fab fa-dribbble"></i> -->
            </ul>
          </div>
        </div>
        <div class="right__col">
       

          <div class="photos">
          <div class="container">
          <h1>My Shared Posts</h1>

          <?php 
$user_id = $_SESSION['studID'];

// Query to retrieve shared posts by the current user
$sql_shared = "SELECT posts.*, shared_posts.shared_at, users.username AS shared_from_username
               FROM shared_posts 
               INNER JOIN posts ON shared_posts.postID = posts.postID
               INNER JOIN users ON shared_posts.shared_from_studID = users.studID
               WHERE shared_posts.shared_by_studID = '$user_id' 
               ORDER BY shared_posts.shared_at DESC";

$result_shared = $conn->query($sql_shared);
?>
          <?php
    if ($result_shared !== false && $result_shared->num_rows > 0) {
        while ($row_shared = $result_shared->fetch_assoc()) {
            ?>
            <div class="post" id="post_<?php echo $row_shared['postID'] ?>">
                <h3><?php echo $row_shared['shared_from_username'] ?></h3>
                <h3><?php echo formatPostDate($row_shared['created_at']) ?></h3>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>

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

