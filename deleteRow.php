<?php
        require("connect.php");
        
        $delID = $_GET['grade_id'];
    //$delID = $_POST['removeRow'];
        echo $delID;
        //get assessment id
        $fetchAID = "SELECT assessment_id FROM assessment WHERE gradeSys_id = '$delID'";
        $assessQ = mysqli_query($conn, $fetchAID);
        $aID = mysqli_fetch_assoc($assessQ);

        //get individual id
        $fetchIndivID= "SELECT individual_id FROM individual WHERE assessment_id = '{$aID['assessment_id']}'";
        $indivQ = mysqli_query($conn, $fetchIndivID);
        $indivID = mysqli_fetch_assoc($indivQ);

        //delete from score
        $deleteScore = "DELETE FROM score WHERE individual_id = '{$indivID['individual_id']}'";
        mysqli_query($conn, $deleteScore);

        //delete from individual
        $deleteIndividual = "DELETE FROM individual WHERE assessment_id = '{$aID['assessment_id']}'";
        mysqli_query($conn, $delA);
        
        //delete from assessment
        $delA = "DELETE FROM assessment WHERE gradeSys_id = '$delID'";
        mysqli_query($conn, $delA);
        
        //delete from gradesystem
        $delGS = "DELETE FROM gradeSystem WHERE gradeSys_id = '$delID'";
        mysqli_query($conn, $delGS);
?>