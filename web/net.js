
var authors_publications = [        { author_id: 1, publication_id: 1 },        { author_id: 2, publication_id: 1 },        { author_id: 3, publication_id: 2 },        { author_id: 4, publication_id: 2 },        { author_id: 5, publication_id: 3 }      ];

    
      var links = [];
      for (var i = 0; i < authors_publications.length; i++) {
        for (var j = i + 1; j < authors_publications.length; j++) {
          if (
            authors_publications[i].publication_id ===
            authors_publications[j].publication_id
          ) {
            links.push({
              source: authors_publications[i].author_id,
              target: authors_publications[j].author_id
            });
          }
        }
      }

    //   // Create the nodes for each author
    //   var nodes = [];
    //   authors_publications.forEach(function(d) {
    //     nodes[d.author_id] = { id: d.author_id };
    //   });

    //   // Set up the simulation
    //   var simulation = d3
    //     .forceSimulation(nodes)
    //     .force("charge", d3.forceManyBody().strength(-300))
    //     .force("link", d3.forceLink(links).distance(150))
    //     .force("center", d3.forceCenter().x(250).y(250))
    //     .on("tick", ticked);

    //   // Create the svg to hold the nodes and links
    //   var svg = d3
    //     .select("body")
    //     .append("svg")
    //     .attr("width", 500)
    //     .attr("height", 500);

    //   // Add the links to the svg
    //   var link = svg
    //     .selectAll(".link")
    //     .data(links)
    //     .enter()
    //     .append("line")
    //     .attr("class", "link");

    //   // Add the nodes to the svg
    //   var node = svg
    //     .selectAll(".node")
    //     .data(nodes)
    //     .enter()
    //     .append("circle")
    //     .attr("class", "node")
    //     .attr("r", 15);












// var diameter = 500,
//     radius = diameter / 2,
//     innerRadius = radius - 120;

// var cluster = d3.cluster()
//     .size([360, innerRadius]);

// var line = d3.radialLine()
//     .curve(d3.curveBundle.beta(0.85))
//     .radius(function(d) { return d.y; })
//     .angle(function(d) { return d.x / 180 * Math.PI; });

// var svg = d3.select("body").append("svg")
//     .attr("width", diameter)
//     .attr("height", diameter)
//   .append("g")
//     .attr("transform", "translate(" + radius + "," + radius + ")");

// var root = JSON.parse({
//     name: "A",
//     children: [
//       {
//         name: "B",
//         children: []
//       },
//       {
//         name: "C",
//         children: []
//       }
//     ]
//   }
//   );
// var nodes = cluster.nodes(root);
// var links = cluster.links(nodes);

// var link = svg.selectAll(".link")
//   .data(links)
//   .enter().append("path")
//     .attr("class", "link")
//     .attr("d", line);

// var node = svg.selectAll(".node")
//   .data(nodes.descendants())
//   .enter().append("g")
//     .attr("class", function(d) { return "node" + (d.children ? " node--internal" : " node--leaf"); })
//     .attr("transform", function(d) { return "rotate(" + (d.x - 90) + ")translate(" + d.y + ")"; });

// node.append("circle")
//     .attr("r", 2.5);

// node.append("text")
//     .attr("dy", ".31em")
//     .attr("text-anchor", function(d) { return d.x < 180 ? "start" : "end"; })
//     .attr("transform", function(d) { return d.x < 180 ? "translate(8)" : "rotate(180)translate(-8)"; })
//     .text(function(d) { return d.data.name; });



// // var nodes = [];
// // var links = [];

// // // Create nodes for each author
// // for (var i = 0; i < data.length; i++) {
// //   var author_id = data[i]['author_id'];
// //   var publication_id = data[i]['publication_id'];

// //   var author_node = nodes.find(function(node) { return node.id == author_id; });
// //   if (!author_node) {
// //     author_node = {id: author_id, name: "Author " + author_id};
// //     nodes.push(author_node);
// //   }

// //   var publication_node = nodes.find(function(node) { return node.id == publication_id; });
// //   if (!publication_node) {
// //     publication_node = {id: publication_id, name: "Publication " + publication_id};
// //     nodes.push(publication_node);
// //   }

// //   links.push({source: author_node, target: publication_node});
// // }


















// // // var nodes = [{id: 1, name: "Author 1"}, 
// // //              {id: 2, name: "Author 2"}, 
// // //              {id: 3, name: "Author 3"}];

// // // var width = 800;
// // // var height = 500;

// // // const svg = d3.select('svg');
// // // var links = [{source: 1, target: 2}, 
// // //              {source: 2, target: 3}];

// // // var simulation = d3.forceSimulation(nodes)
// // //     .force("link", d3.forceLink(links).id(function(d) { return d.id; }))
// // //     .force("charge", d3.forceManyBody().strength(-50))
// // //     .force("center", d3.forceCenter(width / 2, height / 2));

// // // var color = d3.scaleOrdinal()
// // //     .range(["red", "blue", "green"]);
// // // var node = svg.selectAll(".node")
// // //     .data(nodes)
// // //     .enter().append("circle")
// // //     .attr("class", "node")
// // //     .attr("r", 10)
// // //     .style("fill", function(d) { return color(d.group); });


// // // var link = svg.selectAll(".link")
// // //     .data(links)
// // //     .enter().append("line")
// // //     .attr("class", "link")
// // //     .style("stroke-width", 2);

// // // simulation.on("tick", function() {
// // //   link.attr("x1", function(d) { return d.source.x; })
// // //       .attr("y1", function(d) { return d.source.y; })
// // //       .attr("x2", function(d) { return d.target.x; })
// // //       .attr("y2", function(d) { return d.target.y; });
// // //   node.attr("cx", function(d) { return d.x; })
// // //       .attr("cy", function(d) { return d.y; });
// // // });
