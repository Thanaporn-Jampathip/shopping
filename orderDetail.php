<?php
include './backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];
$user = $_SESSION['user'];

if($_GET['orderID'] && $_GET['resid']){
    $orderid = $_GET['orderID'];
    $resid = $_GET['resid'];
}

$sqlOrderDetail = "SELECT qty, foodmenu.name AS foodmenu FROM orderdetail JOIN foodmenu ON orderdetail.foodMenu_id = foodmenu.id WHERE foodOrder_id = $orderid";
$queryOrderDetail = mysqli_query($conn ,$sqlOrderDetail);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>รายละเอียด | ออเดอร์ <?php echo $orderid ?></title>
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    height: 100vh;
    margin: 0;
}
        table{
            max-width: 50%;
        }
    </style>
</head>
<body>
    <?php include 'component/navbar.php' ?>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button class="btn btn-danger btn-sm" onclick="window.history.back()">ย้อนกลับ</button>
            <h4 class="text-center flex-grow-1">รายละเอียด | ออเดอร์ <?php echo $orderid ?></h4>
        </div>
        <div class="table-responsive mt-3 d-flex justify-content-center">
            <table class="table table-light shadow">
                <tr class="table-dark">
                    <th>รายชื่ออาหาร</th>
                    <th>จำนวน</th>
                </tr>
                <?php while ($rowOrderDetail = mysqli_fetch_assoc($queryOrderDetail)) { ?>
                    <tr>
                        <td><?php echo $rowOrderDetail['foodmenu']; ?></td>
                        <td><?php echo $rowOrderDetail['qty']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>