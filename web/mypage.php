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

<script>function score(citations) {
        var points = 10;

        var score = citations * points;

        return score;
      }</script>
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
      <p>Score: <span id="score">
        <script>
        var score = score(<?php echo $citations; ?>);
        var scoreClass = "low-score";
        if (score >= 6000) {
          scoreClass = "high-score";
        } else if (score >= 3000) {
          scoreClass = "medium-score";
        }
        document.getElementById("score").className = scoreClass;
        document.write(score);
      </script></span></p>
    </div>
</div>

<div class="articles">
    <?php 
      $nr = intval($id);
      $sql = "SELECT id, title, conference, year, citations, link, rank FROM publications JOIN author_publications ON publications.id = author_publications.publication_id  WHERE author_id = '$nr'";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table align="center" border="1px"">
        <tr>
            <th colspan="6"><h2 style="text-align: center;">Publications</h2></th>
        </tr>

        <t>
            <th>Title</th>
            <th>Conference</th>
            <th>Year</th>
            <th>Citations</th>
            <th>Rank</th>
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
                <td><?php echo $rows['rank']; ?></td>
                <td><?php echo "<a href='pub-det.php?id=$id'>More information</a><br>";
                  echo "<a href='editPublications.php?id=$id'>Edit</a>";
                ?></td>
            </tr>
            <?php
        } 
        ?>
    </table>
      
</div>

<div class="operations">
<div class="buttons">
        <h3>Export options</h3>
        <form action="mypage.php" method="post" >
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
            <!-- <input type="submit" class="btn-submit" name="ePDF" value="Export PDF"> -->
        </form>
    </div>
  </div>
</body>
</html>