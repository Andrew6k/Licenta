<?php
  include('server.php');
  
  $id = $_GET["id"];
  $sql = "SELECT * FROM publications WHERE id=$id";
  $result = mysqli_query($mysqli, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $title = $row["title"];
    $year = $row["year"];
    $conference = $row["conference"];
    $summary = $row["summary"];
    $citations = $row["citations"];
    $link = $row["link"];
  } 
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
    <a href="homepage.php">Home</a>
    <?php if($_SESSION['username']) {
      $name = $_SESSION['username'];
      echo "<a href='mypage.php'>$name</a><br>";
    }else {
      echo "<a href='login.php'>Log in</a><br>";
    }
    ?>
</div>
<div class="container-res">
      <img src="logo.png" alt="My Logo">
      <div class="author-info">
    <?php
        echo "<h1>$title</h1>";
    ?>
    </div>
</div>

<div class="articles">
         <table align="center" border="1px"">
            <tr>
                <td>Conference</td>
                <td><?php echo $conference; ?></td>
            </tr>
            <tr>
                <td>Year</td>
                <td><?php echo $year; ?></td>
            </tr>
            <tr>
                <td>Summary</td>
                <td><?php echo $summary; ?></td>
            </tr>
            <tr>
                <td>Citations</td>
                <td><?php echo $citations; ?></td>
            </tr>
            <tr>
                <td>Link</td>
                <td><?php echo "<a href='$link'>Original link</a><br>";?></td>
            </tr>
              
    </table>
</div>
</body>
</html>