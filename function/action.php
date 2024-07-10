<?php
    include "../config/connect.php";
    include "../function/myFunction.php";

    if(isset($_POST["submit"])){
        handleCreation($conn, $_POST, $_FILES);
    }
?>