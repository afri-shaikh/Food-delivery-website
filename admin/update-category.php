<?php include('partials/menu.php');?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1></br></br>

            <?php 
                //check whether the id is set to update fields
                if(isset($_GET['id']))
                {
                    //getthe id and other details
                    //echo "Getting data"; testing
                    $id = $_GET['id'];

                    $sql = "SELECT * FROM category WHERE id=$id";
                    $res = mysqli_query($conn, $sql);

                    //count the rows to check whether the id is valid or not - validation
                    $count = mysqli_num_rows($res); //data should be unique
                    if($count==1)
                    {
                        //get data
                        $row = mysqli_fetch_assoc($res);
                        $title = $row['title'];
                        $current_image = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                    }
                    else
                    {
                        //redirect to manage-category page
                        $_SESSION['no-category-found'] = "<div class='error'>Category not found</div>";
                        header("Location:".HOME.'admin/manage-category.php');
                    }

                }
                else
                {
                    header("Location:".HOME.'admin/manage-catgeory.php');
                }

            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30" >
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title;?>" >
                        </td>
                    </tr>
                    <tr>
                        <td>Current image:</td>
                        <td>
                            <?php
                                if($current_image != "")
                                {
                                    ?>
                                    <img src="<?php echo HOME;?>images/category/<?php echo $current_image;?>" width="100px">
                                    <?php
                                }
                                else
                                {
                                    echo "<div class='error'>Image not added!</div>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input <?php if($featured=="Yes") {echo "checked";}?> type="radio" name="featured" value="Yes">Yes
                            
                            <input <?php if($featured=="No") {echo "checked";}?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active:</td>
                        <td>
                            <input  <?php if($active=="Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                            
                            <input  <?php if($active=="No") {echo "checked";} ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>

            <?php            
                if(isset($_POST['submit']))
                {
                    //echo "Clicked"; - testing
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    //updating new image if selected - check whether image is selected
                    if(isset($_FILES['image']['name']))
                    {
                        //get image details
                        $image_name = $_FILES['image']['name'];
                        if($image_name != "") 
                        {
                            //means image is available then upload new img 
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
                                header("Location:".HOME.'admin/manage-category.php');
                                //stop the process 
                                die();
                            }

                            //remove the current image if available
                            if($current_image != "")
                            {
                                $remove_path = "../images/category/".$current_image;

                                $remove = unlink($remove_path);

                                //check whether the image is removed of not, if failed to remove thn display msg and break
                                if($remove==false)
                                {
                                    $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image</div>";
                                    header("Location:".HOME.'admin/manage-category.php');
                                    die();
                                }
                            }
                            
                        }
                        else
                        {
                            $image_name = $current_image;
                        }
                    }
                    else
                    {
                        $image_name = $current_image;
                    }

                    //ulpoad category
                    $sql2 = "UPDATE category SET 
                            title='$title',
                            image_name='$image_name',
                            featured='$featured',
                            active='$active'
                            WHERE id=$id
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    //redirect to manage-catgeory with msg, check whether executed or not
                    if($res2==true)
                    {
                        //category updated
                        $_SESSION['update'] = "<div class='success'>Category updated successfully!</div>";
                        header("Location:".HOME.'admin/manage-category.php');
                    }
                    else
                    {
                        //failed to update
                        $_SESSION['update'] = "<div class='error'>Failed to update category!</div>";
                        header("Location:".HOME.'admin/manage-category.php');
                    }

                }
            ?>
        </div>
    </div>


<?php include('partials/footer.php');?>

