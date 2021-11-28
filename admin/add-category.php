<?php include('partials/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper"> </br>
            <h1>Add Category</h1>
            </br></br>

            <?php

                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?> </br></br>

            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" value="" placeholder="Category Title">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active:</td>
                        <td>
                            <input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>

            <?php
                //check whether submit is clicked to add data 
                if(isset($_POST['submit']))
                {
                    //echo "Clicked";
                    $title = $_POST['title'];

                    //get radio input type we need to check whether button is selected or not
                    if(isset($_POST['featured']))
                    {
                        ///set the value from the form
                        $featured = $_POST['featured'];
                    }
                    else
                    {
                        //else set the default value
                        $featured = "No";
                    }

                    if(isset($_POST['active']))
                    {
                        $active = $_POST['active'];
                    }
                    else
                    {
                        $active = "No";
                    }
                    
                    //check whether the image is selected or not and set the value for image name accordingly
                    //print_r($_FILES['image']);
                    //die();  break here

                    if(isset($_FILES['image']['name']))
                    {
                        //upload the image - to upload image we need image name and source path & destination path
                        $image_name = $_FILES['image']['name'];
                        
                        //upload image only if image name is selected
                        if($image_name != "")
                        {

                        
                            //Auto-rename the image if same image is uploaded without replacing the first one
                            //get the extension of the image(jpg, png,gif etc.) e.g."specialfood1.jpg"
                            $ext = end(explode('.', $image_name)); //end gets last ext value

                            //rename image
                            $image_name ="food_category_".rand(000, 999).'.'.$ext; //new name will be food_category_364.jpg rand() generates any no and adds to name of file
                            

                            $source_path = $_FILES['image']['tmp_name'];
                            $destination_path = "../images/category/".$image_name;

                            //finally upload image
                            $upload = move_uploaded_file($source_path, $destination_path);

                            //check whether the image is uploaded or not, if not uploaded then stop the process and redirect with error msg
                            if($upload == false)
                            {
                                //set message
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                                header("Location:".HOME.'admin/add-category.php');
                                //stop the process 
                                die();
                            }
                        }

                    }
                    else
                    {
                        //don't upload image and set the imag value as blank
                        $image_name="";
                    }


                    //query to insert category data into database
                    $sql = "INSERT INTO category SET
                            title='$title',
                            image_name='$image_name',
                            featured='$featured',
                            active='$active'
                    ";

                    //execute query and save in database
                    $res = mysqli_query($conn, $sql);

                    if($res==true)
                    {
                        $_SESSION['add'] = "<div class='success'> Category added successfully!</div>";
                        header("Location:".HOME.'admin/manage-category.php');
                    }
                    else
                    {
                        //failed to add category
                        $_SESSION['add'] = "<div class='error'> Failed to add category!</div>";
                        header("Location:".HOME.'admin/add-category.php');  
                    }
                }
            ?>

        </div>
    </div>

<?php include('partials/footer.php');?>