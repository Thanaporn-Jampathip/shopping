<?php
include 'backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlRes = "SELECT restaurant.name, restaurant.id ,restaurant.address, restaurant.tel, restaurant.image, restaurant.discount, restaurant.minimum_price,restauranttype.id AS resId, restauranttype.name AS resType FROM restaurant JOIN restauranttype ON restaurant.restaurantType_id = restauranttype.id WHERE user_id = '$userid'";
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
    <title>จัดการร้านอาหาร</title>
    <style>
        .card {
            width: auto;
        }
        table {
            table-layout: auto;
            width: auto;
            max-width: 100%;
        }
    </style>
</head>

<body>
    <?php include 'component/navbar.php'; ?>
    <div class="container mt-5">
        <h4 class="text-center mb-3">จัดการร้านอาหาร</h4>
    <div class="d-flex justify-content-center">
        <div class="card shadow me-5">
            <form action="" method="post">
                <input type="hidden" name="userid" value="<?php echo $userid; ?>">
                <div class="card-body m-3">
                    <h5 class="text-center">เพิ่มร้านอาหาร</h5>
                    <div class="mb-3 text-center">
                        <label for="">รูปร้านอาหาร</label><br>
                        <img src="./image/default_profile.png" alt="" class="mt-3" width="30%">
                    </div>
                    <input type="file" name="imageRes">
                    <div class="row mt-3">
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="mb-1">ชื่อร้านอาหาร</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="mb-1">เบอร์โทรร้าน</label>
                                <input type="text" class="form-control" name="tel" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">ที่อยู่</label>
                        <textarea name="address" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="mb-1">ส่วนลด (%)</label>
                                <input type="int" class="form-control" name="discount" placeholder="หากไม่มีกรุณาเว้นว่างไว้">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="mb-1">ราคาขั้นต่ำ (บาท)</label>
                                <input type="int" class="form-control" name="minimum_price" placeholder="หากไม่มีกรุณาเว้นว่างไว้">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">ประเภทร้านอาหาร</label>
                        <select name="resType" class="form-control" id="">
                            <option value="" selected disabled>-- กรุณาเลือกประเภทร้านอาหาร --</option>
                            <?php
                            $sqlResType = "SELECT * FROM restauranttype";
                            $queryResType = mysqli_query($conn, $sqlResType);
                            while ($rowResType = mysqli_fetch_assoc($queryResType)) {
                                ?>
                                <option value="<?php echo $rowResType['id']; ?>"><?php echo $rowResType['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm w-100" type="submit" name="addRes">เพิ่มร้านอาหาร</button>
                </div>
            </form>
        </div>
    </div>
        <div class="table-responsive mt-5">
            <table class="table shadow table-light">
                <tr class="table table-dark">
                    <th>รูปร้านอาหาร</th>
                    <th>ชื่อร้านอาหาร</th>
                    <th>เบอร์โทร</th>
                    <th>ที่อยู่</th>
                    <th>ส่วนลด (%)</th>
                    <th>ราคาขั้นต่ำ (บาท)</th>
                    <th>ประเภทร้านอาหาร</th>
                    <th>จัดการ</th>
                </tr>
                <?php
                while ($rowRes = mysqli_fetch_assoc($queryRes)) {
                    ?>
                    <tr>
                        <td><img src="<?php echo $rowRes['image'] ?>" alt="" width="30%"></td>
                        <td><?php echo $rowRes['name'] ?></td>
                        <td><?php echo $rowRes['tel'] ?></td>
                        <td><?php echo $rowRes['address'] ?></td>
                        <td><?php echo $rowRes['discount'] ?></td>
                        <td><?php echo $rowRes['minimum_price'] ?></td>
                        <td><?php echo $rowRes['resType'] ?></td>
                        <td>
                            <div class="d-flex gap-2">
                                <!-- BTN EDIT -->
                                <button class="btn btn-warning btn-sm w-100" data-bs-toggle="modal" data-bs-target="#edit<?php echo $rowRes['id'] ?>">แก้ไข</button>
                                <!-- MODAL EDIT -->
                                <div class="modal fade" tabindex="-1" id="edit<?php echo $rowRes['id'] ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>แก้ไขข้อมูล</h4>
                                            </div>
                                            <form action="./backend/manageRes_Edit.php" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $rowRes['id'] ?>">
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="" class="mb-1">ชื่อร้านอาหาร</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    value="<?php echo $rowRes['name']; ?>" required>
                                                            </div>
                                                            <div class="col">
                                                                <label for="" class="mb-1">เบอร์โทรร้าน</label>
                                                                <input type="text" name="tel" class="form-control"
                                                                    value="<?php echo $rowRes['tel']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="mb-1">ที่อยู่</label>
                                                        <textarea name="address" class="form-control" rows="3" required><?php echo $rowRes['address']; ?></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="" class="mb-1">ส่วนลด (%)</label>
                                                                <input type="int" name="discount" class="form-control"
                                                                    value="<?php echo $rowRes['discount']; ?>" required>
                                                            </div>
                                                            <div class="col">
                                                                <label for="" class="mb-1">ราคาขั้นต่ำ (บาท)</label>
                                                                <input type="int" name="minimum_price" class="form-control"
                                                                    value="<?php echo $rowRes['minimum_price']; ?>" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="" class="mt-1">ประเภทร้านอาหาร</label>
                                                        <select name="resType" id="" class="form-select">
                                                            <option value=""selected disabled>-- เลือกประเภทร้านอาหาร --</option>
                                                            <?php
                                                            $sqlResType = "SELECT * FROM restauranttype";
                                                            $queryResType = mysqli_query($conn, $sqlResType);
                                                            while ($rowResType = mysqli_fetch_assoc($queryResType)) { ?>
                                                                <option value="<?php echo $rowResType['id']; ?>" <?php echo ($rowResType['id'] == $rowRes['resId']) ? 'selected' : ''; ?>><?php echo $rowResType['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-warning w-100 btn-sm" type="submit" name="edit">แก้ไข</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- BTN DELETE -->
                                <form action="" method="post">
                                    <input type="hidden" name="id" value="<?php echo $rowRes['id']; ?>">
                                    <button class="btn btn-danger btn-sm w-100" type="submit" name="delete">ลบ</button>
                                </form>
                            </div>
                            <button class="btn btn-primary btn-sm w-100 mt-2" type="button">อัพโหลดรูปภาพ</button><br>
                            ยังไม่ได้ทำ fn upload image
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
if (isset($_POST['addRes'])) {
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $discount = $_POST['discount'] ?? null;
    $minimum_price = $_POST['minimum_price'] ?? null;
    $resType = $_POST['resType'] ?? null;
    $userid = $_POST['userid'];
    $imageRes = 'image/default_profile.png';

    $sql = "INSERT INTO restaurant (name, tel, address, discount, minimum_price, user_id,image, restaurantType_id) VALUES ('$name', '$tel', '$address', '$discount', '$minimum_price', '$userid','$imageRes', '$resType')";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo '<script>
            Swal.fire({
            title: "เพิ่มร้านอาหารสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_restaurant.php";
            })
        </script>';
    } else {
        echo '<script>
            Swal.fire({
            title: "เพิ่มร้านอาหารไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_restaurant.php";
            })
        </script>';
    }
}

if(isset($_POST['delete'])){
    $id = $_POST['id'];
    $sql = "DELETE FROM restaurant WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
    if($query) {
        echo '<script>
            Swal.fire({
            title: "ลบร้านอาหารสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_restaurant.php";
            })
        </script>';
    } else {
        echo '<script>
            Swal.fire({
            title: "ลบร้านอาหารไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_restaurant.php";
            })
        </script>';
    }
}
?>