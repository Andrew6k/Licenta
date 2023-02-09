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
    <link rel="icon" type="image/x-icon" href="data:,">
    <link rel="stylesheet" href="style.css">
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
    <div></div>
    <div id="my_dataviz"></div>
    <style>
        .my_dataviz{
            padding-left:15%;
        }
    </style>
    <!-- <svg></svg> -->
    <h4>Clustering graph based on citations</h4>
    </body>
<?php


// use Phpml\Clustering\KMeans;
// use Phpml\Math\Distance\Euclidean;

$query = "SELECT name, citations FROM authors";
$result=mysqli_query($mysqli,$query);
$rows=mysqli_fetch_assoc($result);

// $data = array();
// while ($row = mysqli_fetch_assoc($result)) {
//     $data[] = array("name" => $row['name'], "citations" => $row['citations']);
// }


$file = file("../demo.txt");
$kmeans_result = array_map('intval', explode(",", $file[0]));
foreach ($kmeans_result as $k){
    // echo $k;
}

// echo "Clustering graph based on citations"
?>

<!-- <svg> </svg>
<script>
    var svg = d3.select("svg"),
    width = +svg.attr("width"),
    height = +svg.attr("height");

</script> -->
<script src="https://d3js.org/d3.v5.min.js"></script>
<script src="app.js" ></script>
</html>