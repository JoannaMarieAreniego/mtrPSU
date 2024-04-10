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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">
    <title>Profile</title>

    <style>    
   body {
    background-color: #f8f9fa;
    color: #343a40;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh; 
}

.container {
    padding: 20px;
    min-width: 1200px;
    margin: 0 auto;
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


        .container {
            max-width: 1100px;
            margin: 120px auto 20px;
            padding: 0 20px;
        }

        .post {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
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
      .btn-delete {
     
            font-size: 14px;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1;
            background-color: #7D0A0A;
        }

        .btn-edit {
            position: absolute;
            top: 10px;
            right: 120px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 0 10px;
            }
        }
        .post-img {
            max-width: 100%;
        height: 100px;
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

    .dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown button */
.dropbtn {
  background-color: #3498db;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* Dropdown content (hidden by default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 10px 15px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {
  background-color: #f1f1f1;
}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  background-color: #2980b9;
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
    <div class="dropdown">
        <a href="profile.php" class="btn active">Profile</a>
        <div class="dropdown-content">
        <a href="userProfile.php">Profile</a>
        <a href="profile.php">Posts</a>
        <a href="favorites.php">Favorites</a>
  </div>
    </div>
        <a href="3newsfeed.php" class="btn">Newsfeed</a>
        <a href="createPost.php" class="btn">Create Post</a>
        <a href="faq.php" class="btn">FAQs</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>

<?php

include("0conn.php");

$user_id = $_SESSION['studID'];

$sql = "SELECT * FROM users WHERE studID = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // Fetch the row as an associative array
    $studID = $row['studID'];
    $fname = $row['firstname'];
    $lname = $row['lastname'];
    $username = $row['username'];
    $password = $row['password']; // Access the username property from the array
}
?>
<div class="container">
<h1><?php echo $studID ?></h1>
<h1><?php echo $fname ?></h1>
<h1><?php echo $lname ?></h1>
<h1><?php echo $username ?></h1>
<h1><?php echo $password ?></h1>
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
