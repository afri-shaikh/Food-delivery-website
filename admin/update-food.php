<?php include('partials/menu.php'); ?>

<?php
    //check whether id is set or not
    if(isset($_GET['id']))
    {
        //get all the details
        $id = $_GET['id'];
        $sql2 = "SELECT * FROM food WHERE id=$id";
        $res2 = mysqli_query($conn, $sql2);

        //get the values in array format based on query excution
        $row = mysqli_fetch_assoc($res2);

        //get individual values of selected food
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];

    }
    else
    {
        //redirect to manage food
        header("Location:".HOME.'admin/manage-food.php');
        
    }
?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1></br></br>

            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title:</td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>
                            <textarea name="description" cols="30" rows="5" value="<?php echo $description;?>"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td>
                            <input type="number" name="price" value ="<?php echo $price;?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Current image:</td>
                        <td>
                            <?php
                                if($current_image == "")
                                {
                                    //image not available
                                    echo "<div class='error'>No image added</div>";
                                }
                                else
                                {
                                    //if image available display it
                                    ?>
                                    <img src="<?php echo HOME;?>images/food/<?php echo $current_image;?>" width="100px";>
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Select image:</td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>
                            <select name="category">
                                <?php
                                    $sql = "SELECT * FROM category WHERE active='Yes'";
                                    $res = mysqli_query($conn, $sql);
                                    $count = mysqli_num_rows($res);

                                    //check whether category is available or not
                                    if($count>0)
                                    {
                                        //category available
                                        while($rows = mysqli_fetch_assoc($res))
                                        {
                                            $category_title =  $rows['title'];
                                            $category_id = $rows['id'];
                                            //echo "<option value='$category_id'>$category_title</option>";
                                            ?>
                                            <option <?php if($current_category==$category_id) {echo "Selected"; } ?> value="<?php echo $category_id;?>"> <?php echo $category_title;?> </option>
                                            <?php
                                        }

                                    }
                                    else
                                    {
                                        //category not available
                                        echo "<option value='0'> Category not available</option>";
                                    }
                                ?>
                                <option value="#">Test Category</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Featured:</td>
                        <td>
                            <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                            <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active:</td>
                        <td>
                            <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                            <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id;?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image;?>">
                            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                        </td>
                    </tr>

                </table>
            </form>

            <?php
                if(isset($_POST['submit']))
                {
                    //update food if submit btn is clicked
                    //1. get details from the form and upload the image if selected
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $current_image = $_POST['current_image'];
                    $category = $_POST['category'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];


                    //2.upload the image if selected

                    //3.remove the image if the new image is uploaded and curent image exists
                    if(isset($_FILES['image']['name']))
                    {
                        //upload if button is clicked
                        $image_name =  $_FILES['image']['name']; //new image name
                        if($image_name != "")
                        {
                            //image is available
                            //rename the image
                            $ext = end(explode('.', $image_name)); //gets extension of the image
                            $image_name = "food_name_".rand(000, 999).'.'.$ext; //renames the image

                            $src_path = $_FILES['image']['tmp_name'];
                            $dest_path = "../images/food/".$image_name;

                            $upload = move_uploaded_file($src_path, $dest_path);

                            //check whether the image is uploaded or not
                            if($upload==false)
                            {
                                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                                header("Location:".HOME.'admin/manage-food.php');
                                die();
                            }

                            //remove current image if available
                            if($current_image != "")
                            {
                                //current image is available
                                $remove_path = "../images/food/".$current_image;
                                $remove = unlink($remove_path);
                                if($remove==false)
                                {
                                    //failed to remove current image
                                    $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image</div>";
                                    header("Location:".HOME.'admin/manage-food.php');
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
                        $image_name = $current_image; //when button is not clicked
                    }

                    //update the food in databse
                    $sql3="UPDATE food SET
                        title = '$title',
                        description = '$description',
                        price = '$price',
                        image_name = '$image_name',
                        category_id = '$category',
                        featured = '$featured',
                        active = '$active'
                        WHERE id=$id
                    ";

                    $res3 = mysqli_query($conn, $sql3);
                    if($res3==true)
                    {
                        //query executed
                        $_SESSION['update'] = "<div class='success'>Food updated successfully!</div>";
                        header("Location:".HOME.'admin/manage-food.php', true, 301); exit;
                    }
                    else
                    {
                        //failed to update food
                        $_SESSION['update'] = "<div class='error'>Failed to update food!</div>";
                        header("Location:".HOME.'admin/manage-food.php');
                    }
                    
                    //redirect to manage food with sesssion msg
                    
                }
            ?>
        </div>
    </div>

<?php include('partials/footer.php');?>