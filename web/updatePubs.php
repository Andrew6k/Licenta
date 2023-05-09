<?php

include('server.php');

$mail = $_SESSION['username'];
$sql = "SELECT id, name, affiliation, email_domain, citations, isadmin FROM authors WHERE mail='$mail'";
$result = mysqli_query($mysqli, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $id = $row["id"];
    $name = $row["name"];
}

$command = "python ../scripts/updatePubs.py" . " " . $id ;

exec($command, $output, $return_var);
echo $output;
sleep(3);

header('location:mypage.php');
?>