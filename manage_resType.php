<?php
include './backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];
$user = $_SESSION['user'];

$sqlResType = "SELECT * FROM restauranttype";
$queryResType = $conn->query($sqlResType);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>จัดการประเภทร้านอาหาร</title>
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
    <?php
    include 'component/navbar.php';
    ?>
    <div class="container mt-5">
        <h4 class="text-center mb-3">จัดการประเภทร้านอาหาร</h4>
        <div class="d-flex justify-content-center">
            <div class="me-5">
                <form action="" method="post">
                    <div class="card shadow">
                        <div class="card-body m-3">
                            <h5 class="text-center">เพิ่มประเภทร้านอาหาร</h5>
                            <div class="mb-4">
                                <label for="" class="mt-1">ชื่อประเภท</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm w-100" name="addResType">เพิ่มประเภท</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-light shadow">
                    <tr class="table table-dark">
                        <th>#</th>
                        <th>ชื่อประเภท</th>
                        <th>การจัดการ</th>
                    </tr>
                    <?php while ($row = $queryResType->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td class="d-flex">
                                <!-- BTN EDIT -->
                                <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['id']; ?>">แก้ไขข้อมูล</button>
                                <!-- MODAL EDIT -->
                                <div class="modal fade" tabindex="-1" id="edit<?php echo $row['id'] ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>แก้ไขข้อมูล</h4>
                                        </div>
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <div class="mb-3">
                                                    <label for="" class="mb-1">ชื่อประเภท</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                                                </div>
                                                <button class="btn btn-warning w-100 btn-sm" type="submit" name="editResType">แก้ไข</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- BTN DELETE -->
                                <form action="" method="post" class="ms-2">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button class="btn btn-danger btn-sm" name="deleteResType">ลบ</button>
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
if(isset($_POST['addResType'])){
    $name = $_POST['name'];
    $sqlResType = "INSERT INTO restauranttype (name) VALUES ('$name')";
    if($conn->query($sqlResType) === TRUE){
        echo '<script>
            Swal.fire({
            title: "เพิ่มประเภทสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_resType.php";
            })
        </script>';
    }else{
        echo '<script>
            Swal.fire({
            title: "เพิ่มประเภทไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_resType.php";
            })
        </script>';
    }
}

if(isset($_POST['editResType'])){
    $name = $_POST['name'];
    $id = $_POST['id'];
    $sqlResType = "UPDATE restauranttype SET name='$name' WHERE id='$id'";
    if($conn->query($sqlResType) === TRUE){
        echo '<script>
            Swal.fire({
            title: "แก้ไขประเภทสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_resType.php";
            })
        </script>';
    }else{
        echo '<script>
            Swal.fire({
            title: "แก้ไขประเภทไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_resType.php";
            })
        </script>';
    }
}
if(isset($_POST['deleteResType'])){
    $id = $_POST['id'];
    $sqlResType = "DELETE FROM restauranttype WHERE id='$id'";
    if($conn->query($sqlResType) === TRUE){
        echo '<script>
            Swal.fire({
            title: "ลบประเภทสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_resType.php";
            })
        </script>';
    }else{
        echo '<script>
            Swal.fire({
            title: "ลบประเภทไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="manage_resType.php";
            })
        </script>';
    }
}
?>