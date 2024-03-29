<?php
include("0conn.php");

$sql = "SELECT posts.*, users.username FROM posts INNER JOIN users ON posts.studID = users.studID ORDER BY posts.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="post">
            <h2><?php echo $row['title'] ?></h2>
            <p><?php echo $row['content'] ?></p>
            <div class="image-container">
                <?php 
                   
                    $postImages = array($row['postImage'], $row['postImage2'], $row['postImage3'], $row['postImage4'], $row['postImage5']);
                    foreach($postImages as $image) {
                        if (!empty($image)) {
                            echo '<img src="' . $image . '" alt="Post Image" class="post-image">';
                        }
                    }
                ?>
            </div>
            <p class="post-meta">By <?php echo $row['username'] ?> on <?php echo $row['created_at'] ?></p>
        </div>
        <?php
    }
} else {
    echo "No posts found.";
}
?>
