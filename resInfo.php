<?php
include 'backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlRes = "SELECT restaurant.id, restaurant.name, restaurant.address, restaurant.tel, restaurant.image, restauranttype.name AS restaurantType , user.username AS username FROM restaurant JOIN restauranttype ON restaurant.restaurantType_id = restauranttype.id JOIN user ON restaurant.user_id = user.id";
$queryRes = $conn->query($sqlRes);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลร้านอาหาร</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    height: 100vh;
    margin: 0;
}
    </style>
</head>
<body>
    <?php
    include 'component/navbar.php';
    ?>
    <div class="container mt-5">
        <h4 class="text-center mb-3">ข้อมูลร้านอาหาร</h4>
        <div class="table-responsive">
            <table class="table table-light shadow">
                <tr class="table-dark">
                    <th>#</th>
                    <th>รูปร้านอาหาร</th>
                    <th>ชื่อร้านอาหาร</th>
                    <th>ประเภท</th>
                    <th>ที่อยู่</th>
                    <th>เบอร์โทร</th>
                    <th>เจ้าของร้าน</th>
                    <th>การจัดการ</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($queryRes)){
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="<?php echo $row['image'] ?>" alt="" width="30%"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['restaurantType']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['tel']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button class="btn btn-danger btn-sm w-100" type="submit" name="deleteRes">ลบ</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if(isset($_POST['deleteRes'])){
    $id = $_POST['id'];
    $sqlDelete = "DELETE FROM restaurant WHERE id = $id";
    $queryDelete = $conn->query($sqlDelete);
    if($queryDelete){
        echo '<script>
            Swal.fire({
            title: "ลบสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="resInfo.php";
            })
        </script>';
    }else{
        echo '<script>
            Swal.fire({
            title: "ลบไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="resInfo.php";
            })
        </script>';
    }
}
?>