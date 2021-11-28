<?php 
    include('partials/menu.php');?>
        <div class="main-content"> 
        <div class="wrapper">
                <h1>Dashboard</h1>

                <?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }
                ?> </br>

                <div class="col-4 text-center">
                    <?php
                        $sql = "SELECT * FROM category";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);

                    ?>
                    <h1><?php echo $count; ?></h1> </br>
                    Categories
                </div>
                <div class="col-4 text-center">
                <?php
                        $sql2 = "SELECT * FROM food";
                        $res2 = mysqli_query($conn, $sql2);
                        $count2 = mysqli_num_rows($res2);

                    ?>
                    <h1><?php echo $count2; ?></h1> </br>
                    Foods
                </div>
                <div class="col-4 text-center">
                <?php
                        $sql3 = "SELECT * FROM tbl_order";
                        $res3 = mysqli_query($conn, $sql3);
                        $count3 = mysqli_num_rows($res3);

                    ?>
                    <h1><?php echo $count3; ?></h1> </br>
                    Total orders
                </div>
                <div class="col-4 text-center">
                    <?php
                        //query to get total revenue generated
                        //aggregate function in sql
                        $sql4 = "SELECT SUM(total) as total FROM tbl_order WHERE status='Delivered' ";
                        $res4 = mysqli_query($conn, $sql4);
                        
                        //get the value
                        $row4 = mysqli_fetch_assoc($res4);

                        $total_revenue = $row4['total'];
                    ?>
                    <h1>$<?php echo $total_revenue; ?></h1> </br>
                    Revenue generated
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

<?php include('partials/footer.php') ?>