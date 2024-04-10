<!-- manageAccount.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">
    <title>Manage Accounts</title>
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

    .delete-btn {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 6px 12px;
        cursor: pointer;
        border-radius: 4px;
    }

    .delete-btn:hover {
        background-color: #cc0000;
    }

    .container {
        max-width: 1550px;
        margin: 80px auto 0;
        padding: 50px;
        text-align: center;
    }

    .btn.active {
        background-color: yellow;
        color: black;
    }

    .btn:hover {
        background-color: #0056b3;
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

    @media only screen and (max-width: 600px) {
        .container {
            padding: 0 10px;
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
        <a href="dashboard.php" class="btn">Dashboard</a>
        <a href="admin_newsfeed.php" class="btn">Newsfeed</a>
        <div class="dropdown">
        <a href="reportedPost.php" class="btn active">Reports</a>
        <div class="dropdown-content">
        <a href="reportedPost.php" class="btn active">Pending</a>
        <a href="rejectedPost.php">Rejected</a>
        <a href="approvedPost.php">Approved</a>
  </div>
    </div>
        <a href="manageAccount.php" class="btn">Manage Accounts</a>
        <a href="logout.php" class="btn">Logout</a>
    </header>
   <div class="container">
   <h1>Reported Posts Management</h1>
   </div>

    <div id="accountsContainer">
    
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            loadAccounts();
        });

        function loadAccounts() {
            $.ajax({
                url: 'loadReports.php',
                method: 'GET',
                success: function(response) {
                    $('#accountsContainer').html(response);
                }
            });
        }

        function rejectPost(postID) {
        $.ajax({
            url: 'updateStatus.php',
            method: 'POST',
            data: { postID: postID, status: 'Rejected' },
            success: function(response) {
                // Reload the accounts list after updating the status
                loadAccounts();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    function acceptPost(postID) {
        $.ajax({
            url: 'updateStatus.php',
            method: 'POST',
            data: { postID: postID, status: 'Approved' },
            success: function(response) {
                // Reload the accounts list after updating the status
                loadAccounts();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }
    

    </script>
</body>
</html>
