<?php
include 'backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlRestaurant = "SELECT id,name FROM restaurant WHERE user_id = $userid";
$queryRestaurant = mysqli_query($conn, $sqlRestaurant);

$sqlShowFoodType = "SELECT foodtype.id, foodtype.name, restaurant.name AS restaurant FROM foodtype JOIN restaurant ON foodtype.restaurant_id = restaurant.id WHERE foodtype.user_id = $userid";
$queryShowFoodType = mysqli_query($conn, $sqlShowFoodType);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>จัดการหมวดหมู่อาหาร</title>
        <style>
            body {
        background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
        height: 100vh;
        margin: 0;
}
        .card{
            width: 300px;
        }
        table{
            
            max-width: 100%;
        }
    </style>
</head>
<body>
    <?php include 'component/navbar.php'; ?>
    <div class="container mt-5">
        <h4 class="text-center">จัดการหมวดหมู่อาหาร</h4>
        <div class="d-flex justify-content-center mt-3">
            <div class="card shadow">
                <form action="" method="post">
                    <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <div class="card-body m-3">
                    <h5 class="text-center">เพิ่มหมวดหมู่อาหาร</h5>
                    <div class="mb-3">
                        <label for="" class="mt-1">ชื่อหมวดหมู่อาหาร</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-4">
                        <label for="" class="mt-1">ร้าน</label>
                        <select name="restaurant" class="form-select" id="" required>
                            <option value="" selected disabled>-- เลือกร้านอาหารของคุณ --</option>
                            <?php while ($rowRes = mysqli_fetch_assoc($queryRestaurant)) { ?>
                                <option value="<?php echo $rowRes['id']; ?>"><?php echo $rowRes['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm w-100" name="addFoodType">เพิ่มหมวดหมู่อาหาร</button>
                </div>
                </form>
            </div>
            <div class="ms-5 table-responsive">
                <table class="table table-light shadow">
                    <tr class="table table-dark">
                        <th>ชื่อหมวดหมู่อาหาร</th>
                        <th>ร้าน</th>
                        <th>การจัดการ</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($queryShowFoodType)) {
                    ?>
                    <tr>
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['restaurant'] ?></td>
                        <td class="d-flex pe-3">
                            <!-- BTN EDIT -->
                            <button class="btn btn-warning w-100 btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editFormModal<?php echo $row['id'] ?>">แก้ไข</button>
                            <!-- MODAL EDIT -->
                            <div class="modal fade" id="editFormModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="addFormLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- FORM EDIT -->
                                        <form action="./backend/foodType_Edit.php" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editFormModal">แก้ไขหมวดหมู่อาหาร</h5>
                                            </div>
                                            <div class="modal-body">
                            
                                                <input type="hidden" value="<?php echo $row['id'] ?>" name="id">
                                                <div class="mb-3">
                                                    <label for="" class="mb-1">ชื่อประเภทอาหาร</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="<?php echo $row['name'] ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="mb-1">ร้าน</label>
                                                    <select name="restaurant" id="" class="form-select">
                                                        <?php 
                                                        mysqli_data_seek($queryRestaurant, 0);
                                                        while ($rowRes = mysqli_fetch_assoc($queryRestaurant)) { ?>
                                                            <option value="<?php echo $rowRes['id']; ?>"><?php echo $rowRes['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-warning w-100" name="edit">แก้ไข</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- BTN DELETE -->
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button class="btn btn-danger w-100 btn-sm ms-2" type="submit" name="delete">ลบ</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
if(isset($_POST['addFoodType'])){
    $name = $_POST['name'];
    $restaurant = $_POST['restaurant'];
    $userid = $_POST['userid'];

    $sqlAddFoodType = "INSERT INTO foodtype (name, user_id, restaurant_id) VALUES ('$name', $userid, $restaurant)";
    $queryAddFoodType = mysqli_query($conn, $sqlAddFoodType);
    if($queryAddFoodType){
        echo '<script>
                Swal.fire({
                    title: "เพิ่มหมวดหมู่อาหารสำเร็จ",
                    icon: "success",
                    confirmButtonText: "ปิด",
                    draggable: true
                }).then(() =>{
                    window.location.href="foodType.php";
                })
            </script>';
    }else{
        echo '<script>
                Swal.fire({
                    title: "เพิ่มหมวดหมู่อาหารไม่สำเร็จ",
                    icon: "error",
                    confirmButtonText: "ปิด",
                    draggable: true
                }).then(() =>{
                    window.location.href="foodType.php";
                })
            </script>';
    }
}
if(isset($_POST['delete'])){
    $id = $_POST['id'];

    $sqlDeleteFoodType = "DELETE FROM foodtype WHERE id = $id";
    $queryDeleteFoodType = mysqli_query($conn, $sqlDeleteFoodType);
    if($queryDeleteFoodType){
        echo '<script>
                Swal.fire({
                    title: "ลบหมวดหมู่อาหารสำเร็จ",
                    icon: "success",
                    confirmButtonText: "ปิด",
                    draggable: true
                }).then(() =>{
                    window.location.href="foodType.php";
                })
            </script>';
    }else{
        echo '<script>
                Swal.fire({
                    title: "ลบหมวดหมู่อาหารไม่สำเร็จ",
                    icon: "error",
                    confirmButtonText: "ปิด",
                    draggable: true
                }).then(() =>{
                    window.location.href="foodType.php";
                })
            </script>';
    }
}
?>