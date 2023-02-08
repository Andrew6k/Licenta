<?php

include('server.php');

$command = "python ../scripts/updateDB.py";
exec($command, $output, $return_var);
echo $output;
sleep(3);

header('location:tables.php?obj=authors');
?>