<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsfeed</title>

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa; /* Light blue */
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
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
    }

    .container {
        max-width: 1200px;
        margin: 80px auto 20px;
        padding: 40px;
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

    .post h2:hover {
        text-decoration: underline;
    }

    .post p {
        margin-bottom: 15px;
    }

    .post-meta {
        color: #6c757d;
        font-size: 0.8rem;
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
        border-radius: 8px;
    }

    footer {
        background-color: #343a40;
        color: #f8f9fa;
        text-align: center;
        padding: 20px;
        margin-top: 20px;
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

    @media only screen and (max-width: 600px) {
        .container {
            padding: 0 10px;
        }
    }
    .btn.active {
        background-color: yellow;
        color: black
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>

    <header>
        <h1>PSU</h1>
        <a href="profile.php" class="btn">Profile</a>
        <a href="3newsfeed.php" class="btn active">Newsfeed</a>
        <a href="createPost.php" class="btn">Create Post</a>
        <a href="logout.php" class="btn">Logout</a>
    </header>

    <div class="container" id="postsContainer">
    </div>

    <footer>
        <p>Pangasinan State University lorem epsum</p>
        <p>&copy; 2023 Jane</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js?ver=002"></script>
    <script>
        $(document).ready(function() {
            loadPosts();
        });

        function loadPosts() {
            $.ajax({
                url: 'loadPosts.php',
                method: 'GET',
                success: function(response) {
                    $('#postsContainer').html(response);
                }
            });
        }

    function likePost(postID) {
        var likeButton = $('#likeButton-' + postID);
        var isLiked = likeButton.hasClass('liked');

        $.ajax({
            url: 'addLike.php',
            method: 'POST',
            data: { postID: postID, isLiked: isLiked ? 0 : 1 },
            success: function(response) {
                console.log(response);
                if (isLiked) {
                    likeButton.removeClass('liked').text('Like');
                } else {
                    likeButton.addClass('liked').text('Liked');
                }
                updateLikeInfo(postID);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

        function updateLikeInfo(postID) {
            $.ajax({
                url: 'updateLike.php',
                method: 'POST',
                data: { postID: postID },
                dataType: 'json',
                success: function(response) {
                    var likeCount = response.likeCount;
                    var likedUsers = response.likedUsers.join(', ');
                    var likeInfoElement = $('#likeInfo-' + postID);
                    likeInfoElement.html('Liked by ' + likedUsers);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        
        function resharePost(postID) {
        }
    </script>
</body>
</html>