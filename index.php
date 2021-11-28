<?php include('partials-front/menu.php'); ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo HOME;?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>
            <?php
                //create query to display categories from database
                $sql = "SELECT * FROM category WHERE active='Yes' AND featured='Yes' LIMIT 6";
                $res = mysqli_query($conn, $sql);

                //cound to check whether categories is available or not
                $count = mysqli_num_rows($res);
                if($count>0)
                {
                    //categories available
                    while($row = mysqli_fetch_assoc($res) )
                    {
                        //get values like id, title image 
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                         <a href="<?php echo HOME;?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                            <?php
                                //check whether image is available or not
                                if($image_name=="")
                                {
                                    echo "<div class='error'>Image not available</div>";
                                } 
                                else
                                {
                                    ?>
                                    <img src="<?php echo HOME;?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                                    <?php
                                }
                            ?>
                            <h3 class="float-text text-white"><?php echo $title;?></h3>
                            </div>
                        </a>
                        <?php
                    }
                }
                else
                {
                    echo "<div class='error'>No categories available</div>";
                }

            ?>       

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->




    <!-- food MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //query to get details 
                $sql2 = "SELECT * FROM food WHERE active='Yes' AND featured='Yes' LIMIT 6";
                $res2 = mysqli_query($conn, $sql2);
                $count2 = mysqli_num_rows($res2);

                //check whether food available or not
                if($count2 > 0)
                {
                    //food available
                    while($row2 = mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    //check whether the image is available
                                    if($image_name=="")
                                    {
                                        //image not available
                                        echo "<div class='error'>Image not availabl</div>";
                                    }
                                    else
                                    {
                                        ?>
                                        <img src="<?php echo HOME;?>images/food/<?php echo $image_name;?>" alt="Chicken Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">$<?php echo $price;?></p>
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
                    echo "<div class='error'>Food not available</div>";
                }

            ?>
            <div class="clearfix"></div>
        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php') ?>