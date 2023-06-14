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
<?php if(isset($_SESSION['username']) and isset($_SESSION['isadmin']) and ($_SESSION['isadmin'] == 0)) {
      $name = $_SESSION['username'];
      echo "<a href='logout.php'>Logout</a>";
      
      echo "<a href='mypage.php'>$name</a>";
      $mail = $_SESSION['username'];
      $sql = "SELECT id FROM authors WHERE mail='$mail'";
      $result = mysqli_query($mysqli, $sql);

      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $author_id = $row["id"];
      }
      
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
        echo "<h1>$title</h1>";
    ?>
    </div>
</div>
<?php
if(isset($_SESSION['username'])){
  $sql = "SELECT * FROM citations c JOIN author_citations a ON c.id = a.citation_id WHERE publication_id = '$id' AND type = 'Direct' AND author_id = '$author_id'";
  $result = mysqli_query($mysqli, $sql);
  $direct_citations = array();
  while ($rows = mysqli_fetch_assoc($result)) {
      $direct_citations[$rows['title']] = $rows['link'];
  }
  $sql = "SELECT * FROM citations c JOIN author_citations a ON c.id = a.citation_id WHERE publication_id = '$id' AND type = 'Indirect' AND author_id = '$author_id'";
  $result = mysqli_query($mysqli, $sql);
  $indirect_citations = array();
  while ($rows = mysqli_fetch_assoc($result)) {
      $indirect_citations[$rows['title']] = $rows['link'];
  }

  $sql = "SELECT * FROM citations WHERE publication_id = '$id'";
  $result = mysqli_query($mysqli, $sql);
  $other_citations = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    if (array_key_exists($rows['title'], $direct_citations) or array_key_exists($rows['title'], $indirect_citations))
        continue;
    else
      $other_citations[$rows['title']] = $rows['link'];
  }}
else{
  $sql = "SELECT * FROM citations c JOIN author_citations a ON c.id = a.citation_id WHERE publication_id = '$id' AND type = 'Direct'";
  $result = mysqli_query($mysqli, $sql);
  $direct_citations = array();
  while ($rows = mysqli_fetch_assoc($result)) {
      $direct_citations[$rows['title']] = $rows['link'];
  }

  $indirect_citations = array();

  $sql = "SELECT * FROM citations WHERE publication_id = '$id'";
  $result = mysqli_query($mysqli, $sql);
  $other_citations = array();
  while ($rows = mysqli_fetch_assoc($result)) {
    if (array_key_exists($rows['title'], $direct_citations) or array_key_exists($rows['title'], $indirect_citations))
        continue;
    else
      $other_citations[$rows['title']] = $rows['link'];
  }
}
?>

<div class="articles">
    <table align="center" border="1px">
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
            <td><?php echo "<a href='$link'>Original link</a><br>"; ?></td>
        </tr>
        <tr>
            <td>Citations</td>
            <td class="citations">
              <?php if (!empty($direct_citations)){ ?>
                <p><strong>Direct citations</strong></p>
                <ul>
                <?php
                foreach ($direct_citations as $citation => $link) {
                    echo "<li>$citation &nbsp&nbsp";
                    echo "<a href='$link'>Link</a></li>";
                } 
                ?>
                </ul> 
              <?php }if(!empty($indirect_citations)){ ?>
                <p><strong>Indirect citations</strong></p>
                <ul>
                <?php
                foreach ($indirect_citations as $citation => $link) {
                    echo "<li>$citation &nbsp&nbsp";
                    echo "<a href='$link'>Link</a></li>";
                }
                ?>
                </ul>
                <?php }if(!empty($other_citations)){ ?>
                <p><strong>Other citations</strong></p>
                <ul>
                <?php
                foreach ($other_citations as $citation => $link) {
                    echo "<li>$citation &nbsp&nbsp";
                    echo "<a href='$link'>Link</a></li>";
                }
                ?>
                </ul>
                <?php } ?>
            </td>
        </tr>
    </table>
</div>

              
    </table>
</div>
</body>
</html>