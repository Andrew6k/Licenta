<?php ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Author-Publication Graph</title>
    <script src="https://d3js.org/d3.v5.min.js"></script>
    <link rel="icon" type="image/x-icon" href="data:,">
    <style>
      .link {
        stroke: #999;
        stroke-opacity: 0.6;
      }

      .node {
        stroke: #fff;
        stroke-width: 1.5px;
      }
    </style>
  </head>
  <body>
    <!-- The code to create the graph -->
    <script>
      // Read the data
      var data = [
        {"author_id": 1, "publication_id": 1},
        {"author_id": 1, "publication_id": 2},
        {"author_id": 2, "publication_id": 2},
        {"author_id": 2, "publication_id": 3},
        {"author_id": 3, "publication_id": 3},
        {"author_id": 3, "publication_id": 4}
      ];

      // Create nodes for each author and publication
      var nodes = {};
      data.forEach(function(link) {
        link.source = nodes[link.author_id] || (nodes[link.author_id] = {name: "Author " + link.author_id});
        link.target = nodes[link.publication_id] || (nodes[link.publication_id] = {name: "Publication " + link.publication_id});
      });

      var width = 500,
          height = 500;

      var force = d3.forceSimulation(d3.values(nodes))
          .force("link", d3.forceLink().links(data).id(function(d) { return d.name; }))
          .force("charge", d3.forceManyBody())
          .force("center", d3.forceCenter(width / 2, height / 2));

      var svg = d3.select("body").append("svg")
          .attr("width", width)
          .attr("height", height);

      var link = svg.selectAll(".link")
          .data(data)
          .enter().append("line")
          .attr("class", "link");

      var node = svg.selectAll(".node")
          .data(d3.values(nodes))
          .enter().append("circle")
          .attr("class", "node")
          .attr("r", 10);
          force.on("tick", function() {
  link.attr("x1", function(d) { return d.source.x; })
      .attr("y1", function(d) { return d.source.y; })
      .attr("x2", function(d) { return d.target.x2;})};
