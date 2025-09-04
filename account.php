<?php
include 'backend/db.php';
session_start();
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlUser = "SELECT * FROM user WHERE id = $userid";
$queryUser = mysqli_query($conn, $sqlUser);
$rowUser = mysqli_fetch_assoc($queryUser);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>ประวัติผู้ใช้งาน</title>
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    height: 100vh;
    margin: 0;
}
        a {
            text-decoration: none;
        }
        .card {
            margin: 0 15rem 0 15rem;
        }
        .profile-image {
            width: 25%;
            object-fit: cover;
        }
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem; /* เพิ่มระยะห่างระหว่างรูปภาพและข้อมูล */
        }
    </style>
</head>
<body>
    <?php
    include './component/navbar.php';
    ?>
    <div class="container pt-5">
        <div class="card shadow">
            <div class="card-body m-3">
                <h4 class="text-center">ประวัติผู้ใช้งาน</h4>
                <div class="profile-container">
                    <img src="image/default_profile.png" alt="Profile Picture" class="profile-image">
                    <div class="ms-5">
                        <div class="my-3">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="mb-1">ชื่อผู้ใช้งาน</label>
                                    <input type="text" class="form-control" value="<?php echo $rowUser['username']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="" class="mb-1">รหัสผ่าน</label>
                                    <input type="password" class="form-control" value="<?php echo $rowUser['password']; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col">
                                    <label for="" class="mb-1">ชื่อจริง</label>
                                    <input type="text" class="form-control" value="<?php echo $rowUser['name']; ?>" disabled>
                                </div>
                                <div class="col">
                                    <label for="" class="mb-1">นามสกุล</label>
                                    <input type="text" class="form-control" value="<?php echo $rowUser['lastname']; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="mb-1">ที่อยู่</label>
                            <textarea class="form-control" rows="3" disabled><?php echo $rowUser['address']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-8">
                                    <label for="" class="mb-1">อีเมลล์</label>
                                    <input type="email" class="form-control" value="<?php echo $rowUser['email']; ?>" disabled>
                                </div>
                                <div class="col-4">
                                    <label for="" class="mb-1">เบอร์โทรศัพท์</label>
                                    <input type="text" class="form-control" value="<?php echo $rowUser['tel']; ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <!-- BUTTON EDIT -->
                        <button class="btn btn-warning btn-sm fs-6" type="button" data-bs-toggle="modal" data-bs-target="#edit<?php echo $userid ?>">แก้ไขข้อมูล</button>
                        <button class="btn btn-primary btn-sm fs-6 ms-1" type="button">อัพโหลดรูปภาพ</button> (ยังไม่ได้ทำ fn upload image)
                        <!-- MODAL EDIT -->
                        <div class="modal fade" tabindex="-1" id="edit<?php echo $userid ?>">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4>แก้ไขข้อมูล</h4>
                                </div>
                                <form action="./backend/accountAction.php" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="userid" value="<?php echo $userid ?>">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="" class="mb-1">ชื่อผู้ใช้งาน</label>
                                                    <input type="text" name="username" class="form-control" value="<?php echo $rowUser['username']; ?>" required>
                                                </div>
                                                <div class="col">
                                                    <label for="" class="mb-1">รหัสผ่าน</label>
                                                    <input type="password" name="password" class="form-control" value="<?php echo $rowUser['password']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col">
                                                    <label for="" class="mb-1">ชื่อจริง</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo $rowUser['name']; ?>" required>
                                                </div>
                                                <div class="col">
                                                    <label for="" class="mb-1">นามสกุล</label>
                                                    <input type="text" name="lastname" class="form-control" value="<?php echo $rowUser['lastname']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="" class="mb-1">ที่อยู่</label>
                                            <textarea class="form-control" name="address" rows="3" ><?php echo $rowUser['address']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-8">
                                                    <label for="" class="mb-1">อีเมลล์</label>
                                                    <input type="email" name="email" class="form-control" value="<?php echo $rowUser['email']; ?>" required>
                                                </div>
                                                <div class="col-4">
                                                    <label for="" class="mb-1">เบอร์โทรศัพท์</label>
                                                    <input type="text" name="tel" class="form-control" value="<?php echo $rowUser['tel']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-warning w-100 btn-sm" type="submit">แก้ไข</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
