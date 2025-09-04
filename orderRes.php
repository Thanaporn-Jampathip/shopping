<?php
include './backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

if($_GET['resid']){
    $resid = $_GET['resid'];
}
$sqlRes = "SELECT restaurant.name FROM restaurant WHERE id = $resid";
$queryRes = mysqli_query($conn ,$sqlRes);
$rowRes = mysqli_fetch_assoc($queryRes);

$sqlOrder = "SELECT foodorder.id ,order_date, order_status, c.username AS customer, restaurant.name AS restaurant , r.username AS rider FROM foodorder 
            JOIN user c ON foodorder.customer_id = c.id
            JOIN restaurant ON foodorder.restaurant_id = restaurant.id
            LEFT JOIN user r ON foodorder.rider_id = r.id WHERE restaurant_id = $resid AND foodorder.order_status != 'completed';
            ";
$queryOrder = mysqli_query($conn ,$sqlOrder);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>ออเดอร์ <?php echo $rowRes['name'] ?></title>
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    height: 100vh;
    margin: 0;
}
    </style>
</head>
<body>
    <?php include 'component/navbar.php'; ?>
    <div class="container mt-5">
        <a href="foodOrder.php" class="btn btn-danger btn-sm mb-3">ย้อนกลับ</a>
        <h4>คำสั่งซื้อ : <b><?php echo $rowRes['name'] ?></b></h4>
        <div class="table-responsive mt-3">
            <table class="table table-light shadow">
                <tr class="table table-dark">
                    <th>#</th>
                    <th>รายชื่อลูกค้า</th>
                    <th>ชื่อไรเดอร์</th>
                    <th>วันที่สั่งอาหาร</th>
                    <th>สถานะคำสั่งซื้อ</th>
                    <?php
                    $sqlStatus = "SELECT order_status FROM foodorder WHERE order_status = 'cooking'";
                    $queryStatus = mysqli_query($conn ,$sqlStatus);
                    if($queryStatus){
                    ?>
                    <th>รายละเอียดคำสั่งซื้อ</th>
                    <?php } ?>
                    <th>การจัดการ</th>
                </tr>
                <?php while($rowOrder = mysqli_fetch_assoc($queryOrder)){ ?>
                    <tr>
                        <td><?php echo $rowOrder['id'] ?></td>
                        <td><?php echo $rowOrder['customer'] ?></td>
                        <td>
                            <?php
                            if ($rowOrder['rider'] == null){
                                echo "<span class='text-secondary'>ยังไม่มีไรเดอร์</span>";
                            }else{
                                echo $rowOrder['rider'];
                            }
                            ?>
                        </td>
                        <td><?php echo $rowOrder['order_date'] ?></td>
                        <td>
                            <?php
                            switch($rowOrder['order_status']){
                                case 'new':
                                    echo "<span class='text-success'>คำสั่งซื้อใหม่</span>";
                                    break;
                                case 'accepted':
                                    echo "<span class='text-warning'>กำลังเตรียมอาหาร</span>";
                                    break;
                                case 'cooking':
                                    echo "<span class='text-info'>รอการจัดส่ง</span>";
                                    break;
                                case 'delivered':
                                    echo "<span class='text-success'>จัดส่งแล้ว</span>";
                                    break;
                                case 'completed':
                                    echo "<span class='text-success'>จัดส่งสำเร็จ</span>";
                                    break;
                            }
                            ?>
                        </td>
                        <?php
                            $sqlStatus = "SELECT order_status FROM foodorder WHERE order_status = 'cooking'";
                            $queryStatus = mysqli_query($conn ,$sqlStatus);
                            if($queryStatus){
                            ?>
                            <td><a href="orderDetail.php?orderID=<?php echo $rowOrder['id'] ?>&resid=<?php echo $resid ?>" class="text-primary">รายละเอียดคำสั่งซื้อ</a></td>
                        <?php } ?>
                        <td>
                            <?php if ($rowOrder['order_status'] == 'new'){ ?>
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $rowOrder['id']?>" name="id">
                                <input type="hidden" value="accepted" name="status">
                                <button class="btn btn-warning btn-sm" type="submit" name="accepted">กำลังเตรียมอาหาร</button>
                            </form>
                            <?php }elseif($rowOrder['order_status'] == 'accepted'){ ?>
                                <form action="" method="post">
                                <input type="hidden" value="<?php echo $rowOrder['id']?>" name="id">
                                <input type="hidden" value="cooking" name="status">
                                <button class="btn btn-primary btn-sm" type="submit" name="cooking">รอการจัดส่ง</button>
                            </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
if(isset($_POST['accepted'])){
    $status = $_POST['status'];
    $orderId = $_POST['id'];

    $sql = "UPDATE foodorder SET order_status = '$status' WHERE id = $orderId";
    $query = mysqli_query($conn ,$sql);
    if($query){
        echo "<script>window.location.href='orderRes.php?resid=$resid'</script>";
    }else{
        echo "<script>window.location.href='orderRes.php?resid=$resid'</script>";
    }
}
if(isset($_POST['cooking'])){
    $status = $_POST['status'];
    $orderId = $_POST['id'];

    $sql = "UPDATE foodorder SET order_status = '$status' WHERE id = $orderId";
    $query = mysqli_query($conn ,$sql);
    if($query){
        echo "<script>window.location.href='orderRes.php?resid=$resid'</script>";
    }else{
        echo "<script>window.location.href='orderRes.php?resid=$resid'</script>";
    }
}

?>