<?php
require '0conn.php';

// Start the session to access the current user's ID
session_start();

// Check if the current user ID is set in the session
if (!isset($_SESSION['studID'])) {
    echo "User ID not set.";
    exit();
}

$currentUserID = $_SESSION['studID'];

$postID = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($postID === false) {
    echo "Invalid post ID.";
    exit();
}

if(isset($_POST['comment'])) {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $studID = $_SESSION['studID'];

    $insertQuery = "INSERT INTO comments (postID, studID, comment, commentCreated) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iss", $postID, $studID, $comment);

    if ($stmt->execute()) {
        // Redirect to 3newsfeed.php after successfully adding comment
        header("Location: 3newsfeed.php");
        exit();
    } else {
        echo "Error adding comment: " . $conn->error;
    }
}




?>
<div class="con">
<?php
// DISPLAY COMMENT
$commentsQuery = "SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.studID = users.studID WHERE postID = ? ORDER BY commentCreated DESC";
$stmt = $conn->prepare($commentsQuery);
$stmt->bind_param("i", $postID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($comment = $result->fetch_assoc()) {
        ?>
<div class="con comment-container">
    <div class="comment-content">
        <p><?php echo "{$comment['username']} commented: <br> {$comment['comment']}"; ?></p>
    </div>
    <?php if ($comment['studID'] == $currentUserID) { ?>
        <form action="delete_comment.php" method="post">
            <input type="hidden" name="commentID" value="<?php echo $comment['commentID']; ?>">
            <button type="submit" class="btns" name="delete">Delete</button>
        </form>
    <?php } ?>
</div>


        <?php
    }
} else {
    echo "No comments yet.";
}
?>


<div class="con">
        <!-- Comment form -->
        <h3>Add Comment</h3>
        <form action="fetch_data(TRY).php?id=<?php echo $postID; ?>" method="post">
    <textarea name="comment" rows="4" cols="50"></textarea><br>
    <button type="submit" class="btns">Submit Comment</button>
</form>
</div>

<style>
.con.comment-container {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    position: relative;
}

.con.comment-container .comment-content {
    margin-bottom: 10px;
}

.con.comment-container .btns {
    position: absolute;
    top: 5px;
    right: 5px;
}


</style>
