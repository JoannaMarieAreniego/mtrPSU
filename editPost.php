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
    <link rel="stylesheet" type="text/css" href="style.css">
    
    <title>Profile</title>

    <style>
       
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

        form {
            max-width: 1000px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 100px auto 0;
            position: relative;
            z-index: 1;
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
    background-color: #FFDA27;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    font-size: 16px;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
    padding: 10px 0;
            width: 100%; 
            border-radius: 100px;
        }

        button[type="submit"][name="update"]:hover {
    background-color: #0056b3;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 0 10px;
            }
        }
        .ck-editor__editable[role="textbox"] {
                /* Editing area */
                min-height: 250px;
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
    <a href="profile.php" class="btn active">Profile</a>
    <a href="3newsfeed.php" class="btn">Newsfeed</a>
    <a href="createPost.php" class="btn">Create Post</a>
    <a href="faq.php" class="btn">FAQs</a>
    <a href="logout.php" class="btn">Logout</a>
</header>

<div class="container">
    <?php if(isset($_GET['post_id'])): ?>
        <h1>Edit Post</h1>
        <form id="updateForm">
            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" value="<?php echo $title ?>"><br><br>
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" rows="4" cols="50"><?php echo isset($content) ? $content : ''; ?></textarea><br><br>
            <input type="submit" id="updateButton" name="update" value="Update Post">
        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $("#updateForm").submit(function(event) {
                    event.preventDefault(); // Prevent the form from submitting normally

                    if (confirm("Are you sure you want to update this post?")) {
                        var formData = $(this).serialize();
                        $.ajax({
                            type: "POST",
                            url: 'update.php',
                            data: formData,
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
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
