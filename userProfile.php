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
<?php
$user_id = $_SESSION['studID'];

// Handle profile picture update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    // Check if a file was uploaded
    if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_name = $_FILES['profile_picture']['name'];
        $file_size = $_FILES['profile_picture']['size'];
        $file_type = $_FILES['profile_picture']['type'];

        // Check file size (max 5MB)
        if ($file_size > 5 * 1024 * 1024) {
            echo "Error: File size exceeds 5MB limit.";
            exit;
        }

        // Restrict file types to images only
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        if (!in_array($file_type, $allowed_types)) {
            echo "Error: Only JPG, PNG, and GIF files are allowed.";
            exit;
        }

        // Generate a unique filename to prevent overwriting existing files
        $new_file_name = uniqid('', true) . '_' . $file_name;

        // Move the uploaded file to the uploads directory
        $upload_path = "images/";
        $file_path = $upload_path . $new_file_name;
        if (move_uploaded_file($file_tmp, $file_path)) {
            // Update the user's profile picture in the database
            $sql = "UPDATE users SET profile_picture = '$file_path' WHERE studID = '$user_id'";
            if ($conn->query($sql) === TRUE) {
                // Redirect back to the profile page
                header("Location: userProfile.php");
                exit;
            } else {
                echo "Error updating profile picture: " . $conn->error;
                exit;
            }
        } else {
            echo "Error uploading file.";
            exit;
        }
    } else {
        echo "Error uploading file: " . $_FILES['profile_picture']['error'];
        exit;
    }
}

?>
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
    $bio = $row['bio'];
    $dp = $row['profile_picture']; // Access the username property from the array
} else {
   
}

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
    height: 500px;
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
.bt {
    display: inline-block;
    padding: 4px;
    background-color: #FFDA27;
    color: black;
    text-decoration: none;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    font-size: 12px;
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
        <a href="userProfile.php" class="button active">Profile</a>
        <a href="profile.php" class="button">Shared Posts</a>
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
            <img src="<?php echo $dp ?>" alt="Profile Picture" />
            <span></span>
          </div>


          <h2><?php echo $fname . " " . $lname  ?></h2>
          <p><?php echo $course ?> </p>
          <p><?php echo $email ?></p> <br><br>
          <h4>Update Profile Picture</h4> 
          <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="profile_picture" accept="image/*" required>
                    <button type="submit" class="bt">Update</button>
                </form>
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
          <h1>My Posts</h1>
          <?php
    if ($results !== false && $results->num_rows > 0) {
        while ($rows = $results->fetch_assoc()) {
            ?>
             <div class="post" id="post_<?php echo $rows['postID'] ?>">
                <h2><?php echo $rows['title'] ?></a></h2>
                <p><?php echo $rows['content'] ?></p>
                <?php
                $filePaths = explode(',', $rows['file_path']);
                 foreach ($filePaths as $filePath) {
                     echo '<img src="' . $filePath . '" class="post-img">';
                 }
                 ?>
                <p class="post-meta">Posted: <?php echo formatPostDate($rows['created_at']); ?></p>

                <a href="#" class="btn btn-edit" onclick="editPost(<?php echo $rows['postID'] ?>)" >Edit</a>
                <button class="btn btn-delete" id="deleteBtn_<?php echo $rows['postID'] ?>" onclick="deletePost(<?php echo $rows['postID'] ?>)">Delete</button>
            </div>
            <?php
        }
    } else {
        echo "No posts found.";
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

