<?php
    //Authorization - Access control

    if(!isset($_SESSION['user']))
    {
        //if user session is not set it means user is not logged in
        $_SESSION['no-login-msg'] = "<div class='error text-center'>Please login to access admin panel</div>";
        
        //redirect to login page
        header("Location:".HOME.'admin/login.php');
    }


?>