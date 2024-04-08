<?php
// Include database connection
require "0conn.php";

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['studID'])) {
    // Handle unauthorized access
    header("Location: login.php"); // Redirect to login page or display an error message
    exit();
}

// Get data from POST request
$groupName = $_POST['groupName'];
$description = $_POST['description'];
$members = $_POST['members'];
$moderator = $_POST['moderator'];
$creatorID = $_SESSION['studID'];

// Insert into groups table
$addGroupQuery = "INSERT INTO groups (groupname, description, group_created_at, created_by)
                  VALUES ('$groupName', '$description', NOW(), '$creatorID')";
if ($conn->query($addGroupQuery) === TRUE) {
    $groupID = $conn->insert_id; // Get the group ID of the newly inserted group
} else {
    echo "Error: " . $addGroupQuery . "<br>" . $conn->error;
    exit();
}

// Insert creator as a group member
$addCreatorQuery = "INSERT INTO groupmembers (groupID, studID, is_moderator)
                    VALUES ('$groupID', '$creatorID', '1')"; // Creator is always a moderator
$conn->query($addCreatorQuery);

// Insert other members into groupmembers table
foreach ($members as $member) {
    $addMemberQuery = "INSERT INTO groupmembers (groupID, studID, is_moderator)
                       VALUES ('$groupID', '$member', '0')"; // Other members are not moderators by default
    $conn->query($addMemberQuery);
}

// Insert moderator into groupmembers table
$addModeratorQuery = "INSERT INTO groupmembers (groupID, studID, is_moderator)
                      VALUES ('$groupID', '$moderator', '1')"; // Moderator is always a moderator
$conn->query($addModeratorQuery);

// Close database connection
$conn->close();

// Return success message
echo "Group created successfully!";
?>
