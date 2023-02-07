$("#search-form").submit(function(event) {
    event.preventDefault();
    var searchQuery = $("#search-query").val();
    $.ajax({
      url: "/search.php",
      type: "POST",
      data: {
        search_query: searchQuery
      },
      success: function(results) {
        // Code to display the search results on the page
      }
    });
  });

// function search() {
//     var searchInput = document.getElementById("search-input").value;
//     var xhr = new XMLHttpRequest();
//     xhr.open("GET", "search.php?query=" + searchInput, true);
//     xhr.send();
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var results = JSON.parse(xhr.responseText);
//             // Display the search results
//         }
//     }
// }