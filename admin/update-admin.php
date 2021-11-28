<?php include("partials/menu.php"); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Admin</h1> </br></br>

            <?php 
                //get id of selected admin
                $id = $_GET['id'];

                //create sql query to get the details
                $sql="SELECT * FROM admin WHERE id=$id";
                $res=mysqli_query($conn, $sql);

                //check query execution
                if($res==true)
                {
                    $count = mysqli_num_rows($res);
                    if($count==1)
                    {
                        //echo "Admin available";
                        $row=mysqli_fetch_assoc($res);
                        $full_name = $row['full_name'];
                        $username = $row['username'];

                    }
                    else
                    {
                        header("Location:".HOME.'admin/magage-adin.php');
                    }
                }
            ?>

            <form action="" method="post">
                <table class="tbl-30">
                    <tr>
                        <td>Full name:</td>
                        <td>
                            <input type="text" name="full_name" value="<?php echo $full_name;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td>
                            <input type="text" name="username" value="<?php echo $username;?>">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="submit" name="submit" value="Update admin" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
        </div>

    </div>
<?php 
//check and update details only if submit is clicked
if(isset($_POST['submit']))
{
    //echo "Button clicked"; check and test here whether it is updating
   $id=$_POST['id'];
   $full_name = $_POST['full_name'];
   $username = $_POST['username'];

   $sql = "UPDATE admin SET full_name='$full_name', username='$username'WHERE id='$id'";
   $res = mysqli_query($conn, $sql);
   if($res==true)
   {
       //query executed and admin executed else failed to update admin
       $_SESSION['update'] = "<div class='success'> Admin updated successfully</div>";
       //redirect to admin page
       header("Location:".HOME.'admin/manage-admin.php');
   }
   else{
       //query executed and admin executed else failed to update admin
       $_SESSION['update'] = "<div class='error'> Admin updated successfully</div>";
       //redirect to admin page
       header("Location:".HOME.'admin/manage-admin.php');
   }
}
?>
<?php include("partials/footer.php");?>