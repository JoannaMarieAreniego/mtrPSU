<?php 
   session_start();
   if (!isset($_SESSION['studID'])) {
    header("Location: logintry.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="style.css">
  <title>FAQs</title>

  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: "Arial Black", sans-serif;
      background-color: #f8f9fa;
      color: #343a40;
      margin: 0;
      padding: 0;
    }

    .container {
      flex: 1;
      padding: 20px;
      min-width: 1200px;
      margin: 0 auto;
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
      text-align: left;
    }

    .right-content {
      text-align: right;
    }

    .left-content p,
    .right-content p {
      margin: 0;
    }

    .container {
      max-width: 1100px;
      margin: 120px auto 20px;
      padding: 0 20px;
    }

    @media only screen and (max-width: 600px) {
      .container {
        padding: 0 10px;
      }
    }

    .faq-question {
        cursor: pointer; 
        background-color: #ffffff;
        padding: 10px 15px;
        margin-bottom: 5px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .faq-question:hover {
        background-color: #007bff;
        color: #ffffff; 
    }

    .faq-answer {
        display: none;
        padding: 10px; 
        background-color: #f8f8f8;
        border-radius: 5px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">
    <img src="images/psuLOGO.png" alt="">
  </div>
  <h1>Pangasinan State University</h1>
  <nav>
    <a href="profile.php" class="btn">Profile</a>
    <a href="3newsfeed.php" class="btn">Newsfeed</a>
    <a href="createPost.php" class="btn">Create Post</a>
    <a href="faq.php" class="btn active">FAQs</a>
    <a href="logout.php" class="btn">Logout</a>
  </nav>
</header>

<div class="container" id="faqContainer">
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
  $.ajax({
    url: 'fetch_faqs.php',
    method: 'GET',
    dataType: 'json',
    success: function(faqs) {
      var faqContainer = $('#faqContainer');
      for (var i = 0; i < faqs.length; i++) {
        var question = faqs[i];
        faqContainer.append('<div class="faq-question" id="question-' + i + '">' + question.question + '</div>');
        faqContainer.append('<div class="faq-answer" id="answer-' + i + '">' + faqs[i].answer + '</div>');
      }

      $('.faq-question').click(function() {
        var index = $(this).attr('id').split('-')[1];
        $('#answer-' + index).slideToggle();
        $('.faq-answer').not('#answer-' + index).slideUp();
      });
    },
    error: function(xhr, status, error) {
      console.error(xhr.responseText);
    }
  });
});
</script>

</body>
</html>