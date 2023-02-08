<?php

if(isset($_POST['eCSV'])){
    $filename = "publications_". date('m-d') . ".csv";
    $delimitator = ",";

    $mail = $_SESSION['username'];
    $sql = "SELECT id FROM authors WHERE mail='$mail'";
    $result = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];}

    $file = fopen("php://memory","w");
    $fields = array('ID','Title','Year','Conference','Summary','Citations');
    fputcsv($file, $fields, $delimitator);

    $sql = "SELECT id, title, conference, year, citations, link FROM publications JOIN author_publications ON publications.id = author_publications.publication_id  WHERE author_id = '$id'";
    $result=mysqli_query($mysqli,$sql);
    while($rows=mysqli_fetch_assoc($result))
        {
            $line = array($rows['id'],$rows['title'],$rows['conference'],$rows['year'],$rows['citations']);
            fputcsv($file, $line, $delimitator);
         }
    
    fseek($file, 0);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');

    fpassthru($file);
    exit();
}

if(isset($_POST['eJSON'])){
    $mail = $_SESSION['username'];
    $sql = "SELECT id FROM authors WHERE mail='$mail'";
    $result = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id = $row["id"];}

    $sql = "SELECT id, title, conference, year, citations, link FROM publications JOIN author_publications ON publications.id = author_publications.publication_id  WHERE author_id = '$id'";
    $result=mysqli_query($mysqli,$sql);

    $json_array = array ();

    while($rows=mysqli_fetch_assoc($result))
        {
            $json_array[]= $rows;
         }
    $json = json_encode($json_array);
    $fp = fopen('php://output','w');
    fwrite($fp, json_encode($json_array));
    fclose($fp);
    header('Content-Type: text/json');
    header('Content-Disposition: attachment; filename="stoc.json";');

    exit();
}

// if(isset($_POST['ePDF'])){
//     include_once('fpdf181/fpdf.php');

//     $display_heading = array('id'=>'ID', 'nume_vehicul'=> 'Vehicul', 'marca'=> 'Marca','piesa'=> 'Piesa', 'cantitate'=>'Cantitate',);
 
//     $result = mysqli_query($mysqli, "SELECT id, nume_vehicul, marca, piesa, cantitate FROM stoc") ;
//     $header = mysqli_query($mysqli, "SHOW columns FROM stoc");
    
//     $pdf = new FPDF();

//     $pdf->AddPage();
  
//     $pdf->AliasNbPages();
//     $pdf->SetFont('Arial','B',12);
//     foreach($header as $heading) {
//     $pdf->Cell(40,12,$display_heading[$heading['Field']],1);
//     }
//     foreach($result as $row) {
//     $pdf->Ln();
//     foreach($row as $column)
//     $pdf->Cell(40,12,$column,1);
//     }
//     $pdf->Output();

//     }

?>