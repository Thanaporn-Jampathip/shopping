<?php
include './backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlFood = "SELECT foodmenu.id, foodmenu.name, foodmenu.price, foodmenu.image, foodtype.name AS foodType FROM foodmenu JOIN foodtype ON foodmenu.foodtype_id = foodtype.id WHERE foodmenu.user_id = $userid";
$queryFood = mysqli_query($conn, $sqlFood);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>จัดการอาหาร</title>
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
    include './component/navbar.php';
    ?>
    <div class="container mt-5">
        <h4 class="text-center mb-3">จัดการอาหาร</h4>
        <div class="d-flex">
            <div class="card shadow">
                <form action="" method="post">
                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <div class="card-body m-3">
                        <h5 class="text-center">เพิ่มอาหาร</h5>
                        <div class="mb-3 text-center">
                            <label for="">รูปร้านอาหาร</label><br>
                            <img src="./image/default_profile.png" alt="" class="mt-3" width="30%">
                        </div>
                            <input type="file" name="" id="" class="mb-3">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="mb-1">ชื่ออาหาร</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="" class="mb-1">ราคาอาหาร (บาท)</label>
                                    <input type="int" class="form-control" name="price" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-1">ประเภทอาหาร</label>
                            <select name="foodtype" id="" class="form-select">
                                <option value=""selected disabled>-- เลือกประเภทอาหาร --</option>
                                <?php
                                $sqlFoodType = "SELECT * FROM foodtype WHERE user_id = $userid";
                                $queryFoodType = mysqli_query($conn, $sqlFoodType);
                                while ($rowFoodType = mysqli_fetch_assoc($queryFoodType) ){
                                ?>
                                    <option value="<?php echo $rowFoodType['id'] ?>"><?php echo $rowFoodType['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <button class="btn btn-primary btn-sm w-100 mt-4" type="submit" name="addFood">เพิ่มรายการอาหาร</button>
                    </div>
                </form>
            </div>
            <div class="ms-5 table-responsive">
                <table class="table table-light shadow">
                    <tr class="table table-dark">
                        <th>รูปอาหาร</th>
                        <th>ชื่ออาหาร</th>
                        <th>ราคาอาหาร (บาท)</th>
                        <th>ประเภทอาหาร</th>
                        <th>การจัดการ</th>
                    </tr>
                    <?php
                    while ($rowFood = mysqli_fetch_assoc($queryFood)) {
                    ?>
                    <tr>
                        <td><img src="<?php echo $rowFood['image'] ?>" alt="" width="30%"></td>
                        <td><?php echo $rowFood['name'] ?></td>
                        <td><?php echo $rowFood['price'] ?></td>
                        <td><?php echo $rowFood['foodType'] ?></td>
                        <td>
                            <!-- BTN EDIT -->
                            <button class="btn btn-warning w-100 btn-sm mb-2" type="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $rowFood['id'] ?>">แก้ไข</button>
                            <!-- MODAL EDIT -->
                            <div class="modal fade" tabindex="-1" id="edit<?php echo $rowFood['id'] ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>แก้ไขข้อมูล</h4>
                                        </div>
                                        <form action="./backend/food_Edit.php" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $rowFood['id'] ?>">
                                                <div class="mb-3">
                                                    <label for="" class="mb-1">ชื่ออาหาร</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="<?php echo $rowFood['name']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="mb-1">ราคาอาหาร (บาท)</label>
                                                    <input type="text" name="price" class="form-control"
                                                        value="<?php echo $rowFood['price']; ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="" class="mb-1">เลือกประเภทอาหาร</label>
                                                    <select name="foodType" id="" class="form-select">
                                                        <?php
                                                        $sqlFoodType = "SELECT * FROM foodtype WHERE user_id = $userid";
                                                        $queryFoodType = mysqli_query($conn, $sqlFoodType);
                                                        while ($rowFoodType = mysqli_fetch_assoc($queryFoodType)) { ?>
                                                            <option value="<?php echo $rowFoodType['id']; ?>" <?php echo ($rowFoodType['id'] == $rowFood['foodType']) ? 'selected' : ''; ?>><?php echo $rowFoodType['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <button class="btn btn-warning w-100 btn-sm" type="submit" name="edit">แก้ไข</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-danger w-100 btn-sm" type="submit">ลบ</button>
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
if(isset($_POST['addFood'])){
    $name = $_POST['name'];
    $price = $_POST['price'];
    $foodtype = $_POST['foodtype'];
    $userid = $_POST['userid'];
    $imageFood = 'image/default_profile.png';

    $sqlAddFood = "INSERT INTO foodmenu (name, price, foodType_id, user_id, image) VALUES ('$name', '$price', '$foodtype', '$userid', '$imageFood')";
    $queryAddFood = mysqli_query($conn, $sqlAddFood);
    if($queryAddFood){
        echo '<script>
            Swal.fire({
            title: "เพิ่มรายการอาหารสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="food.php";
            })
        </script>';
    }else{
        echo '<script>
            Swal.fire({
            title: "เพิ่มรายการอาหารไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="food.php";
            })
        </script>';
    }
}
?>