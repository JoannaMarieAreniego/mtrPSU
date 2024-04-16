<?php
require "0conn.php";
session_start();

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}
$studID = $_SESSION['studID'];

$getMemberGroupsSQL = "SELECT DISTINCT groups.groupID, groups.groupname, groups.description 
                      FROM groups 
                      INNER JOIN groupmembers ON groups.groupID = groupmembers.groupID 
                      WHERE groupmembers.studID = '$studID'";
$memberGroupsResult = $conn->query($getMemberGroupsSQL);

$getAdminGroupsSQL = "SELECT DISTINCT groups.groupID, groups.groupname, groups.description 
                      FROM groups 
                      INNER JOIN groupmembers ON groups.groupID = groupmembers.groupID 
                      WHERE (groupmembers.studID = '$studID' AND groupmembers.is_moderator = '1')
                      OR groups.created_by = '$studID'";
$adminGroupsResult = $conn->query($getAdminGroupsSQL);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Groups</title>
    <style>
        .group-container {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa; 
            color: #343a40;
            margin: 0;
            padding: 0;
        }

        .container {
            flex: 1; 
            padding: 20px; 
            min-width: 1400px; 
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

    @media only screen and (max-width: 600px) {
        .container {
            padding: 0 10px;
            margin-top: 300px; 
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
        <a href="3newsfeed.php" class="btn">Home</a>
        <a href="groups.php" class="btn active">Groups</a>
        <a href="createGroup.php" class="btn">Create Group</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>
    <div class="container">
        <br>
        <h1>Groups</h1>
        <br><br>
        <h2>Groups You Are a Member Of:</h2>
        <?php
        if ($memberGroupsResult->num_rows > 0) {
            while ($row = $memberGroupsResult->fetch_assoc()) {
                echo "<div class='group-container'>";
                echo "<a href='groupFeed.php?groupID={$row['groupID']}'><strong>{$row['groupname']}</strong></a> - {$row['description']}";
                echo "</div>";
            }
        } else {
            echo "<p>You are not a member of any group.</p>";
        }
        ?>
        <br><br>
        <h2>Groups You Are an Admin or Moderator Of:</h2>
        <?php
        if ($adminGroupsResult->num_rows > 0) {
            while ($row = $adminGroupsResult->fetch_assoc()) {
                echo "<div class='group-container'>";
                echo "<a href='groupFeed.php?groupID={$row['groupID']}'><strong>{$row['groupname']}</strong></a> - {$row['description']}";
                echo "</div>";
            }
        } else {
            echo "<p>You are not an admin or moderator of any group.</p>";
        }
        ?>
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
</body>
</html>
