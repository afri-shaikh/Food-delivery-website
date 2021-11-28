<?php 
    include('../config/constants.php');
    //delete session to logout
    session_destroy(); //unsets $_SESSION['user']

    //redirect to login pag
    header("Location:".HOME.'admin/login.php');


?>