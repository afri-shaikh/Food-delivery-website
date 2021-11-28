<?php include('partials-front/menu.php'); ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //query to display display all the categories that are active
                $sql = "SELECT * FROM category WHERE active='Yes'";
                $res =  mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //categories available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        //get the values 
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php echo HOME;?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                            <?php
                                if($image_name=="")
                                {
                                    //image not available
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
                    //categories not available
                    echo "<div class='error'>No categories available</div>";
                }
            ?>
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>