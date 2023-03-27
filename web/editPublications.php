<?php
    include('server.php');

    $author_id = $_SESSION['auth_id'];
    $sql = "SELECT * FROM authors WHERE id = $author_id";
    $result = mysqli_query($mysqli, $sql);
    $author = mysqli_fetch_assoc($result);

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
  <input type="text" id="publication_title" name="publication_title" value="<?php echo $publication_title; ?>">
  <label for="publication_date">Publication Date:</label>
  <input type="date" id="publication_date" name="publication_date" value="<?php echo $publication_date; ?>">
  <label for="publication_journal">Publication Journal:</label>
  <input type="text" id="publication_journal" name="publication_journal" value="<?php echo $publication_journal; ?>">
  <label for="citation_count">Citation Count:</label>
  <input type="number" id="citation_count" name="citation_count" value="<?php echo $citation_count; ?>">
  <input type="submit" value="Save">
</form>
  </body>
</html>
