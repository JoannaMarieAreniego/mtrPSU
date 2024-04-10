<?php
require "0conn.php";
session_start();

if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}

if (!isset($_GET['groupID'])) {
    header("Location: groups.php");
    exit;
}

$studID = $_SESSION['studID'];
$groupID = $_GET['groupID'];

$checkPermissionSQL = "SELECT * FROM groups WHERE groupID = '$groupID' AND (created_by = '$studID' OR EXISTS (SELECT 1 FROM groupmembers WHERE groupID = '$groupID' AND studID = '$studID' AND is_moderator = '1'))";
$permissionResult = $conn->query($checkPermissionSQL);

if ($permissionResult->num_rows == 0) {
    header("Location: groupFeed.php?groupID=$groupID");
    exit;
}

if (isset($_POST['updateGroup'])) {
    $newGroupName = $_POST['groupName'];
    $newDescription = $_POST['description'];

    $updateGroupSQL = "UPDATE groups SET groupname = '$newGroupName', description = '$newDescription' WHERE groupID = '$groupID'";
    $conn->query($updateGroupSQL);
}

if (isset($_POST['addMember'])) {
    $newMemberID = $_POST['newMemberID'];

    $addMemberSQL = "INSERT INTO groupmembers (groupID, studID) VALUES ('$groupID', '$newMemberID')";
$conn->query($addMemberSQL);

}

if (isset($_GET['kickMember'])) {
    $memberID = $_GET['kickMember'];

    $kickMemberSQL = "DELETE FROM groupmembers WHERE groupID = '$groupID' AND studID = '$memberID'";
    $conn->query($kickMemberSQL);

    header("Location: groupManage.php?groupID=$groupID");
    exit;
}

    if (isset($_POST['deleteGroup'])) {
        echo("here at deleteGroup");
        $deleteMembersSQL = "DELETE FROM groupmembers WHERE groupID = '$groupID'";
        if ($conn->query($deleteMembersSQL) === TRUE) {
            echo "Group members deleted successfully";
        } else {
            echo "Error deleting group members: " . $conn->error;
        }
        $deleteGroupSQL = "DELETE FROM groups WHERE groupID = '$groupID'";
        if ($conn->query($deleteGroupSQL) === TRUE) {
            echo "Group deleted successfully";
        } else {
            echo "Error deleting group: " . $conn->error;
        }
        header("Location: groups.php");
    }

$getGroupSQL = "SELECT * FROM groups WHERE groupID = '$groupID'";
$groupResult = $conn->query($getGroupSQL);
$group = $groupResult->fetch_assoc();


$getMembersSQL = "SELECT gm.studID, u.firstname, u.lastname, gm.is_moderator
                  FROM groupmembers gm
                  INNER JOIN users u ON gm.studID = u.studID
                  WHERE gm.groupID = '$groupID'";
$membersResult = $conn->query($getMembersSQL);

function isModerator($studID, $groupID) {
    global $conn;
  
    $checkModeratorSQL = "SELECT * FROM groupmembers WHERE groupID = '$groupID' AND studID = '$studID' AND is_moderator > 0";
    $moderatorResult = $conn->query($checkModeratorSQL);
  
    return $moderatorResult->num_rows > 0;
  }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11?ver=02"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        header {
            padding: 10px 0;
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1, h2 {
            margin-top: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            font-size: 16px;
        }
        button[type="submit"], button{
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
        }
        button[type="submit"]:hover, button:hover {
            background-color: #555;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a {
            color: #333;
            text-decoration: none;
            border-bottom: 1px dashed #333;
            margin-left: 10px;
        }
    </style>
    <title>Manage Group - <?php echo $group['groupname']; ?></title>
</head>
<body>
    <header>
        <div class="logo">
            <img src="images/psuLOGO.png" alt="">
        </div>
        <h1>PSUnian's Space</h1>
        <nav>
            <a href="3newsfeed.php" class="btn">Home</a>
            <a href="groupFeed.php" class="btn">Group Feed</a>
            <a href="groupCreatePost.php?groupID=<?php echo $groupID; ?>" class="btn">Create Post</a>
            <?php
                if ($_SESSION['studID'] == $group['created_by'] || isModerator($_SESSION['studID'], $groupID)) {
                    echo '<a href="groupManage.php?groupID=' . $groupID . '" class="btn active">Manage Group</a>';
                }
            ?>
            <a href="logout.php" class="btn">Logout</a>
        </nav>
    </header>
    <div class="container">
        <h1>Manage Group - <?php echo $group['groupname']; ?></h1>
        <h2>Update Group Details</h2>
        <form method="POST" action="">
            <label for="groupName">Group Name:</label>
            <input type="text" id="groupName" name="groupName" value="<?php echo $group['groupname']; ?>"><br><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description"><?php echo $group['description']; ?></textarea><br><br>
            <button type="submit" name="updateGroup">Update</button>
        </form>

        <h2>Add Member</h2>
        <form method="POST" action="">
            <label for="newMemberID">Member ID:</label>
            <input type="text" id="newMemberID" name="newMemberID"><br><br>
            <button type="submit" name="addMember">Add Member</button>
        </form>

        <h2>Group Members</h2>
        <ul id="groupMembers">
            <?php while ($member = $membersResult->fetch_assoc()) : ?>
                <li id="member_<?php echo $member['studID']; ?>">
                    <?php echo $member['firstname'] . ' ' . $member['lastname']; ?>
                    <?php if ($member['is_moderator'] == 0) : ?>
                        <a href="#" onclick="kickMember('<?php echo $member['studID']; ?>')">Kick</a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>

        <h2>Delete Group</h2>
        <form id="deleteGroupForm" method="POST" action="">
            <input type="hidden" name="deleteGroup" value="true">
            <button type="button" id="deleteGroupBtn">Delete Group</button>
        </form>

        <script>
            document.getElementById('deleteGroupBtn').addEventListener('click', function() {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var deleteGroupForm = document.getElementById('deleteGroupForm');
                        if (deleteGroupForm) {
                            deleteGroupForm.submit();
                        } else {
                            console.error('Delete group form not found');
                            Swal.fire(
                                'Error!',
                                'Failed to delete group. Please try again later.',
                                'error'
                            );
                        }
                    }
                });
            });
        </script>
    </form>
    </div>
</body>
</html>

<script>
  function kickMember(memberID) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, kick them!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'groupManage.php',
                        method: 'GET',
                        data: {
                            groupID: <?php echo $groupID; ?>,
                            kickMember: memberID
                        },
                        success: function(response) {
                            $('#member_' + memberID).remove();
                            Swal.fire(
                                'Deleted!',
                                'Your member has been kicked.',
                                'success'
                            );
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire(
                                'Error!',
                                'Failed to kick member. Please try again later.',
                                'error'
                            );
                        }
                    });
                }
            });
        }
</script>