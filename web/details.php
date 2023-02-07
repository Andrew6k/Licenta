<?php
  include('server.php');
  
  $id = $_GET["id"];
  $sql = "SELECT name, affiliation, email_domain, citations FROM authors WHERE id=$id";
  $result = mysqli_query($mysqli, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row["name"];
    $affiliation = $row["affiliation"];
    $email_domain = $row["email_domain"];
    $citations = $row["citations"];
    
  }    
  
  $sql = "SELECT domain FROM domains JOIN author_domains ON domains.id = author_domains.domain_id  WHERE author_id = $id";
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
        echo "<h1>$name</h1>";
        echo "<p>Affiliation: $affiliation</p>";
        echo "<p>Email Domain: $email_domain</p>";
        echo "<p>Citations: $citations</p>";
        echo "Domains: ";
        foreach ($fields as $field) {
            echo $field . "<br>";
        }
        // print_r($fields)
    ?>
    </div>
</div>

<div class="articles">
    <?php 
      $nr = intval($id);
      $sql = "SELECT id, title, conference, year, citations, link FROM publications JOIN author_publications ON publications.id = author_publications.publication_id  WHERE author_id = '$nr'";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table align="center" border="1px"">
        <tr>
            <th colspan="5"><h2 style="text-align: center;">Publications</h2></th>
        </tr>

        <t>
            <th>Title</th>
            <th>Conference</th>
            <th>Year</th>
            <th>Citations</th>
            <th>Link</th>
        </t>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
            $id = $rows['id'];
            $title = $rows['title'];
        ?>
            <tr>
                <td><?php echo $rows['title']; ?></td>
                <td><?php echo $rows['conference']; ?></td>
                <td><?php echo $rows['year']; ?></td>
                <td><?php echo $rows['citations']; ?></td>
                <td><?php echo "<a href='pub-det.php?id=$id'>More information</a><br>";?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
</body>
</html>