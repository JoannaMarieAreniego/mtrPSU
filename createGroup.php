<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Create Group</title>
</head>
<body>
<!-- <header>
    <div class="logo">
        <img src="images/psuLOGO.png" alt="">
    </div>
    <h1>PSUnian Space</h1>
    <nav>
        <a href="3newsfeed.php" class="btn">Home</a>
        <a href="groupFeed.php" class="btn">Group Feed</a>
        <a href="groups.php" class="btn">Groups</a>
        <a href="createGroup.php" class="btn active">Create Group</a>
        <a href="logout.php" class="btn">Logout</a>
    </nav>
</header> -->
    <h1>Create Group</h1>

    <form id="createGroupForm" method="post" action="createGroupProcess.php">
        <label for="groupName">Group Name:</label>
        <input type="text" id="groupName" name="groupName"><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br><br>

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
        <br>

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
        </select><br><br>

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
                    $("#errorContainer").html("<p>Please fill in all fields.</p>");
                    return;
                }

                if (moderator === null) {
                    $("#errorContainer").html("<p>Please select a moderator.</p>");
                    return;
                }

                if (moderator == '<?php echo $creatorID; ?>' || moderator == 'admin') {
                    $("#errorContainer").html("<p>Creator or admin cannot be selected as moderator.</p>");
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
                        alert("Group created successfully!"); // I-add ang alert function dito
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("Error: " + xhr.responseText); // I-add din ang alert function para sa mga error
                    }
                });
            });
        });
    </script>
</body>
</html>
