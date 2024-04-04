<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
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
        .container {
    max-width: 1550px;
    margin: 150px auto 0;
    text-align: center;
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
        <a href="profile.php" class="btn">Profile</a>
        <a href="3newsfeed.php" class="btn">Newsfeed</a>
        <a href="createPost.php" class="btn active">Create Post</a>
        <a href="faq.php" class="btn">FAQs</a>
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
        <label for="image1">IMAGE 1</label>
        <input type="file" id="image1" name="image1">
        <div id="image2Container" style="display: none;">
            <label for="image2">IMAGE 2</label>
            <input type="file" id="image2" name="image2">
        </div>
        <div id="image3Container" style="display: none;">
            <label for="image3">IMAGE 3</label>
            <input type="file" id="image3" name="image3">
        </div>
        <div id="image4Container" style="display: none;">
            <label for="image4">IMAGE 4</label>
            <input type="file" id="image4" name="image4">
        </div>
        <div id="image5Container" style="display: none;">
            <label for="image5">IMAGE 5</label>
            <input type="file" id="image5" name="image5">
        </div>
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

            var formData = new FormData(this);
            formData.append('title', $('#title').val());
            formData.append('content', $('#content').val());

            $.ajax({
                url: 'create.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response){
                    alert(response); 
                    window.location.href = '3newsfeed.php';
                }
            });
        });
    });
</script>

</body>
</html>
