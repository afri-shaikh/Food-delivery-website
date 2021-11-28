<?php
//start session
ob_start();
    session_start();

//Create constants to store non repeating values
    define('HOME','http://localhost/Food-delivery-website/'); 
    define('LOCALHOST', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'food-delivery');


    $conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(  mysqli_error());
    $db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error());
    ob_end_flush();

?>