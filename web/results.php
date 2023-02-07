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
    <a href="login.php">Log in</a>
</div>
<div class="container">
      <img src="logo.png" alt="My Logo">
      <div class="search-container">
      <form id="search-form" action="results.php" method="POST">
        <input type="text" name="search-querry" class="search-input" placeholder="Search authors or publications">
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

</body>
</html>
<?php
    include('server.php');
    if($_POST["search-querry"] == ""){
        echo "<h2>No results found </h2>";
    }else{
        $search = trim($_POST["search-querry"]);
        $querry = $mysqli->prepare("SELECT * FROM authors");
        // $querry->bind_param("s", $search);
        $result = mysqli_query($mysqli,$querry);
        ?>
        <table align="center" border="1px" style="width:700px; line-height:60px;">
        <tr>
            <th colspan="5"><h2 style="text-align: center;">Stoc Existent</h2></th>
        </tr>

        <t>
            <th>ID</th>
            <th>Name</th>
            <
        </t>
        <?php
        while($rows=mysqli_fetch_assoc($result))
        {
        ?>
            <tr>
                <td><?php echo $rows['id']; ?></td>
                <td><?php echo $rows['name']; ?></td>

            </tr>
            <?php
        }
        ?>
    </table>
    <?php } ?>
