<?php
include('server.php');

if(isset($_POST['iCSV'])){

    if(!empty($_FILES['file']['name'])){
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
        
            $csvFile = fopen ($_FILES['file']['tmp_name'],'r');
            $selectedTab = $_POST['table-select'];
           
            while(($line = fgetcsv($csvFile))!== FALSE){
              
                if(strtolower($selectedTab) == "journals-ais")
                    {
                    $title = mysqli_real_escape_string($mysqli, $line[0]);
                    $issn = mysqli_real_escape_string($mysqli, $line[1]);
                    $eissn = mysqli_real_escape_string($mysqli, $line[2]);
                    $subdomeniu = mysqli_real_escape_string($mysqli, $line[3]);
                    $rank = mysqli_real_escape_string($mysqli, $line[4]);
                    $loc = mysqli_real_escape_string($mysqli, $line[5]);
                    $year = mysqli_real_escape_string($mysqli, $line[6]);

                    $sql = "INSERT into journals (title, ISSN, eISSN, subdomeniu, rank, Loc_in_zona, year) 
                    VALUES ('$title','$issn','$eissn','$subdomeniu','$rank','$loc','$year')";
                    //  values ('".$line[0]."','".$line[1]."','".$line[2]."','".$line[3]."')";
                    mysqli_query($mysqli, $sql);
                } elseif(strtolower($selectedTab) == "journals-if"){

                    $title = mysqli_real_escape_string($mysqli, $line[2]);
                    $issn = mysqli_real_escape_string($mysqli, $line[3]);
                    $eissn = mysqli_real_escape_string($mysqli, $line[4]);
                    $subdomeniu = mysqli_real_escape_string($mysqli, $line[0]);
                    $rank = mysqli_real_escape_string($mysqli, $line[5]);
                    $loc = mysqli_real_escape_string($mysqli, $line[6]);
                    $year = mysqli_real_escape_string($mysqli, $line[7]);

                    $sql = "INSERT into journals_if (title, ISSN, eISSN, subdomeniu, rank, Loc_in_zona, year) 
                    VALUES ('$title','$issn','$eissn','$subdomeniu','$rank','$loc','$year')";
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

                if($selectedTab != "choose"){
                    $msj = "Table " . $selectedTab . " updated ";
                    setcookie('message-import', $msj, time() + 3600);
                    sleep(2);
                    header("Location: adminPage.php");
                }else{
                    $msj = "Select a table!";
                    setcookie('message-import', $msj, time() + 3600);
                    header("Location: adminPage.php");
                }
                // header("Location: http://localhost/web/adminPage.php");

            }
            fclose($csvFile);

        }
    }else{
        $msj = "Select an import file!";
        setcookie('message-import', $msj, time() + 3600);
        
        header("Location: adminPage.php");
    }
 
}


?>