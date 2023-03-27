<?php
    include('server.php');
// Get the ID of the author to delete from the form data
    $author_id = $_POST['author_id'];

    $author_query = "SELECT * FROM authors WHERE id = $author_id";
    $author_result = mysqli_query($mysqli, $author_query);
    $author = mysqli_fetch_assoc($author_result);

    $publications_query = "SELECT * FROM author_publications WHERE author_id = $author_id";
    $publications_result = mysqli_query($mysqli, $publications_query);
    $publications = mysqli_fetch_all($publications_result, MYSQLI_ASSOC);

    $citations_query = "SELECT * FROM author_citations WHERE author_id = $author_id";
    $citations_result = mysqli_query($mysqli, $citations_query);
    $citations = mysqli_fetch_all($citations_result, MYSQLI_ASSOC);

    $domains_query = "SELECT * FROM author_domains WHERE author_id = $author_id";
    $domains_result = mysqli_query($mysqli, $domains_query);
    $domains = mysqli_fetch_all($domains_result, MYSQLI_ASSOC);
    

    // Delete the author and related data from the database
    mysqli_query($mysqli, "DELETE FROM author_citations WHERE author_id = $author_id");
    mysqli_query($mysqli, "DELETE FROM author_publications WHERE author_id = $author_id");
    mysqli_query($mysqli, "DELETE FROM author_domains WHERE author_id = $author_id");
    mysqli_query($mysqli, "DELETE FROM authors WHERE id = $author_id");

    $msj = "Author " . $author['name'] . " and " . count($publications) . " publications and " . count($citations) . " citations have been deleted.";
    setcookie('message', $msj, time() + 3600);

    sleep(5);
    header('location: adminPage.php');
    
?>