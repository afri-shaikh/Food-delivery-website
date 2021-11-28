<?php include('partials-front/menu.php'); ?>
<?php
    if(isset($_GET['food_id']))
    {
        $food_id = $_GET['food_id'];
        $sql = "SELECT * FROM food WHERE id=$food_id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            //food available
            $row = mysqli_fetch_assoc($res);
            $title = $row['title'];
            $price = $row['price'];
            $description = $row['description'];
            $image_name = $row['image_name'];
        }
        else
        {
            //food not available
            header("Location:".HOME);
        }
    }
    else
    {
        //redirect to homepage
        header("Location:".HOME);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="post" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                            //check whether the image is available or not
                            if($image_name=="")
                            {
                                echo "<div class='error'>Image not available</div>";
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo HOME?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                <?php

                            }
                        ?>
                        
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">

                        <p class="food-price">$<?php echo $price;?></p>
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Afrin Shaikh" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>

            <?php
                //check whether submit button is clicked
                if(isset($_POST['submit']))
                {
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty; //total =price * qty

                    $order_date = date("Y-m-d h:m:s"); //order date

                    $status = "Ordered!"; //types of status will be ordered, on-delivery, delivered and cancelled which will be maintained by the admin
                    $cust_name = $_POST['full-name'];
                    $cust_contact = $_POST['contact'];
                    $cust_email = $_POST['email'];
                    $cust_address = $_POST['address'];

                    //save the order in the database
                    $sql2 = "INSERT INTO tbl_order SET 
                            food = '$food',
                            price = $price,
                            qty = $qty,
                            total = $total,
                            order_date = '$order_date',
                            status = '$status',
                            cust_name = '$cust_name',
                            cust_contact = '$cust_contact',
                            cust_email = '$cust_email',
                            cust_addr = '$cust_address'
                    ";

                    $res2 = mysqli_query($conn, $sql2);

                    if($res2==true)
                    {
                        //query
                        $_SESSION['order'] = "<div class='success text-center'>Order placed successfully!</div>";
                        header("Location:".HOME);
                    }
                    else
                    {
                        //failed
                        $_SESSION['order'] = "<div class='error text-center'>Failed to place order!</div>";
                        header("Location:".HOME);
                
                    }
                }
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>