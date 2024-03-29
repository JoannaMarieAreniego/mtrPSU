<?php
session_start();

if (!isset($_SESSION['studID'])) {
    echo "You are not logged in. Please log in to view your profile.";
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
    <title>Profile</title>

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
        }

        .container {
         
            max-width: 1200px;
            margin: 20px auto;
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

        .btn-delete {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
        }

        .btn-edit {
            position: absolute;
            top: 10px;
            right: 100px;
        }
        footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
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
    <h1>PSU</h1>
    <a href="3newsfeed.php" class="btn">Newsfeed</a>
    <a href="createPost.php" class="btn">Create Post</a>
</header>

<div class="container">
    <h1>My Posts</h1>
    <?php
    if ($result !== false && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
             <div class="post" id="post_<?php echo $row['postID'] ?>">
                <h2><?php echo $row['title'] ?></h2>
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

                <p class="post-meta">Posted on <?php echo $row['created_at'] ?></p>
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

<footer>
    <p>Pangasinan State University lorem epsum</p>
    <p>&copy; 2023 Jane</p>
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



</script>

</body>
</html>
