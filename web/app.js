// console.log(d3)
// var mydata;
// fetch('../sample.json')
//     .then((response) => response.json())
//     .then(data => {
//         mydata = data;
//         console.log(mydata);
//     });

var mydata = [
    { name : 'Breaban', citations: 499, cluster: 2},
    { name : 'Raschip', citations: 201, cluster: 0},
    { name : 'Necula', citations: 126, cluster: 0},
    { name : 'Croitoru', citations: 168, cluster: 0},
    { name : 'Alboaie', citations: 352, cluster: 0},
    { name : 'Iftene', citations: 1272, cluster: 1},
    { name : 'Frasinaru', citations: 20, cluster: 0},
    { name : 'Buraga', citations: 761, cluster: 2},
    { name : 'Panu', citations: 67, cluster: 0},
    { name : 'Trandabat', citations: 579, cluster: 2},
    { name : 'Gifu', citations: 793, cluster: 2},
    { name : 'Moruz', citations: 271, cluster: 0},
    { name : 'Cristea', citations: 1788, cluster: 1},
    { name : 'Coca', citations: 62, cluster: 0}
];

var margin = {top: 20, right: 20, bottom: 30, left: 40},
    width = 960 - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

// set the ranges

var color = d3.scaleOrdinal(d3.schemeCategory10);

// append the svg object to the body of the page
var svg = d3.select("#my_dataviz")
  .append("svg")
    .attr("width", width + margin.left + margin.right)
    .attr("height", height + margin.top + margin.bottom)
  .append("g")
    .attr("transform",
          "translate(" + margin.left + "," + margin.top + ")");

var x = d3.scaleLinear().domain([d3.min(mydata, function(d){
            return d.citations;}) - 20,d3.max(mydata, function(d){return d.citations;})+100])
            .range([0,width]);
        
var y = d3.scaleBand()
            .range([height, 0])
            .padding(0.8);
y.domain(mydata.map(function(d) { return d.name; }));
        
var xAxis = d3.axisBottom(x);
var yAxis = d3.axisLeft(y);

svg.append("g").attr("transform", "translate(0,"+(height)+ ")").call(xAxis);
svg.append("g").attr("class","y axis").call(yAxis);

var dots = svg.append("g")
                .selectAll("dot").data(mydata);
dots.enter().append("circle").attr("cx", function(d) { return x(d.citations); })
       .attr("cy", function(d){return y(d.name);})
       .attr("r", 5)
       .attr("fill", function(d) { return color(d.cluster); });


// d3.select('div')
//   .selectAll('p')
//   .data(DUMMY)
//   .enter()
//   .append('p')
//   .text(dta => dta.region);

// const container = d3.select('svg')
//     .classed('container',true);

// container.selectAll('.bar')
//     .data(DUMMY)
//     .enter()
//     .append('rect')
//     .classed('bar',true)
//     .attr('width', 50)
//     .attr('height', data => (data.value * 15) );

// $width = 800;
// $height = 500;

// const svg = d3.select('svg');
// svg.append('circle')
//     .attr('r',20);
// var myVariable = <?php echo json_encode($kmeans_result); ?>;
// console.log(myVariable);






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