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
      $rank = $row['rank'];
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
  <label for="rank_publication">Publication Rank:</label>
  <select name="rank_pub" id="rank_pub">
    <option value="A*" <?php if ($rank == "A*") {echo "selected";} ?>>A*</option>
    <option value="A" <?php if ($rank == "A") {echo "selected";} ?>>A</option>
    <option value="B" <?php if ($rank == "B") {echo "selected";} ?>>B</option>
    <option value="C" <?php if ($rank == "C") {echo "selected";} ?>>C</option>
    <option value="D" <?php if ($rank == "D") {echo "selected";} ?>>D</option>
  </select>
  <input  type="submit" value="Save" class="mySave">
  
</form>
<div class="msj">
  <?php if (isset($_SESSION['messageUp'])) {
    echo $_SESSION['messageUp'];
    unset($_SESSION['messageUp']);
          }?>
 </div>
</div>
<div class="similar">
  <?php
  $startPosition = strpos(strtolower($conference), "conference on");
  $startPosition2 = strpos(strtolower($conference), "congress on");
  $ok = 0;
    // Extract the substring after "conference on"
  if ($startPosition !== false or $startPosition2 !== false) {
      $ok = 1;
      if($startPosition)
        $substring = substr($conference, $startPosition + strlen("conference on"));
      elseif($startPosition2)
        $substring = substr($conference, $startPosition2 + strlen("congress on"));
      $substring = trim($substring); // Remove leading/trailing whitespace if needed

  // Output the extracted substring
      // echo $substring;
      $publicationWords = explode(" ", $substring);
      $matchingConferences = array();

      $sql = "SELECT title, rank FROM conferences WHERE ";
      foreach ($publicationWords as $index => $word) {
        if($word == "and")
            continue;
        // Search for conferences/journals with names containing the word
        $sql .= "title LIKE '% " . $word . " %'";
        if ($index < count($publicationWords) - 1) {
          $sql .= " OR ";
        }

      }
      
      $sql .= " ORDER BY (";

      foreach ($publicationWords as $index => $word) {
          $sql .= "CASE WHEN title LIKE '%$word%' THEN 1 ELSE 0 END";
          if ($index < count($publicationWords) - 1) {
            $sql .= " + ";
        }
      }

      $sql .= ") DESC";

      $result=mysqli_query($mysqli,$sql);
        // Fetch the matching conferences/journals
      while($rows=mysqli_fetch_assoc($result)){
        // $matchingConferences[] = $rows["title"] . " " . $rows["rank"];
        $matchingConferences[$rows["title"]] = $rows["rank"];
      }
      //if it returns 0 rows => check journals
        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         $matchingConferences[] = $row["title"] + " " + $row["rank"];
        //     }
        // }
      

      // $unique = array_unique($matchingConferences);
      // $html = "<ul>";
      // foreach ($matchingConferences as $conference) {
      //     $html .= "<li>" . $conference . "</li>";
      // }
      // $html .= "</ul>";

      // echo $html;
    }
  else{
    $conference = preg_replace("/\([^()]*\)/", "", $conference); 
    $conference = trim($conference);
    $publicationWords = explode(" ", $conference);
    $matchingJournals = array();

    $sql = "SELECT title, rank FROM journals WHERE title like '%$conference%' UNION SELECT title, rank FROM journals_if where title like '%conference%'" ;

    $result=mysqli_query($mysqli,$sql);
    
      // Fetch the matching conferences/journals
    while($rows=mysqli_fetch_assoc($result)){
      $ok = 2;
      $matchingConferences[$rows["title"]] = $rows["rank"];
    }
  }
  ?>
  <div class="scroll-container">
    <?php
      if($ok == 1 or $ok == 2){ ?>
        <table>
        <?php
          foreach($matchingConferences as $key => $val)
          {  
            ?>
            <tr>
                <td><?php echo $key." - "; ?></td>
                <td><?php echo $val; ?></td>
            </tr>
            <?php } ?>
    </table>
    <?php } ?>
  </div>
</div>
  </body>
</html>
