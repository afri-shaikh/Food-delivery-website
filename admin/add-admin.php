<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
</br></br>
        <?php 
            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                  <tr>
                      <td>Full Name</td>
                      <td><input type="text"  name="full_name" placeholder="Enter the name"></td>
                  </tr>
                  <tr>
                      <td>Username</td>
                      <td>
                          <input type="text" name="username" placeholder="Username">
                      </td>
                  </tr>
                  <tr>
                      <td>Password</td>
                      <td>
                          <input type="password" name="password" placeholder="Your password">
                      </td>
                  </tr>
                  <tr>
                      <td colspan="2">
                          <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                      </td>
                  </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php');?>

<?php 

    //Process the value from form and save in db
    if(isset($_POST['submit']))
    {
        //Get data from form to process
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //pass encryption with MD5 canot be decrypted


        //sql query to sav the data into the db
        $sql = "INSERT INTO admin SET full_name='$full_name', username='$username', passwd='$password' ";
    
        
        //save data with the help of the query
        $res =mysqli_query($conn, $sql) or die(mysqli_error());

        if($res==TRUE)
        {
            //create session var to display message
            $_SESSION['add'] = "Admin added successfully";
            header("Location:".HOME.'admin/manage-admin.php');
        }
        else
        {
            $_SESSION['add'] = "Failed to add admin";
            header("Location:".HOME.'admin/add-admin.php');
        }

    }
    

?>