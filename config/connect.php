<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "thaileague";

    $conn = mysqli_connect($host, $user, $password, $dbName);

    if(!$conn){
        echo "Error While Connecting...";
    }
?>