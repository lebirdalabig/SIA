<?php
    $conn = mysqli_connect("localhost", "root", "", "classrecord2");
    
    mysqli_set_charset($conn,"utf8"); //FOR SPECIAL CHARACTERS ADDED AT OCT 9 8:11 PM 
    
    if(!$conn){
        echo "Error connecting to database.";
        exit();
    }
?>
