<!-- report_databale.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?version=003">
    <title>Accept Reports Table</title>
    <style>
        
    table {
        width: 90%;
        margin: 0 auto;
        margin-bottom: 50px;
        font-family: Arial, sans-serif;
        border-collapse: collapse;
    }

    th {
        background-color: #FFDA27;
        border-bottom: 2px solid #ddd;
        padding: 8px;
        text-align: left;
        height: 70px;
    }

    td {
        height: 50px;
        border-bottom: 1px solid #ddd;
        padding: 8px;
    }

    tr:hover {background-color: #007bff;}
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
            width: 90%;
            max-width: 1600px; 
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
            text-align: left;
        }

        .right-content {
            text-align: right;
        }

        .left-content p,
        .right-content p {
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
        .header-content {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-content .logo {
            margin-right: auto; 
        }

        .header-content h1 {
            margin-left: auto; 
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
.button {
    padding: 10px 20px;
    text-decoration: none;
    color: #333;
}

.button.active {
    background-color: #FFDA27;
 /* Change to the desired highlight color */
    color: black; /* Change to the desired text color */
}


    </style>
</head>
<body>
<header>
        <div class="header-content">
            <div class="logo">
                <img src="images/psuLOGO.png" alt="">
            </div>
            <h1>PSUnian Space</h1>
        </div>
        <nav>
            <a href="dashboard.php" class="btn">Dashboard</a>
            <a href="admin_newsfeed.php" class="btn">Newsfeed</a>
            <div class="dropdown">
        <a href="reportedPost.php" class="btn active">Reports</a>
        <div class="dropdown-content">
        <a href="reportedPost.php" class="button">Pending</a>
        <a href="rejectedPost.php" class="button">Rejected</a>
        <a href="approvedPost.php" claass="button">Approved</a>
        <a href="report_datatable.php" class="button active">Export</a>
  </div>
    </div>
            <a href="manageAccount.php" class="btn">Manage Accounts</a>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </header>
<div class="container">
<h1>Reported Posts Management</h1>
<?php
require("0conn.php");

$query = "SELECT * FROM accept_reports";
$result = mysqli_query($conn, $query);

if(mysqli_num_rows($result) > 0) {
?>
    <table>
        <tr>
            <th>acceptID</th>
            <th>reportID</th>
            <th>postID</th>
            <th>reporterID</th>
            <th>reason</th>
            <th>report_created_at</th>
            <th>status</th>
            <th>accepted_date</th>
        </tr>
    <?php
        while($row = mysqli_fetch_assoc($result)) {
    ?>
        <tr>
            <td><?= $row['acceptID'] ?></td>
            <td><?= $row['reportID'] ?></td>
            <td><?= $row['postID'] ?></td>
            <td><?= $row['reporterID'] ?></td>
            <td><?= $row['reason'] ?></td>
            <td><?= $row['report_created_at'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['accepted_date'] ?></td>
        </tr>
    <?php
        }
    ?>
    </table>
    <form method="post" action="export.php">
        <button class="btn" type="submit">Export to CSV</button>
    </form>
    
<?php
} else {
    echo "0 results";
}

mysqli_close($conn);
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

</body>
</html>
