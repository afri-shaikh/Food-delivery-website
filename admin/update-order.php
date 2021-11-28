<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper"> 
        <h1>Update order</h1></br></br>

        <?php 
            //check whether id is set or not
            if(isset($_GET['id']))
            {
                //get the order details
                $id = $_GET['id'];
                //get all other details based on this id
                $sql = "SELECT * FROM tbl_order WHERE id=$id";
                $res = mysqli_query($conn, $sql);
                $count = mysqli_num_rows($res);
                if($count==1)
                {
                    //data available
                    $row = mysqli_fetch_assoc($res);
                    
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['cust_name'];
                    $customer_contact = $row['cust_contact'];
                    $customer_email = $row['cust_email'];
                    $customer_addr = $row['cust_addr'];
                }
                else
                {
                    //data not available , redirct to manage-order page
                    header("Location:".HOME.'admin/manage-order.php');
                }

            }
            else
            {
                //redirect is manage order 
                header("Location:".HOME.'admin/manage-order.php');
            }
        ?>

        <form action="" method="post">
            <table  class="tbl-30">
                <tr>
                    <td>Food name:</td>
                    <td><b><?php echo $food; ?></b></td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>
                        <b>$<?php echo $price;?></b>
                    </td>
                </tr>
                <tr>
                    <td>Qty:</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty;?>">
                    </td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="On-delivery"){echo "selected";} ?> value="On-delivery">On-delivery</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Customer Name:</td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer contact:</td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Email:</td>
                    <td>
                        <input type="email" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Customer Address:</td>
                    <td>
                        <textarea name="customer_addr" cols="30" rows="5"><?php echo $customer_addr; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            //check whether update button is clicked or not
            if(isset($_POST['submit']))
            {
                //echo "Clicked"; testing
                //get values from form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                
                $total = $price * $qty;

                $status = $_POST['status'];
                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_addr = $_POST['customer_addr'];

                //query to update the values
                $sql2 = "UPDATE tbl_order SET
                        qty = $qty,
                        total = $total,
                        status = '$status',
                        cust_name = '$customer_name',
                        cust_contact = '$customer_contact',
                        cust_email = '$customer_email',
                        cust_addr = '$customer_addr'
                        WHERE id=$id
                ";
                
                $res2 = mysqli_query($conn, $sql2);
                if($res2 == true)
                {
                    //data updated
                    $_SESSION['update'] = "<div class='success'>Order updated successfully!</div>";
                    header("Location:".HOME.'admin/manage-order.php');
                }
                else
                {
                    //failed to update
                    $_SESSION['update'] = "<div class='error'>Failed to update order!</div>";
                    header("Location:".HOME.'admin/manage-order.php');
                }

                //redirect

            }
        ?>

    </div>

</div>

<?php include('partials/footer.php'); ?>