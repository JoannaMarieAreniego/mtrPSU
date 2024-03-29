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
            text-align: center; 
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
        <a href="profile.php" class="btn">Profile</a>
        <a href="createPost.php" class="btn">Create Post</a>
    </header>

    <div class="container" id="postsContainer">

    </div>

    <footer>
        <p>Pangasinan State University lorem epsum</p>
        <p>&copy; 2023 Jane</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    </script>
</body>
</html>
