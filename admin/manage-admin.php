<?php include('partials/menu.php'); ?>

        <div class="main-content"> 
        <div class="wrapper">
                <h1>Manage Admin</h1> </br>
                <?php 
                if(isset($_SESSION['add']))
                {
                        echo $_SESSION['add']; //displaying session message
                        unset($_SESSION['add']); //removing session message 
                } 

                if(isset($_SESSION['delete']))
                {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                }

                if(isset($_SESSION['update']))
                {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                }

                if(isset($_SESSION['user-not-found']))
                {
                        echo $_SESSION['user-not-found'];
                        unset($_SESSION['user-not-found']);
                }

                if(isset($_SESSION['passwd-mismatch']))
                {
                        echo $_SESSION['passwd-mismatch'];
                        unset($_SESSION['passwd-mismatch']);
                }

                if(isset($_SESSION['change-pwd']))
                {
                        echo $_SESSION['change-pwd'];
                        unset($_SESSION['change-pwd']);
                }

                ?> </br></br>
                <!--Button to add admin-->
                <a href="add-admin.php" class="btn-primary">Add Admin </a> </br></br>

                <table class="tbl-full">
                        <tr>
                                <th>S.N</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Actions</th>
                        </tr>

                        <?php
                                $sql="SELECT * FROM admin";
                                //execute query
                                $res = mysqli_query($conn, $sql);

                                //check whether query is execeuted
                                if($res==TRUE)
                                {
                                        $count = mysqli_num_rows($res); // function to get rows in databse table
                                        
                                        $sn=1; //create a var and assign the value 

                                        if($count > 0)
                                        {
                                                while($rows=mysqli_fetch_assoc($res)){
                                                        //using while loopto get all the data from database and while loop will execute run as long as we have data in db
                                                        $id=$rows['id']; //get data
                                                        $full_name=$rows['full_name'];
                                                        $username=$rows['username'];
                                                        //Displaying data in html table
                                                        ?>
                                                        <tr>
                                                                <td><?php echo $sn++; ?>.</td>
                                                                <td><?php echo $full_name; ?></td>
                                                                <td><?php echo $username; ?></td>
                                                                <td>
                                                                        <a href="<?php echo HOME;?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change password</a>
                                                                        <a href="<?php echo HOME;?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update admin</a> 
                                                                        <a href="<?php echo HOME;?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete admin</a>
                                                                </td>
                                                        </tr>
                                                        
                                                        <?php


                                                }
                                        }
                                        else
                                        {
                                                //
                                        }
                                }
                        ?>

                </table>
            </div>
        </div>
<?php include('partials/footer.php');?>
