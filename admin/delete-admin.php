<?php
    //add constants to connect to the databse
    include("../config/constants.php");

   //get id of admin to be deleted
   $id = $_GET['id'];

   //query to delete the data from db
    $sql = "DELETE FROM admin WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    if($res==TRUE)
    {
        //echo "Admin Deleted successfully";
        $_SESSION['delete'] = "<div class='success'>Admin deleted successfully</div>";
        header("Location:".HOME.'admin/manage-admin.php'); //redirect to manage admin page
    }
    else
    {
        //echo "Failed to delete admin";
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin</div>";
        header("Location:".HOME.'admin/manage-admin.php');
    }

?>