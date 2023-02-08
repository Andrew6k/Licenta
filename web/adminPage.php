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
        <h3>Export options</h3>
        <form action="mypage.php" method="post" >
        <?php 
          if ($isadmin == 1) { ?>
        <select name="export-select">
            <option value="Authors">Authors</option>
            <option value="Publications">Publications</option>
            <option value="Domains">Domains</option>
        </select>
        <?php } ?>
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
            <!-- <input type="submit" class="btn-submit" name="ePDF" value="Export PDF"> -->
        </form>
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
</body>
</html>