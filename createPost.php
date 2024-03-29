<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
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

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        header {
            background-color: #343a40;
            color: #f8f9fa;
            padding: 20px;
            text-align: center;
        }

        footer {
            background-color: #343a40;
            color: #f8f9fa;
            text-align: center;
            padding: 20px;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

        footer p {
            margin: 0;
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

        .btn:hover {
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
    </style>
</head>
<body>
    <header>
        <h1>PSU</h1>
        <a href="profile.php" class="btn">Profile</a>
        <a href="createPost.php" class="btn">Create Post</a>
    </header>

    <h1>Create a Post</h1>
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
        <p>Pangasinan State University lorem epsum</p>
        <p>&copy; 2023 Jane</p>
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
