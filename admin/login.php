<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>
    <body>
    
        <div class="login">
            <h1 class="text-center">Login</h1>

            <?php
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-msg']))
                {
                    echo $_SESSION['no-login-msg'];
                    unset($_SESSION['no-login-msg']);
                }

            ?> </br>

            <form action="" method="post" class="text-center"></br>
                Username:</br>
                <input type="text" name="username" placeholder="Enter Username"></br></br>
                Password:</br>
                <input type="password" name="password" placeholder="Enter Password"></br></br>
                <input type="submit" name="submit" value="login" class="btn-primary"></br></br>
            </form>

            <p class="text-center">Created by - Afrin Shaikh</p>
        </div>

    </body>
</html>

<?php 
    //check whether submit is clicked
    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //query to check whether user exists with username & passwd
        $sql = "SELECT * FROM admin WHERE username='$username' AND passwd='$password' ";
        $res = mysqli_query($conn, $sql);

        //count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            //login success
            //echo "User exists";
            $_SESSION['login'] = "<div class='success text-center' >Login successfull</div>";
            $_SESSION['user'] = $username; //to check whether is logged in or not for access control
            header("Location:".HOME.'admin/');
        }
        else
        {
            //user does not exist, login failed
            $_SESSION['login'] = "<div class='error text-center'>Username or Password incorrect</div>";
            header("Location:".HOME.'admin/login.php');
        }
    }

?>