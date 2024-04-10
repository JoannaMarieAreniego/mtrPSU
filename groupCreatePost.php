<!-- groupCreatePost.php -->
<?php
require "0conn.php";
session_start();
if (!isset($_GET['groupID'])) {
    header("Location: groups.php"); 
    exit;
}

$studID = $_SESSION['studID'];
$groupID = $_GET['groupID'];
$getGroupSQL = "SELECT * FROM groups WHERE groupID = '$groupID'";
$groupResult = $conn->query($getGroupSQL);
$group = $groupResult->fetch_assoc();
?>

<?php
function isModerator($studID, $groupID) {
    require "0conn.php";
    
    $checkModeratorSQL = "SELECT * FROM groupmembers WHERE studID = '$studID' AND groupID = '$groupID' AND is_moderator = '1'";
    $result = $conn->query($checkModeratorSQL);
    
    $conn->close();
    
    return $result->num_rows > 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;

            box-sizing: border-box;
        }

        body { 
            background-color: #f8f9fa;
            color: #343a40;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            
        }
        .container {
            flex: 1; /* Grow to fill remaining space */
            padding: 20px; /* Adjust padding as needed */
            min-width: 1200px; /* Limit container width */
            margin: 0 auto; /* Center the container horizontally */
        }
        
        form {
            max-width: 1000px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 100px auto 0;
            position: relative;
            z-index: 1;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        

        input[type="submit"] {
          
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            text-align: center;
            font-size: 16px;
            margin-top: 10px;
            padding: 10px 0;
            width: 100%; 
            border-radius: 100px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }


        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
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
    <h1>PSUnian's Space</h1>
    <nav>
        <a href="3newsfeed.php" class="btn">Home</a>
        <a href="groupFeed.php" class="btn">Group Feed</a>

        <a href="groupCreatePost.php?groupID=<?php echo $groupID; ?>" class="btn active">Create Post</a>
        <?php
            if ($_SESSION['studID'] == $group['created_by'] || isModerator($_SESSION['studID'], $groupID)) {
                echo '<a href="groupManage.php?groupID=' . $groupID . '" class="btn">Manage Group</a>';
            }
        ?>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>

    <div class="container">
    <h1>Create a Post</h1>
    </div>
    <form id="postForm" enctype="multipart/form-data">
        <label for="title">TITLE</label>
        <input type="text" id="title" name="title">
        <label for="content">CONTENT</label>
        <textarea id="content" name="content" rows="4"></textarea>
        <input type="file" name="images[]" id="images" multiple>
        <input type="hidden" id="groupID" name="groupID" value="<?php echo $groupID; ?>">
        <input type="submit" name="post" value="Post">
       
    </form>

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

    <script>
    $(document).ready(function(){
    $('#image1').change(function(){
        $('#image2Container').show();
    });

    $('#image2').change(function(){
        $('#image3Container').show();
    });

    $('#image3').change(function(){
        $('#image4Container').show();
    });

    $('#image4').change(function(){
        $('#image5Container').show();
    });

    $('#postForm').submit(function(event){
        event.preventDefault();

        var title = $('#title').val().trim();
        var content = $('#content').val().trim();

        // Check if any required field is empty
        if (title === '' || content === '') {
            swal.fire({
                title: 'Error!',
                text: 'Please fill in all required fields.',
                icon: 'error'
            });
            return; // Prevent form submission
        }

        var formData = new FormData(this);
        formData.append('title', title);
        formData.append('content', content);

        $.ajax({
            url: 'groupCreate.php',
            method: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                swal.fire({
                    title: 'Success!',
                    text: response,
                    icon: 'success'
                }).then(function() {
                    // Redirect to groupFeed.php
                    window.location.href = 'groupFeed.php?groupID=<?php echo $groupID; ?>';
                });
            },
            error: function(xhr, status, error) {
                swal.fire({
                    title: 'Error!',
                    text: 'Failed to create post. Please try again later.',
                    icon: 'error'
                });
            }
        });
    });
});



</script>

</body>
</html>
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

