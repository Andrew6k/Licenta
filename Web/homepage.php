<?php
  include('server.php');
  // if (empty($_SESSION['username'])) {
  //   header('location: homepage.php');
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website scholarly</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="script.js"></script>
    <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> -->

  </head>
<body>
<div class="nav">
    <?php if(isset($_SESSION['username']) and isset($_SESSION['isadmin']) and ($_SESSION['isadmin'] == 0)) {
      $name = $_SESSION['username'];
      echo "<a href='logout.php'>Logout</a>";
      
      echo "<a href='mypage.php'>$name</a>";
      
    }elseif (isset($_SESSION['username']) and isset($_SESSION['isadmin']) and ($_SESSION['isadmin'] == 1)) {
      $name = $_SESSION['username'];
      echo "<a href='logout.php'>Logout</a>";
      
      echo "<a href='adminPage.php'>$name</a>";
    }else {
      echo "<a href='login.php'>Log in</a><br>";
    }
    ?>
</div>
<div class="container">
      <img src="logo.png" alt="My Logo">
      <div class="search-container">
      <form id="search-form" action="results.php" method="POST">
        <input type="text" name="search-querry" class="search-input" placeholder="Search authors or publications">
        <select name="criteria-select">
            <option value="author">Author</option>
            <option value="title">Title</option>
            <option value="domain">Domain</option>
            <option value="year">Year</option>
        </select>
        <input type="submit" value="Search">
      </form>
      </div>
      <!-- <div class="results-container">
        <div class="result-item">
          <div class="title">Article Title</div>
          <div class="author">Author Name</div>
          <div class="abstract">Abstract of the article goes here...</div>
        </div> -->
        <!-- Add more result items as needed -->
      </div>
    </div>

</body>
</html>