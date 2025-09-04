<?php
include './backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

if($_GET['resid']){
    $resid = $_GET['resid'];

    $sqlRes = "SELECT restaurant.name, restauranttype.name AS resType FROM restaurant JOIN restauranttype ON restaurant.restaurantType_id = restauranttype.id WHERE restaurant.id = $resid";
    $queryRes = mysqli_query($conn, $sqlRes);
    $rowRes = mysqli_fetch_assoc($queryRes);

    $sqlFoodType = "SELECT id, name FROM foodtype WHERE restaurant_id = $resid";
    $queryFoodType = mysqli_query($conn, $sqlFoodType);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>ประเภทอาหาร</title>
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
        <a href="index.php" class="btn btn-danger btn-sm mb-3">กลับไปยังหน้าหลัก</a>
        <h4><b><?php echo $rowRes['name'] ?></b></h4>
        <h5><b>ประเภทร้านอาหาร:</b> <?php echo $rowRes['resType'] ?></h5>
        <hr>
        <h4 class="text-center mb-3">ประเภทอาหาร</h4>
        <div class="table-responsive d-flex justify-content-center">
            <table class="table table-light shadow">
                <tr class="table table-dark">
                    <th>ประเภทอาหาร</th>
                    <th></th>
                </tr>
                <?php while ($rowFoodType = mysqli_fetch_assoc($queryFoodType)) { ?>
                    <tr>
                        <td><?php echo $rowFoodType['name']; ?></td>
                        <td>
                            <a class="btn btn-primary btn-sm w-100" href="showFoodMenu.php?foodTypeId=<?php echo $rowFoodType['id']; ?>&resid=<?php echo $resid; ?>">ดูรายละเอียด</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>