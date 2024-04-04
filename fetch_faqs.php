<?php
// Connect to your database
include("0conn.php");

// Fetch FAQs from the database
$query = "SELECT question, answer FROM FAQ";
$result = mysqli_query($conn, $query);

$faqs = array();
while ($row = mysqli_fetch_assoc($result)) {
  $faqs[] = array(
    "question" => $row['question'],
    "answer" => $row['answer'],
  );
}

// Return FAQs as JSON
echo json_encode($faqs);
?>
