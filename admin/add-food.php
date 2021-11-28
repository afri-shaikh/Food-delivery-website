<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1> 
</br>

        <?php
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
                        <input type="text" name="title" placeholder="Enter title">
                    </td>
                </tr>
                <tr>
                    <td>Description:</td>
                    <td>
                        <textarea name="description"  cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price:</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category:</td>
                    <td>
                        <select name="category">
                            <?php
                                //create php code to display categories from databse
                                //query to fetch all active categories from 
                                $sql = "SELECT * FROM category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql);
                                
                                //count rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);
                                //if count is greater than 0 we have categories else we do not have categories
                                if($count>0)
                                {
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>
                                        <option value="<?php echo $id;?>"><?php echo $title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }
                                //displayon dropdown
                             ?>
                        </select>
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
                    <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>

        <?php
            //Check whetehr the submit button is clicked
            if(isset($_POST['submit']))
            {
                //add the food deatils in detabase
                //echo "Clicked"; -testing

                //get data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //check whetehe radio button is selected
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];

                }
                else
                {
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

                //upload image if selected

                //check whether the select image is clicked or not & upload image only is the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //get details of the selected image
                    $image_name = $_FILES['image']['name'];

                    //check whether image is slected or not and upoad only if selected
                    if($image_name != "")
                    {
                        //means image is selected 

                        //rename the image, get extension of the selected image
                        $ext = end(explode('.', $image_name));

                        //create a new name for the image
                        $image_name ="food-name-".rand(0000, 9999).'.'.$ext;

                        //source path is the cureent loaction of the image
                        $src = $_FILES['image']['tmp_name'];
                        $dest_path = "../images/food/".$image_name;

                        //finally upload the image
                        $upload = move_uploaded_file($src, $dest_path);

                        //check if image is uploaded or not
                        if($upload==false)
                        {
                            //failed to upload the image, redirect to add food page and break - use die() to stop the process and don't store data in database
                            $_SESSION['upload'] ="<div class='error'>Failed to upload image</div>";
                            header("Location:".HOME.'admin/add-food.php');
                            die();
                        }
                    }
                }
                else
                {
                    $image_name = ""; //setting default value as blank
                }
                //insert into database

                //create a sql query to add food
                $sql2 = "INSERT INTO food SET
                        title = '$title',
                        description = '$description',
                        price = $price,
                        image_name = '$image_name',
                        category_id = $category,
                        featured = '$featured',
                        active = '$active'
                ";
                
                $res2 = mysqli_query($conn, $sql2);

                //check whether data is inserted or not, //redirect to manage food page
             
                if($res2 == true)
                {
                    //data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food added successfully!</div>";
                    header("Location:".HOME.'admin/manage-food.php');
                }
                else
                {
                    $_SESSION['add']="<div class='error'>Faild to Add Food!</div>";
                    header("Location:".HOME.'admin/manage-food.php');
                }
            }   
        ?>
    </div>

</div>

<?php include('partials/footer.php');?>