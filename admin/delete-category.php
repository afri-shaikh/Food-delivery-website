<?php 
    include('../config/constants.php');
    //echo "Delete Page"; 
    //check whether the id and image_name value is set or not
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //get the value and delete
        //echo "Get value and Delete";
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
        
        //remove the physical image file if available and then delete data from database
        if($image_name != "")
        {
            //create variable $path
            $path = "../images/category/".$image_name;
            //removing image
            $remove = unlink($path);
            
            //if failed to remove image then add an error message and stop the process
            if($remove==false)
            {
                //get session msg and redirect to categoy page and break the process
                $_SESSION['remove'] = "<div class='error'>Failed to remove category image</div>";
                header("Location:".HOME.'admin/manage-category.php');
                die(); 
            }
        }
        
        //query to delete the data
        $sql = "DELETE FROM category WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        //check whether data is deleted from the db or nor  //then redirect to manage category page with messgae
        if($res==true)
        {
            //set a success msg
            $_SESSION['delete'] = "<div class='success'>Category deleted successfully</div>";
            header("Location:".HOME.'admin/manage-category.php');

        }
        else
        {
            //set a failed msg and redirect
            $_SESSION['delete'] = "<div class='error'>Failed to delete category</div>";
            header("Location:".HOME.'admin/manage-category.php');
        }

    }
    else
    {
        //redirect to manage category
        header("Location:".HOME.'admin/manage-category.php');
    }
?>
