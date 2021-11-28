<?php include('partials/menu.php'); ?>

<div class="main-content"> 
    <div class="wrapper">
        <h1>Manage Orders</h1> </br></br>
        
        <?php
                if(isset($_SESSION['update']))
                {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                } 
        ?>
</br>
<table class="tbl-full">
        <tr>
                <th>S.N</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Date</th>
                <th>Status</th>
                <th>Cust Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Address</th>
                <th>Actions</th>
        </tr>
        <?php
                //get orders from the databse
                $sql = "SELECT * FROM tbl_order ORDER BY id desc";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                $sn = 1; //create a serial no. and set it's initial value as 1
                if($count>0)
                {
                        //orders available
                        while($row = mysqli_fetch_assoc($res))
                        {
                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date = $row['order_date'];
                                $status = $row['status'];
                                $cust_name = $row['cust_name'];
                                $cust_contact = $row['cust_contact'];
                                $cust_email = $row['cust_email'];
                                $cust_address = $row['cust_addr'];
                                ?>

                                <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>


                                        <td>
                                                <?php 
                                                        if($status=="Ordered")
                                                        {
                                                                echo "<label>$status</label>";
                                                        }
                                                        elseif($status=="On-delivery")
                                                        {
                                                                echo "<label style='color: orange;'>$status</label>";
                                                        }
                                                        elseif($status=="Delivered")
                                                        {
                                                               echo "<label style='color: green;'>$status</label>";
                                                        }
                                                        elseif($status=="Cancelled")
                                                        {
                                                                echo "<label style='color: red;'>$status</label>";
                                                        }
                                                ?>
                                        </td>

                                        <td><?php echo $cust_name; ?></td>
                                        <td><?php echo $cust_contact; ?></td>
                                        <td><?php echo $cust_email; ?></td>
                                        <td><?php echo $cust_address;?></td>
                                        <td>
                                        <a href="<?php echo HOME;?>admin/update-order.php?id=<?php echo $id;?>" class="btn-secondary">Update order</a> 
                                        </td>
                                </tr>                                

                                <?php
                        }
                }
                else
                {
                        echo "<tr><td colspan='12' class='error'>Orders not available</td></tr>";
                }
        ?>
        
        
</table>
    </div>
</div>

<?php include('partials/footer.php'); ?>