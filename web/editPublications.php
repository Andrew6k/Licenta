<?php
    include('server.php');

    // $author_id = $_SESSION['auth_id'];
    // $sql = "SELECT * FROM authors WHERE id = $author_id";
    // $result = mysqli_query($mysqli, $sql);
    // $author = mysqli_fetch_assoc($result);

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

// Display the form for editing the author's information
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Edit Form</title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <link rel="stylesheet" href="form.css">
  </head>
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
      echo "<a href='login.php'>Log in</a>";
    }
    ?>
    <a href="homepage.php">Home</a>
</div>
  <body>
    <div class="background">
  <form action="update_publications.php" method="post">
  <input type="hidden" name="publication_id" value="<?php echo $id; ?>">
  <label for="publication_title">Publication Title:</label>
  <input type="text" id="publication_title" name="publication_title" value="<?php echo $title; ?>">
  <label for="publication_year">Publication Year:</label>
  <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>">
  <label for="publication_conference">Publication Conference:</label>
  <input type="text" id="publication_conference" name="publication_conference" value="<?php echo $conference; ?>">
  <label for="citation_count">Citation Count:</label>
  <input type="number" id="citation_count" name="citation_count" value="<?php echo htmlspecialchars($citations); ?>">
  <input type="submit" value="Save">
</form>
<div class="msj">
  <?php if (isset($_SESSION['messageUp'])) {
    echo $_SESSION['messageUp'];
    unset($_SESSION['messageUp']);
          }?>
 </div>
</div>
  </body>
</html>
