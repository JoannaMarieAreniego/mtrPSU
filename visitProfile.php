<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 5px;
        }

        .post {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">

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
        echo "<h1>User Profile</h1>";
        echo "<p>Username: " . $row['username'] . "</p>";
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

        if ($postsResult->num_rows > 0) {
            // Display all posts and shared posts
            echo "<h2>Posts:</h2>";
            
            while ($postRow = $postsResult->fetch_assoc()) {
                echo "<div class='post'>";
                echo "<p>" . $postRow['content'] . "</p>";
                // Display other post information as needed
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

</body>
</html>
