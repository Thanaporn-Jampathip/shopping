<?php
include './backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlUser = "SELECT username FROM user WHERE id = $userid";
$queryUser = mysqli_query($conn ,$sqlUser);
$rowUser = mysqli_fetch_assoc($queryUser);

$sqlRes = "SELECT restaurant.name , restaurant.id FROM restaurant WHERE user_id = $userid";
$queryRes = mysqli_query($conn,$sqlRes);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>รายการสั่งอาหาร</title>
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
    <?php include './component/navbar.php'; ?>
    <div class="container mt-5">
        <h4 class="text-center">รายการสั่งอาหาร แต่ละร้านของคุณ <?php echo $rowUser['username'] ?></h4>
        <div class="table-responsive d-flex justify-content-center mt-3">
            <table class="table table-light shadow">
                <tr class="table table-dark">
                    <th>ชื่อร้าน</th>
                </tr>
                <?php
                while ($rowRes = mysqli_fetch_assoc($queryRes)){
                ?>
                <tr>
                    <td><a href="orderRes.php?resid=<?php echo $rowRes['id'] ?>" class="text-primary"><?php echo $rowRes['name'] ?></a></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>