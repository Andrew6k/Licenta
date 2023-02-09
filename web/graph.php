
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website scholarly</title>
    <script src="https://d3js.org/d3.v5.min.js"></script>
</head>
<body>
    <!-- <svg></svg> -->
    <div id="chart"></div>
<?php

include('server.php');

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
    echo $k;
}
?>

<script>
$width = 800;
$height = 500;

const svg = d3.select('svg');
svg.append('circle')
    .attr('r',20);
var myVariable = <?php echo json_encode($kmeans_result); ?>;
console.log(myVariable);
// var svg = d3.select("#chart")
//             .append("svg")
//             .attr("width", width)
//             .attr("height", height);

// var circles = svg.selectAll("circle")
//                  .data(myVariable)
//                  .enter()
//                  .append("circle");

// circles.attr("cx", function(d, i) { return (i + 1) * 50; })
//        .attr("cy", height / 2)
//        .attr("r", function(d) { return d * 2; })
//        .attr("fill", "blue");
// $svg = d3.select('body')
//     .append('svg')
//     .attr('width', $width)
//     .attr('height', $height);

// $circles = $svg->selectAll('circle')
//     .data($formatted_data)
//     .enter()
//     .append('circle')
//     .attr('cx', function ($d, $i) use ($width) {
//         return ($i * $width) / count($formatted_data) + 50;
//     })
//     .attr('cy', $height / 2)
//     .attr('r', function ($d) {
//         return $d['citations'] / 10;
//     })
//     .style('fill', function ($d) {
//         return d3.schemeCategory10[$d['cluster_id']];
//     });

//     $circles
//     .on('mouseover', function ($d) {
//         d3.select(this)
//             .style('fill', 'red');
//     })
</script>

<!-- <svg> </svg>
<script>
    var svg = d3.select("svg"),
    width = +svg.attr("width"),
    height = +svg.attr("height");

</script> -->
</body>
</html>