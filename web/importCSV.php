<?php
include('server.php');

if(isset($_POST['iCSV'])){

    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
        
            $csvFile = fopen ($_FILES['file']['tmp_name'],'r');
            $selectedTab = $_POST['table-select'];
           
            while(($line = fgetcsv($csvFile))!== FALSE){
              
                if(strtolower($selectedTab) == "journals")
                    {
                    $title = mysqli_real_escape_string($mysqli, $line[0]);
                    $issn = mysqli_real_escape_string($mysqli, $line[1]);
                    $eissn = mysqli_real_escape_string($mysqli, $line[2]);
                    $subdomeniu = mysqli_real_escape_string($mysqli, $line[3]);
                    $rank = mysqli_real_escape_string($mysqli, $line[4]);
                    $loc = mysqli_real_escape_string($mysqli, $line[5]);

                    $sql = "INSERT into journals (title, ISSN, eISSN, subdomeniu, rank, Loc_in_zona) 
                    VALUES ('$title','$issn','$eissn','$subdomeniu','$rank','$loc')";
                    //  values ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."')";
                    mysqli_query($mysqli, $sql);
                } elseif (strtolower($selectedTab) == "conferences"){
                    $title = mysqli_real_escape_string($mysqli, $line[0]);
                    $acronym = mysqli_real_escape_string($mysqli, $line[1]);
                    $coreyear = mysqli_real_escape_string($mysqli, $line[2]);
                    $rank = mysqli_real_escape_string($mysqli, $line[3]);
                    $hasData = mysqli_real_escape_string($mysqli, $line[4]);
                    $primary = mysqli_real_escape_string($mysqli, $line[5]);

                    $sql = "INSERT into conferences (title, acronym, coreyear, rank, hasData, primary_for) 
                    VALUES ('$title','$acronym','$coreyear','$rank','$hasData','$primary')";
                    // values ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."')";
                    mysqli_query($mysqli, $sql); 
                }

                $msj = "Table " . $selectedTab . " updated ";
                setcookie('message-import', $msj, time() + 3600);

                sleep(3);
                header("Location: adminPage.php");
                // header("Location: http://localhost/web/adminPage.php");

            }
            fclose($csvFile);

        }
    }
 
}


?>