<?php
    include('server.php');

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
    <?php if($_SESSION['username']) {
      $name = $_SESSION['username'];
      echo "<a href='logout.php'>Logout</a>";
      echo "<a href='mypage.php'>$name</a>";
    }else {
      echo "<a href='login.php'>Log in</a><br>";
    }
    ?>
    <a href="homepage.php">Home</a>
</div>
<div class="container-res">
      <img src="logo.png" alt="My Logo">
      <div class="search-container">
      <form id="search-form" action="results.php" method="POST">
        <input type="text" name="search-querry" class="search-input" placeholder="Search authors or publications">
        <select name="criteria-select">
            <option value="author">Author</option>
            <option value="title">Title</option>
            <option value="domain">Domain</option>
            <option value="year">Year</option>
        </select>
        <input type="submit" value="Search">
      </form>
      </div>
      <!-- <div class="results-container">
        <div class="result-item">
          <div class="title">Article Title</div>
          <div class="author">Author Name</div>
          <div class="abstract">Abstract of the article goes here...</div>
        </div> -->
        <!-- Add more result items as needed -->
      </div>
    </div>

<?php
    if($_POST["search-querry"] == ""){
        echo "<h2>No results found </h2>";
    }else{
      $word = $_POST["search-querry"];
      $category = $_POST["criteria-select"];
      // echo $category;
      if ($category == "author"){
        $sql = "SELECT * FROM authors WHERE name like '%$word%'";
        $result=mysqli_query($mysqli,$sql);
          ?>
          <table align="center" border="1px"">
          <tr>
              <th colspan="5"><h2 style="text-align: center;">Results</h2></th>
          </tr>

          <t>
              <th>Name</th>
              <th>Affiliation</th>
              <th>Email_domain</th>
              <th>Citations</th>
              <th>Link</th>
          </t>
          <?php
          while($rows=mysqli_fetch_assoc($result))
          {
            $id = $rows['id'];
            $name = $rows['name'];
          ?>
              <tr>
                  <td><?php echo $rows['name']; ?></td>
                  <td><?php echo $rows['affiliation']; ?></td>
                  <td><?php echo $rows['email_domain']; ?></td>
                  <td><?php echo $rows['citations']; ?></td>
                  <td><?php echo "<a href='details.php?id=$id'>$name</a><br>";?></td>
              </tr>
              <?php
          }
          ?>
      </table>
      
  </body>
  </html>
    <?php }elseif ($category == "title") {
      $sql = "SELECT * FROM publications WHERE title like '%$word%'";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table align="center" border="1px"">
        <tr>
            <th colspan="5"><h2 style="text-align: center;">Results</h2></th>
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
    
</body>
</html>

    <?php }elseif ($category == "year"){
      $year = intval($word);
      $sql = "SELECT * FROM publications WHERE year = '$year'";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table align="center" border="1px"">
        <tr>
            <th colspan="5"><h2 style="text-align: center;">Results</h2></th>
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
    
</body>
</html>

    <?php }else {
      $sql = "SELECT DISTINCT authors.id,name,affiliation,email_domain,citations,domain FROM authors JOIN author_domains ON authors.id = author_domains.author_id JOIN domains ON domains.id = author_domains.domain_id WHERE domains.domain like '%$word%'";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table align="center" border="1px"">
        <tr>
            <th ><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <t>
            <th>Name</th>
            <th>Affiliation</th>
            <th>Email_domain</th>
            <th>Citations</th>
            <th>Domain</th>
            <th>Link</th>
        </t>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
          $id = $rows['id'];
          $name = $rows['name'];
        ?>
            <tr>
                <td><?php echo $rows['name']; ?></td>
                <td><?php echo $rows['affiliation']; ?></td>
                <td><?php echo $rows['email_domain']; ?></td>
                <td><?php echo $rows['citations']; ?></td>
                <td><?php echo $rows['domain']; ?></td>
                <td><?php echo "<a href='details.php?id=$id'>$name</a><br>";?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    
</body>
</html>



    <?php }
  
  
  } ?>






          <!-- // $search = trim($_POST["search-querry"]);
          // $querry = $mysqli->prepare("SELECT * FROM authors");
          // // $querry->bind_param("s", $search);
          // $result = mysqli_query($mysqli,$querry); -->