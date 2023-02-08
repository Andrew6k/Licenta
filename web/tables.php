<?php
  include('server.php');
  
  include('import_export.php');


  $obj = $_GET["obj"];

  
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

<?php
      // echo $category;
      if ($obj == "authors"){
        $sql = "SELECT * FROM authors ";
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
    <?php }elseif ($obj == "publ") {
      $sql = "SELECT * FROM publications";
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
      $sql = "SELECT id,domain FROM domains";
      $result=mysqli_query($mysqli,$sql);
        ?>
        <table align="center" border="1px"">
        <tr>
            <th ><h2 style="text-align: center;">Results</h2></th>
        </tr>

        <t>
            <th>ID</th>
            <th>Name</th>
        </t>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
          $id = $rows['id'];
          $domain = $rows['domain'];
        ?>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['domain']; ?></td>
            <?php
        } } 
        ?>
    </table>
    <div class="buttons">
        <h3>Export options</h3>
        <form action="mypage.php" method="post" >
        
        <select name="export-select">
            <option value="Authors">Authors</option>
            <option value="Publications">Publications</option>
            <option value="Domains">Domains</option>
        </select>
            <input type="submit" class="btn-submit" name="eCSV" value="Export CSV">
            <input type="submit" class="btn-submit" name="eJSON" value="Export JSON">
        </form>
    </div>
</body>
</html>
