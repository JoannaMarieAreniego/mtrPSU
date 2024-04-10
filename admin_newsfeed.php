<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">
    <title>Newsfeed</title>

    <style>
          body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    background-color: #f8f9fa;
    color: #343a40;
    margin: 0;
    padding: 0;
}

header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    padding: 10px 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.container {
    flex: 1;
    padding: 20px;
    min-width: 1200px;
    margin: 80px auto 20px;
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
</style>
</head>
<body>

    <header>
    <div class="logo">
        <img src="images/psuLOGO.png" alt="">
    </div>
    <h1>PSUnian Space</h1>
    <nav>
        <a href="admin_newsfeed.php" class="btn active">Newsfeed</a>
        <a href="reportedPost.php" class="btn">Reports</a>
        <a href="manageAccount.php" class="btn">Manage Accounts</a>
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
            loadPosts();
        });

        function loadPosts() {
            $.ajax({
                url: 'admin_loadPost.php',
                method: 'GET',
                success: function(response) {
                    $('#postsContainer').html(response);
                }
            });
        }
    </script>
</body>
</html>