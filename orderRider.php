<?php
include 'backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];
$user = $_SESSION['user'];

$sqlOrder = "SELECT foodorder.id, order_date, order_status,c.username AS username, CONCAT(c.name, ' ' ,c.lastname) AS customer, CONCAT(r.name, ' ' ,r.lastname) AS rider, c.address AS address , c.tel AS tel
            FROM foodorder
            JOIN user c ON foodorder.customer_id = c.id
            LEFT JOIN user r ON foodorder.rider_id = r.id
            JOIN restaurant ON foodorder.restaurant_id = restaurant.id
            WHERE foodorder.order_status = 'cooking'
            ";
$queryOrder = mysqli_query($conn, $sqlOrder);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>คำสั่งซื้อ</title>
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
        <h4 class="text-center">คำสั่งซื้อทั้งหมด</h4>
        <div class="table-responsive mt-3">
            <table class="table table-light shadow">
                <tr class="table table-dark">
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อ-สกุล</th>
                    <th>ที่อยู่</th>
                    <th>เบอร์โทร</th>
                    <th>สถานะ</th>
                    <th>การจัดการ</th>
                </tr>
                <?php while ($rowOrder = mysqli_fetch_assoc($queryOrder)) : ?>
                    <tr>
                        <td><?php echo $rowOrder['username']; ?></td>
                        <td><?php echo $rowOrder['customer']; ?></td>
                        <td><?php echo $rowOrder['address']; ?></td>
                        <td><?php echo $rowOrder['tel']; ?></td>
                        <td>
                            <?php
                            switch($rowOrder['order_status']) {
                                case 'cooking':
                                    echo '<span class="text-info">รอการจัดส่ง</span>';
                                    break;
                                case 'delivery':
                                    echo '<span class="text-primary">กำลังจัดส่ง</span>';
                                    break;
                                case 'completed':
                                    echo '<span class="text-success">จัดส่งสำเร็จz</span>';
                                    break;
                            }
                            ?>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" value="<?php echo $rowOrder['id'] ?>" name="orderID">
                                <input type="hidden" value="<?php echo $userid ?>" name="riderID">
                                <button class="btn btn-primary btn-sm" type="submit" name="delivery">กำลังจัดส่ง</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
if(isset($_POST['delivery'])){
    $orderid = $_POST['orderID'];
    $riderid = $_POST['riderID'];
    $sql = "UPDATE foodorder SET order_status = 'delivery', rider_id = '$riderid' WHERE id = $orderid";
    $query = mysqli_query($conn, $sql);

    if($query){
        echo "<script>window.location.href = 'orderRiderLocal.php';</script>";
    }else{
        echo "<script>window.location.href = 'orderRiderLocal.php';</script>";
    }
}
?>