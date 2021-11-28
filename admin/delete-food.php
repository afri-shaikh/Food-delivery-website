<?php 
    include('../config/constants.php');
    //echo "Delete food"; testing
    //check value is passed on url
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //delete
        //1.get id and image name
        $id = $_GET['id'];
        $image_name = $_GET['image_name']; 

        //2.check whether the image is available and remove image if available then delete
        if($image_name != "")
        {
            //it has image and need to remove from folder
            $src_path = "../images/food/".$image_name;

            $remove = unlink($src_path);

            //check whether the image is removed or not
            if($remove == false)
            {
                //failed to remove image
                $_SESSION['upload'] = "<div class='error'>Failed to remove image</div>";
                header("location:".HOME.'admin/manage-food.php');
                //stop the process of deleting food
                die();
            }
        }

        //3. delete food from the database
        $sql = "DELETE FROM food WHERE id=$id";
        $res = mysqli_query($conn, $sql);
        
        //check whether the query is executed or not and set th session message respectively
        //4.redirect to manage food with session manage
        if($res==true)
        {
            $_SESSION['delete'] = "<div class='success'>Food deleted successfully</div>";
            header("Location:".HOME.'admin/manage-food.php');
        }
        else
        {
            $_SESSION['delete'] = "<div class='error'>Failed to delete food</div>";
            header("Location:".HOME.'admin/manage-food.php');
        }

        
    }
    else
    {
        //redirect to manage food page
        $_SESSION['unauthorised'] = "<div class='error'>Unauthorised access</div>";
        header("Location:".HOME.'admin/manage-food.php');
    }
?>