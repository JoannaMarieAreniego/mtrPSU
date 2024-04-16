<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Create Group</title>
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #0927D8;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .logo img {
            height: 60px;
            margin-right: 10px;
            vertical-align: middle;
        }

        h1 {
            margin-top: 20px;
            text-align: center;
        }

        form {
            max-width: 600px;
            margin: 80px auto 20px; /* Adjusted margin-top to accommodate the header */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        #errorContainer {
            margin-top: 10px;
            color: red;
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
        <a href="groups.php" class="btn">Groups</a>
        <a href="createGroup.php" class="btn active">Create Group</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header>

<h1>Create Group</h1>

<form id="createGroupForm" method="post" action="createGroupProcess.php">
    <label for="groupName">Group Name:</label>
    <input type="text" id="groupName" name="groupName">

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea>

    <label>Members:</label><br>
    <?php
    require "0conn.php";
    session_start();
    $creatorID = $_SESSION['studID'];
    $sql = "SELECT * FROM users WHERE studID != 'admin' AND studID != '$creatorID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<input type='checkbox' name='members[]' value='" . $row['studID'] . "'> " . $row['firstname'] . " " . $row['lastname'] . "<br>";
        }
    }
    $conn->close();
    ?>

    <label for="moderator">Moderator:</label>
    <select id="moderator" name="moderator">
        <?php
        require "0conn.php"; // Include database connection again
        session_start();
        $creatorID = $_SESSION['studID'];
        $sql = "SELECT * FROM users WHERE studID != '$creatorID' AND studID != 'admin'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['studID'] . "'>" . $row['firstname'] . " " . $row['lastname'] . "</option>";
            }
        }
        $conn->close();
        ?>
    </select>

    <button type="submit" id="createGroupBtn">Create Group</button>
</form>

<div id="errorContainer"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#createGroupForm").submit(function(event) {
            event.preventDefault(); // Prevent default form submission
            
            var groupName = $("#groupName").val();
            var description = $("#description").val();
            var members = $("input[name='members[]']:checked").map(function(){
                return $(this).val();
            }).get();
            var moderator = $("#moderator").val();

            if (groupName.trim() === '' || description.trim() === '') {
                showError("Please fill in all fields.");
                return;
            }

            if (moderator === null) {
                showError("Please select a moderator.");
                return;
            }

            if (moderator == '<?php echo $creatorID; ?>' || moderator == 'admin') {
                showError("Creator or admin cannot be selected as moderator.");
                return;
            }

            $.ajax({
                url: "createGroupProcess.php",
                method: "POST",
                data: {
                    groupName: groupName,
                    description: description,
                    members: members,
                    moderator: moderator
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Group created successfully!',
                        timer: 2000, // Set a timer for auto-close if needed
                        timerProgressBar: true,
                        didClose: () => {
                            window.location.href = 'groups.php'; // Redirect to groups.php
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    showError("Error: " + xhr.responseText);
                }
            });
        });

        function showError(message) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: message
            });
        }
    });
</script>
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
