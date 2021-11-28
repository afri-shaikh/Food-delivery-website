<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change password</h1></br></br>

        <?php 
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current password:</td>
                    <td>
                        <input type="password" name="current_password" placeholder="Enter current password">
                    </td>
                </tr>
                <tr>
                    <td>New password:</td>
                    <td>
                        <input type="password" name="new_password" placeholder="Enter new passowrd">
                    </td>
                </tr>
                <tr>
                    <td>Confirm password:</td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm passowrd">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id?>" >
                        <input type="submit" name="submit" value="Change password" class="btn-secondary">
                    </td>
                </tr>

            </table>  
        </form>
    </div>
</div>

<?php 
//check whether submit is clicked and change password
    if(isset($_POST['submit']))
    {
        
        //get the data from the form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        //code to check whether the user with current id and current password or not
        $sql = "SELECT * FROM admin WHERE id=$id AND passwd='$current_password'";
        $res = mysqli_query($conn, $sql);
        if($res==true)
        {
            //check whether data is available and if id matches with the passwd
            $count = mysqli_num_rows($res);
            if($count==1)
            {
               // echo "User found";
               //check new passwd and conf passwd match
               if($new_password == $confirm_password)
               {
                    $sql2 = "UPDATE admin SET passwd='$new_password' WHERE id=$id";
                    $res2 = mysqli_query($conn, $sql2);
                    if($res2==true)
                    {
                        //display message if query successful
                        $_SESSION['change-pwd'] = "<div class='success'>Password changed successfully</div>";
                        header("Location:".HOME.'admin/manage-admin.php');
                    }
                    else
                    {
                        $_SESSION['change-pwd'] = "<div class='error'>Failed to change Password</div>";
                        header("Location:".HOME.'admin/manage-admin.php');
                    }
               }
               else
               {
                $_SESSION['passwd-mismatch'] = "<div class='error'>Password does not match</div>";
                header("Location:".HOME.'admin/manage-admin.php');
               }

            }
            else
            {
                $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
                header("Location:".HOME.'admin/manage-admin.php');
            }
        }
    }
?>

<?php include('partials/footer.php'); ?>