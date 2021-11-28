<?php include('partials-front/menu.php');?>
    <?php
        //check whether id is set and passd or not
        if(isset($_GET['category_id']))
        {
            $category_id = $_GET['category_id'];
            //get the category title based on category
            $sql = "SELECT title FROM category WHERE id=$category_id";

            //execute the query
            $res = mysqli_query($conn, $sql);

            //get the value from database
            $row = mysqli_fetch_assoc($res);

            //get the title
            $category_title = $row['title'];
        }
        else
        {
            //catgeory not passes, redirect to homepage
            header("Location:".HOME);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white"><?php echo $category_title;?></a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //create sql query to get foods based on selected category
                $sql2 = "SELECT * FROM food WHERE category_id=$category_id";
                //execute the query
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_fetch_assoc($res2); 

                if($count2>0)
                {
                    //food is available
                    while($rows = mysqli_fetch_assoc($res2))
                    {
                        $id = $rows['id'];
                        $title = $rows['title'];
                        $price = $rows['price'];
                        $description = $rows['description'];
                        $image_name = $rows['image_name'];
                        ?>
                          <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name=="")
                                    {
                                        //image not available
                                        echo "<div class='error'>Image not found!</div>";
                                    }
                                    else
                                    {
                                        ?>
                                         <img src="<?php echo HOME;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Momo" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                               
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price; ?></p>
                                <p class="food-detail"><?php echo $description;?></p><br>
                                <a href="<?php echo HOME;?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    //food not available
                }
            ?>      

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>