<?php
    include('server.php');

    $publication_id = $_POST["publication_id"];
    $publication_title = $_POST["publication_title"];
    $publication_year = $_POST['year'];
    $publication_conference = $_POST['publication_conference'];
    $citation_count = $_POST['citation_count'];
    $rank = $_POST['rank_pub'];

    $publication_id = $mysqli->real_escape_string($publication_id);
    $publication_title = $mysqli->real_escape_string($publication_title);
    $publication_year = $mysqli->real_escape_string($publication_year);
    $publication_conference = $mysqli->real_escape_string($publication_conference);
    $citation_count = $mysqli->real_escape_string($citation_count);
    $rank = $mysqli->real_escape_string($rank);

    // echo $publication_conference, $publication_title, $publication_year, $citation_count;

    $query = "UPDATE publications SET title='$publication_title', year='$publication_year', conference='$publication_conference', citations='$citation_count', rank='$rank' WHERE id='$publication_id'";
    $result = $mysqli->query($query);   

    if ($result) {
         $_SESSION['messageUp'] = "<p>Publication information updated successfully!</p>";
      } else {
         $_SESSION['messageUp'] = "<p>Error updating publication information: " . $mysqli>error . "</p>";
      }

    header("Location: editPublications.php"."?id=".$publication_id);
    exit();
    ?>