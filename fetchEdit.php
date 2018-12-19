<?php
    require("connect.php");
    if (mysqli_connect_errno()){
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $id = mysqli_real_escape_string($conn, $_POST['indivID']);


    $sql = "SELECT * FROM score s 
            JOIN individual i
            ON s.individual_id = i.individual_id
            WHERE s.individual_id = '$id'";
    $ret = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($ret);

    echo ""

    
?>