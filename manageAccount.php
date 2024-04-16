<!-- manageAccount.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css?version=002">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    tr:hover {background-color: #DDDDDD;}

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
    position: fixed;
    bottom: 0;
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
        <a href="reportedPost.php" class="btn">Reports</a>
        <a href="manageAccount.php" class="btn active">Manage Accounts</a>
        <a href="logout.php" class="btn">Logout</a>
    </header>
   <div class="container">
   <h1>User Accounts Management</h1>
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
                url: 'loadAccounts.php',
                method: 'GET',
                success: function(response) {
                    $('#accountsContainer').html(response);
                }
            });
        }

        function deleteUser(studID) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'deleteAccount.php',
                method: 'POST',
                data: { studID: studID },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Deleted!',
                            'The account has been deleted.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                loadAccounts();
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire(
                            'Deleted!',
                            'The account has been deleted.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                loadAccounts();
                                location.reload();
                            }
                        });
                    }
                },
                error: function() {
                    Swal.fire(
                        'Error!',
                        'An error occurred while deleting the account.',
                        'error'
                    );
                }
            });
        }
    });
}


    </script>
</body>
</html>
