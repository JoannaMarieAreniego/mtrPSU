<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="js/jquery-3.3.1.js?ver=002"></script>
    <script src="js/2login.js?ver=005"></script>
    <style>
        *{
            margin:0;
            padding:0;
        }

        .main {
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 50%, rgba(0, 0, 0, 0.5) 50%), url(images/psuu.jpg);
            background-position: center;
            background-size: cover;
            height: 109vh;
            height: 100vh; 
            overflow-y: auto; 
        }
        .navbar {
            width: 100%;
            height: 75px;
            margin: auto;
        }
        .icon{
            height: 70px;
        }
        .logo {
            color: #FFDA27;
            font-size: 50px;
            font-family: "Old English Text MT", serif;
            padding-left: 20px;
            float: left;
            padding-top: 20px;
        }
        .content{
            width: 1200px;
            height: auto;
            margin: auto;
            color: white;
            position: relative;
        }
        .content .par {
            padding-left: 20px;
            padding-bottom: 25px;
            font-family: "Arial";
            letter-spacing: 1.2px;
            line-height: 30px;
        }
        .content h1{
            font-family: "Times New Roman";
            font-size: 50px;
            padding-left: 20px;
            margin-top: 9%;
            letter-spacing: 2px;
        }
        .content .cn {
            width: 160px;
            height: 40px;
            background: #FFDA27;
            border: none;
            margin-bottom: 10px;
            margin-left: 20px;
            border-radius: 10px;
            cursor: pointer;
            transition: .4s ease;
        }
        .content .cn a {
            text-decoration: none;
            color: black;
            transition: .3s ease;
        }
        .cn:hover {
            background-color: white;
        }
        .content .space{
            color: #FFDA27;
            font-size: 60px;
        }
        .btn{
            width: 300px;
            height: 40px;
            background: #FFDA27;
            border: 2px solid #FFDA27;
            margin-top: 13px;
            font-size: 15px;
            border-bottom-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border-radius: 50px;
            cursor: pointer;
        }
        .btn:focus {
            outline: none;
        }
        .btn {
    width: 240px;
    height: 40px;
    background: #FFDA27;
    border: none;
    margin-top: 30px;
    font-size: 18px;
    border-radius: 10px; 
    cursor: pointer;
    color: white;
    transition: 0.4s ease;
    color: black;
}

.btn:hover {
    background: white;
    color: #FFDA27;
}
.form {
    width: 400px;
    height: 400px;
    position: absolute;
    top: 50%;
    left: calc(50% + 350px);
    transform: translate(-50%, -50%);
    border-radius: 10px;
    padding: 25px;
    background-image: url('images/lion.png');
    background-size: 100%;

    background-repeat: no-repeat;
    background-position: center;
}


    </style>
</head>
<body>

<div class="main">
    <div class="navbar">
        <div class="icon">
            <!-- <h2 class="logo">Pangasinan State University</h2> -->
        </div>
    </div>

    <div class="content">
        <h1>PSUnian <br><span class="space">Space</span></h1>
        <p class="par">PSUnian Space is a platform dedicated to the Pangasinan State University
            <br> community, including instructors and students, providing a space for them to
            <br> express their thoughts and emotions with others. This website is tailored 
            <br>specifically for members of the PSU community.</p>
            <button class="btn" onclick="redirectToLogin()">JOIN NOW</button>
    </div>
    <div class="form">
        
    </div>
</div>

<script>
    function redirectToLogin() {
        $.ajax({
            type: "GET",
            url: "logintry.php",
            success: function(data) {
                window.location.href = "logintry.php";
            }
        });
    }
</script>

</body>
</html>
