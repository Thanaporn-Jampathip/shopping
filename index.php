<?php
include 'backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];
$user = $_SESSION['user'];

if(!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$sqlUser = "SELECT username FROM user WHERE id = $userid";
$queryUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($queryUser);

$sqlRes = "SELECT * ,restaurant.id, restaurant.name,restauranttype.name AS resType FROM restaurant JOIN restauranttype ON restaurant.restaurantType_id = restauranttype.id";
$queryRes = mysqli_query($conn, $sqlRes);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>หน้าหลัก</title>
    <style>
        a{
            text-decoration: none;
        }
        .card{
            width: 20rem;
        }
    </style>
</head>
<body>
    
    <?php
    // เช็คสถานะผู้ใช้
    if($statusUser === 'new'){
        echo '
        <div class="d-flex justify-content-center align-items-center min-vh-100">
            <div class="text-center p-5 border shadow">
                <p class="fs-1 mb-4">รอการอนุมัติจากแอดมิน</p>
                <button class="btn btn-danger btn-lg"><a href="./backend/logout.php" class="text-light">ออกจากระบบ</a></button>
            </div>
        </div>
        ';
    }
    // อนุมัติแล้ว
    elseif($statusUser === 'approved'){ 
    include 'component/navbar.php';
    ?>
    <div class="container mt-5">
        <h3 class="mb-4">ยินดีต้อนรับ คุณ <?php echo $rowUser['username']; ?> เข้าสู่เว็บ Lazapee !!</h3>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php while ($rowRes = mysqli_fetch_assoc($queryRes)) { ?>
                <div class="col">
                    <div class="card h-100 shadow">
                        <img src="image/res01.jpg" alt="" class="card-img-top" style="object-fit: cover; height: 200px;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo $rowRes['name']; ?></h5>
                            <h6 class="card-title"><b>ประเภทร้านอาหาร:</b> <?php echo $rowRes['resType']; ?></h6>
                            <p class="card-text">
                                <b>ที่อยู่:</b> <?php echo $rowRes['address']; ?><br>
                                <b>เบอร์โทร:</b> <?php echo $rowRes['tel']; ?>
                            </p>
                            <div class="mt-auto">
                                <a class="btn btn-primary w-100 btn-sm" href="showFoodType.php?resid=<?php echo $rowRes['id']; ?>">ดูรายละเอียด</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
</body>
</html>