<?php
session_start();

if (!isset($_SESSION['studID'])) {
    echo "You are not logged in. Please log in to view your profile.";
    exit;
}

include("0conn.php");

$user_id = $_SESSION['studID'];

if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    
    $sql_select = "SELECT * FROM posts WHERE postID = '$post_id' AND studID = '$user_id'";
    $result = $conn->query($sql_select);
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
    } else {
        echo "Post not found.";
        exit;
    }
}
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

        footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            margin-top: auto;
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
        input[type="text"],
    textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

    textarea {
    resize: vertical;
}

    button[type="submit"][name="update"] {
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    font-size: 16px;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
        }

        button[type="submit"][name="update"]:hover {
    background-color: #0056b3;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 0 10px;
            }
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
    <?php if(isset($_GET['post_id'])): ?>
        <h1>Edit Post</h1>
        <form id="updateForm">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo $title ?>"><br><br>
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="4" cols="50"><?php echo isset($content) ? $content : ''; ?></textarea><br><br>
            <button type="submit" id="updateButton" name="update">Update Post</button>
        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#updateButton").click(function() {
                    if (confirm("Are you sure you want to update this post?")) {
                        var formData = $("#updateForm").serialize();
                        $.ajax({
    type: "POST",
    url: 'update.php',
    data: {
        post_id: <?php echo $_GET['post_id']; ?>,
        title: $("#title").val(),
        content: $("#content").val()
    },
    success: function(response) {
        alert("Post updated successfully.");
        window.location.href = "profile.php";
    },
    error: function(xhr, status, error) {
        alert("Error updating post: " + xhr.responseText);
    }
});

                    }
                });
            });
        </script>
    <?php else: ?>
    <?php endif; ?>
</div>

<footer>
    <p>Pangasinan State University lorem epsum</p>
    <p>&copy; 2023 Jane</p>
</footer>

</body>
</html>
