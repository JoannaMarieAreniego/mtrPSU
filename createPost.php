<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- <link rel="stylesheet" type="text/css" href="style.css?version=001"> -->
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

header {
background-color: #0927D8;
color: #f8f9fa;
padding: 20px;
text-align: center;
position: fixed;
top: 0;
width: 100%;
z-index: 1000;
display: flex;
justify-content: space-between;
align-items: center;
}

header h1 {
font-family: "Old English Text MT", serif;
font-size: 45px; 
color: #fff; 
text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
margin-bottom: 10px;
}



.logo {
margin-right: 50;
}

.logo img {
height: 75px;
width: auto;
border-radius: 50%; 
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
transition: transform 0.3s ease; 
}

.logo img:hover {
transform: scale(1.1); 
}
nav {
margin-left: auto; 
}
.btn {
display: inline-block;
padding: 10px 20px;
background-color: #007bff;
color: white;
text-decoration: none;
border-radius: 50px;
margin-right: 10px;
box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
}
.btnd {
    padding: 10px 20px;
    background-color: #7D0A0A;
    color: white;
    border-radius: 50px;
    margin-right: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
}


nav {
margin-left: auto;
display: flex;
justify-content: flex-end;
}

.btn.active {
    background-color: #FFDA27;
    color: black
}

.btn:hover {
    background-color: #0056b3;
    color: white;
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
        footer {
    background-color: #0927D8;
    color: #f8f9fa;
    padding: 20px;
    width: 100%;
    position: fixed;
    bottom: 0;
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
    <h1>PSUnian Space</h1>
    <nav>
        <a href="profile.php" class="btn">Profile</a>
        <a href="3newsfeed.php" class="btn">Newsfeed</a>
        <a href="createPost.php" class="btn active">Create Post</a>
        <a href="groups.php" class="btn">Groups</a>
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
        <input type="file" name="images[]" id="images" multiple>
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
            if (response.trim().startsWith('Error:')) {
    // Handle error response
    Swal.fire({
        icon: 'warning',
        title: 'Error',
        text: response.substring(8).trim(), // Remove 'Error:' prefix
        showConfirmButton: false,
        timer: 1200
    });
}
 else {
                // Handle success response
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response,
                    showConfirmButton: false,
                    timer: 1200
                }).then(() => {
                    window.location.href = '3newsfeed.php';
                });
            }
        }
    });
});

    });
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
</body>
</html>


