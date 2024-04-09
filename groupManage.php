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

$checkPermissionSQL = "SELECT * FROM groups WHERE groupID = '$groupID' AND (created_by = '$studID' OR EXISTS (SELECT 1 FROM groupmembers WHERE groupID = '$groupID' AND studID = '$studID' AND is_moderator = 1))";
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


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
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
    <form method="POST" action="">
        <input type="hidden" name="deleteGroup" value="true">
        <button type="submit" onclick="return confirm('Are you sure you want to delete this group?')">Delete Group</button>
    </form>
</body>
</html>

<script>
    function kickMember(memberID) {
            $.ajax({
                url: 'groupManage.php',
                method: 'GET',
                data: {
                    groupID: <?php echo $groupID; ?>,
                    kickMember: memberID
                },
                success: function(response) {
                    $('#member_' + memberID).remove(); 
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Error: " + xhr.responseText);
                }
            });
    }

    function deleteGroup() {
        console.log("Delete Group function called");
        if (confirm("Are you sure you want to delete this group?")) {
            $.ajax({
                url: 'groupManage.php',
                method: 'POST',
                data: {
                    deleteGroup: true,
                    groupID: '<?php echo $groupID; ?>'
                },
                success: function(response) {
                    alert("Delete group request successful");
                    window.location.href = 'groups.php';
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Error: " + xhr.responseText);
                }
            });
        }
    }

</script>
