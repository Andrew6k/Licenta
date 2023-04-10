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
    <link rel="stylesheet" type="text/css" href="form.css">
  </head>
  <body>
  <form action="update_publications.php" method="post">
  <input type="hidden" name="author_id" value="<?php echo $author_id; ?>">
  <label for="publication_title">Publication Title:</label>
  <input type="text" id="publication_title" name="publication_title" value="<?php echo $title; ?>">
  <label for="publication_year">Publication Year:</label>
  <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($year); ?>">
  <label for="publication_journal">Publication Journal:</label>
  <input type="text" id="publication_journal" name="publication_journal" value="<?php echo $conference; ?>">
  <label for="citation_count">Citation Count:</label>
  <input type="number" id="citation_count" name="citation_count" value="<?php echo htmlspecialchars($citations); ?>">
  <input type="submit" value="Save">
</form>
  </body>
</html>
