<?php

include("0conn.php");

// Check if the userID parameter is set in the URL
if(isset($_GET['userID'])) {
    // Sanitize the input to prevent SQL injection
    $userID = mysqli_real_escape_string($conn, $_GET['userID']);

    // Query to select user information based on userID
    $sql = "SELECT * FROM users WHERE studID = '$userID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, display user information
        $row = $result->fetch_assoc();
        
        // Display other user information fields as needed

        // Query to select all posts and shared posts of the user
        $postsSql = "SELECT posts.*, users.username AS poster_username, shared_posts.shared_by_studID, shared_posts.shared_at, sharer.username AS shared_by_username
                     FROM posts
                     LEFT JOIN users ON posts.studID = users.studID
                     LEFT JOIN shared_posts ON posts.postID = shared_posts.postID
                     LEFT JOIN users AS sharer ON shared_posts.shared_by_studID = sharer.studID
                     WHERE posts.studID = '$userID' AND posts.report != 'approved'
                     ORDER BY COALESCE(shared_posts.shared_at, posts.created_at) DESC";
        $postsResult = $conn->query($postsSql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Responsive Profile Page</title>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    />
    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css?version=002" />
    <style>
        body { 
    background-color: #f8f9fa;
    color: #343a40;
    margin: 0;
    padding: 0;
    min-height: 100vh;
    
}

header {
background-color: #0927D8;
color: #f8f9fa;
padding: 20px;
text-align: center;
position: fixed;
top: 0;
width: 100%;
z-index: 1000;
display: flex;
justify-content: space-between;
align-items: center;
}

header h1 {
font-family: "Old English Text MT", serif;
font-size: 45px; 
color: #fff; 
text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
margin-bottom: 10px;

}



.logo {
margin-right: 50;
}

.logo img {
height: 75px;
width: auto;
border-radius: 50%; 
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
transition: transform 0.3s ease; 
}

.logo img:hover {
transform: scale(1.1); 
}


nav {
margin-left: auto; 
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

.btn {
display: inline-block;
padding: 10px 20px;
background-color: #007bff;
color: white;
text-decoration: none;
border-radius: 50px;
margin-right: 15px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
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
    <div class="header__wrapper">
    <div class="h"></div>
      <div class="cols__container">
        <div class="left__col">
          <div class="img__container">
            <img src="img/user.jpeg" alt="Anna Smith" />
            <span></span>
          </div>
          <h2><?php echo $row['firstname'] . $row['lastname']  ?></h2>
          <p>UX/UI Designer</p>
          <p>anna@example.com</p>

          <ul class="about">
            <li><span>4,073</span>Followers</li>
            <li><span>322</span>Following</li>
            <li><span>200,543</span>Attraction</li>
          </ul>

          <div class="content">
            <p>
              Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam
              erat volutpat. Morbi imperdiet, mauris ac auctor dictum, nisl
              ligula egestas nulla.
            </p>

            <ul>
              <li><i class="fab fa-twitter"></i></li>
              <i class="fab fa-pinterest"></i>
              <i class="fab fa-facebook"></i>
              <i class="fab fa-dribbble"></i>
            </ul>
          </div>
        </div>
        <div class="right__col">
       

          <div class="photos">
          <div class="container">

<?php


        if ($postsResult->num_rows > 0) {
        
            
            while ($postRow = $postsResult->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<h3>" . $row['username'] . "</h3>";
                echo "<p>" . $postRow['title'] . "</p>";
                echo "<p>" . $postRow['content'] . "</p>";
                
                ?>
                <div class="post-container">
                <?php 
                    
                 $filePaths = explode(',', $postRow['file_path']);
                 foreach ($filePaths as $filePath) {
                     echo '<img src="' . $filePath . '"  class="post-image">';
                 }

                ?>
            </div>
                <?php
                echo "</div>";
            }
        } else {
            echo "<p>No posts found.</p>";
        }
    } else {
        // User not found
        echo "<p>User not found.</p>";
    }
} else {
    // userID parameter not set in the URL
    echo "<p>Invalid request.</p>";
}
?>
</div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
