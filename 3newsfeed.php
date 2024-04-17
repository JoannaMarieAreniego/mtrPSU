<!-- 3newsfeed.php -->
<?php 
   session_start();
   if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <title>Newsfeed</title>

    <style>
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa; /* Light blue */
            color: #343a40;
            margin: 0;
            padding: 0;
        }

        .container {
            flex: 1; /* Grow to fill remaining space */
            padding: 20px; /* Adjust padding as needed */
            min-width: 500px; /* Limit container width */
            margin: 0 auto; /* Center the container horizontally */
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



    .post {
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        padding: 20px;
        text-align: left;
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

    .container {
            max-width: 1100px;
            margin: 120px auto 20px;
            padding: 0 20px;
        }

    .post-image {
        max-width: 100%;
        height: 200px;
        object-fit: cover; 
        border-radius: 8px;
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
    <div class="logo">
        <img src="images/psuLOGO.png" alt="">
    </div>
    <h1>PSUnian Space</h1>
    <nav>
        <a href="userProfile.php" class="btn">Profile</a>
        <a href="3newsfeed.php" class="btn active">Newsfeed</a>
        <a href="createPost.php" class="btn">Create Post</a>
        <a href="groups.php" class="btn">Groups</a>
        <a href="faq.php" class="btn">FAQs</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>
        

    <div class="container" id="postsContainer">
        
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js?ver=002"></script>
    <script>
        $(document).ready(function() {
            var loading = false;
            loadPosts(); 
            $(window).scroll(function() {
                if ($('#postsContainer').length && !loading) {
                    var scrollTop = $(window).scrollTop();
                    var windowHeight = $(window).height();
                    var containerHeight = $('#postsContainer').outerHeight();
                    var containerOffset = $('#postsContainer').offset().top;
                    var bottomOffset = containerOffset + containerHeight - windowHeight;
                    if (scrollTop >= bottomOffset && scrollTop <= bottomOffset + 5000) {
                        loading = true;
                        loadMorePosts();
                    }
                }
            });
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

        function loadMorePosts() {
            var lastPostID = $('.post:last').data('post-id');
            console.log("Last Post ID:", lastPostID);
            $.ajax({
                url: 'loadMorePosts.php',
                method: 'GET',
                data: { lastPostID: lastPostID },
                success: function(response) {
                    if (response.trim() !== 'No more posts found.') {
                        $('#postsContainer').append(response);
                    }
                    loading = false;
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
                // if (isLiked) {
                //     // likeButton.removeClass('liked').text('Like');
                // } else {
                //     // likeButton.addClass('liked').text('Liked');
                // }
                updateLikeInfo(postID);
                location.reload();

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
    </script>
   <script src="script.js"></script> 
</body>
</html>
