<!-- groupFeed.php -->
<?php
require "0conn.php";
session_start();

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}

if (!isset($_GET['groupID'])) {
    header("Location: groups.php");
    exit;
}

$studID = $_SESSION['studID'];
$groupID = $_GET['groupID'];
$getGroupSQL = "SELECT * FROM groups WHERE groupID = '$groupID'";
$groupResult = $conn->query($getGroupSQL);
$group = $groupResult->fetch_assoc();
$getGroupPostsSQL = "SELECT * FROM group_posts WHERE groupID = '$groupID'";
$groupPostsResult = $conn->query($getGroupPostsSQL);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title><?php echo $group['groupname']; ?> - Group Details</title>
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
            min-width: 1200px; /* Limit container width */
            margin: 0 auto; /* Center the container horizontally */
        }

        footer {
            background-color: #0927D8;
            color: #f8f9fa;
            padding: 20px;
            width: 96%;
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



    .post p {
        margin-bottom: 15px;
    }

    .post-meta {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .container {
            max-width: 1000px;
            margin: 120px auto 20px;
            padding: 0 20px;
        }

    .post-image {
        max-width: 100%;
        height: 200px;
        object-fit: cover; 
        border-radius: 8px;
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

    @media only screen and (max-width: 500px) {
        .container {
                padding: 0 10px;
            }
            
        }
</style>
</head>
<body>

<?php
function isModerator($studID, $groupID) {
    require "0conn.php";
    
    $checkModeratorSQL = "SELECT * FROM groupmembers WHERE studID = '$studID' AND groupID = '$groupID' AND is_moderator = '1'";
    $result = $conn->query($checkModeratorSQL);
    
    $conn->close();
    
    return $result->num_rows > 0;
}
?>


<header>
    <div class="logo">
        <img src="images/psuLOGO.png" alt="">
    </div>
    <h1>PSUnian's Space</h1>
    <nav>
        <a href="3newsfeed.php" class="btn">Home</a>
        <a href="groupFeed.php" class="btn active">Group Feed</a>
        <a href="groupCreatePost.php?groupID=<?php echo $groupID; ?>" class="btn">Create Post</a>
        <?php
            if ($_SESSION['studID'] == $group['created_by'] || isModerator($_SESSION['studID'], $groupID)) {
                echo '<a href="groupManage.php?groupID=' . $groupID . '" class="btn">Manage Group</a>';
            }
        ?>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var loading = false; 
            gloadPosts(); 
            $(window).scroll(function() {
                if ($('#postsContainer').length && !loading) {
                    var scrollTop = $(window).scrollTop();
                    var windowHeight = $(window).height();
                    var containerHeight = $('#postsContainer').outerHeight();
                    var containerOffset = $('#postsContainer').offset().top;
                    var bottomOffset = containerOffset + containerHeight - windowHeight;
                    if (scrollTop >= bottomOffset && scrollTop <= bottomOffset + 5000) {
                        loading = true;
                    }
                }
            });
        });


        function gloadPosts() {
            $.ajax({
                url: 'groupLoadPost.php',
                method: 'GET',
                data: { groupID: <?php echo $groupID; ?> },
                success: function(response) {
                    $('#postsContainer').html(response);
                }
            });
        }

        function glikePost(gpostID) {
            var likeButton = $('#likeButton-' + gpostID);
            var isLiked = likeButton.hasClass('liked');
            $.ajax({
                url: 'groupAddLike.php',
                method: 'POST',
                data: { gpostID: gpostID, isLiked: isLiked ? 0 : 1 },
                success: function(response) {
                    console.log(response);
                    if (isLiked) {
                        likeButton.removeClass('liked').text('Like');
                    } else {
                        likeButton.addClass('liked').text('Liked');
                    }
                    gupdateLikeInfo(gpostID);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function gupdateLikeInfo(gpostID) {
            $.ajax({
                url: 'groupUpdateLike.php',
                method: 'POST',
                data: { gpostID: gpostID },
                dataType: 'json',
                success: function(response) {
                    var likeCount = response.likeCount;
                    var likedUsers = response.likedUsers.join(', ');
                    var likeInfoElement = $('#likeInfo-' + gpostID);
                    if (likeCount > 0) {
                        likeInfoElement.html('Liked by ' + likedUsers);
                    } else {
                        likeInfoElement.html('No likes yet');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>