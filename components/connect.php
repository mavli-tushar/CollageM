<?php

    $server = "localhost";
    $username = "root";
    $user_pass = "tushar@123";
    $db_name = "stud_management_db";

    $conn = mysqli_connect($server, $username, $user_pass, $db_name);

    if($conn){
        // echo "Connection Successfully 😊";
    }else{
        echo "Connection failed 😟";
    }

?>