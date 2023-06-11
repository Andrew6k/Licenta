<?php
  include('server.php');
  include('import_export.php');

  $mail = $_SESSION['username'];
  $sql = "SELECT id,name, affiliation, email_domain, citations, isadmin FROM authors WHERE mail='$mail'";
  $result = mysqli_query($mysqli, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];
    $nameD = $row["name"];
    $affiliation = $row["affiliation"];
    $email_domain = $row["email_domain"];
    $citations = $row["citations"];
    $isadmin = $row['isadmin'];
  }    
  
  $nr = intval($id);
  $sql = "SELECT domain FROM domains JOIN author_domains ON domains.id = author_domains.domain_id  WHERE author_id = $nr";
  $result = mysqli_query($mysqli, $sql);
 
  $fields = array();
  
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $domain = $row["domain"];
    // echo $domain;
    array_push($fields,$domain);
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
<div class="container-res">
      <img src="logo.png" alt="My Logo">
      <div class="author-info">
    <?php
        echo "<h1>$nameD</h1>";
        if ($isadmin == 0){
        echo "<p>Affiliation: $affiliation</p>";
        echo "<p>Email Domain: $email_domain</p>";
        echo "<p>Citations: $citations</p>";
        echo "Domains: ";
        foreach ($fields as $field) {
            echo $field . "<br>";
        } }
        // print_r($fields)
    ?>
    <div class="buttons">
        <h3>View tables</h3>
        <?php 
         echo "<a href='tables.php?obj=journalsIF'>Journals IF</a>";
         echo "<a href='tables.php?obj=journalsAIS'>Journals AIS</a>";
         echo "<a href='tables.php?obj=conferences'>Conferences</a>";
         echo "<a href='tables.php?obj=domains'>Domains</a>";
         echo "<a href='tables.php?obj=publ'>Publications</a>";
         echo "<a href='tables.php?obj=authors'>Authors</a>";
        ?>
            
    </div>
    </div>
</div>

<div class="operations">
    <div class="reg">
        <h3>New author</h3>
        <a href="register.php">Register</a>
    </div>
    <div class="update">
        <h3>Update database</h3>
        <a href="update.php">Update</a>
    </div>
    <div class="display">
        <h3>Display graph</h3>
        <a href="graph.php">Citations graph</a>
    </div>
  </div>
<div class="delete-author">
<form method="post" action="delete-author.php">
  <label for="author_id"><strong>Select an author to delete:</strong></label>
  <select name="author_id" id="author_id">
    <?php
      $authors_query = "SELECT * FROM authors";
      $authors_result = mysqli_query($mysqli, $authors_query);
      $authors = mysqli_fetch_all($authors_result, MYSQLI_ASSOC);
      
      // Generate the HTML for the dropdown list
      foreach ($authors as $author) {
        echo '<option value="' . $author['id'] . '">' . $author['name'] . '</option>';
      }
    ?>
  </select>
  <input type="submit" value="Delete Author">
</form>
<?php
// Retrieve the message from the cookie
if(isset($_COOKIE['message'])){
  $message = $_COOKIE['message'];
  // Clear the cookie
  setcookie('message', '', time() - 3600); // expires in the past
  echo "<h4>$message</h4>";}
?>
</div>

<div class="buttons-import">
        <form action="importCSV.php" method="post" enctype="multipart/form-data">
            <input type="file" class="btn-submit" name="file" accept=".csv">
            <select name="table-select" id="table-select">
              <option value="choose">Choose a table</option>
              <option value="journals-ais">Journals AIS</option>
              <option value="journals-if">Journals IF</option>
              <option value="conferences">Conferences</option>
            </select>
            <input type="submit" class="btn-submit" name="iCSV" value="Import CSV">
        </form>
        <?php
        if(isset($_COOKIE['message-import'])){
          $message = $_COOKIE['message-import'];
          // Clear the cookie
          setcookie('message-import', '', time() - 3600); // expires in the past
          echo "<h4>$message</h4>";}
        ?>
    </div>
</body>
</html>