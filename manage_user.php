<?php
session_start();
include 'backend/db.php';
$userType = $_SESSION['userType'];
$userid = $_SESSION['userid'];
$statusUser = $_SESSION['status'];

$sqlNew = "SELECT user.id, username ,CONCAT(user.name, ' ',user.lastname) AS fullname, email, tel, status, usertype.name AS userType FROM user JOIN usertype ON user.userType_id = usertype.id WHERE user.userType_id = 4";
$queryNew = mysqli_query($conn, $sqlNew);

$sqlRestaurant = "SELECT user.id, username ,CONCAT(user.name, ' ',user.lastname) AS fullname, email, tel, status, usertype.name AS userType FROM user JOIN usertype ON user.userType_id = usertype.id WHERE user.userType_id = 2";
$queryRestaurant = mysqli_query($conn, $sqlRestaurant);

$sqlRider = "SELECT user.id, username ,CONCAT(user.name, ' ',user.lastname) AS fullname, email, tel, status, usertype.name AS userType FROM user JOIN usertype ON user.userType_id = usertype.id WHERE user.userType_id = 3";
$queryRider = mysqli_query($conn, $sqlRider);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>จัดการผู้ใช้งาน</title>
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    margin: 0;
}
    </style>
</head>
<body>
    <?php
    include 'component/navbar.php';
    ?>
    <div class="container mt-5">
        <h4 class="text-center">จัดการผู้ใช้งาน</h4>
        <!-- MEMBER -->
        <h5 class="my-2">รายชื่อผู้ใช้งาน : สมาชิก</h5>
        <div class="table-responsive">
            <table class="table mt-1 table-light shadow">
                <tr class="table-dark">
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>อีเมลล์</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>ประเภทการสมัคร</th>
                    <th>สถานะการใช้งาน</th>
                    <th>จัดการผู้ใช้งาน</th>
                </tr>
                <?php while($rowNew = mysqli_fetch_assoc($queryNew)){ ?>
                    <tr>
                        <td><?php echo $rowNew['username']; ?></td>
                        <td><?php echo $rowNew['fullname']; ?></td>
                        <td><?php echo $rowNew['email']; ?></td>
                        <td><?php echo $rowNew['tel']; ?></td>
                        <td>
                            <?php
                            if ($rowNew['userType'] == 'member') {
                                echo '<span class="text-success">Member</span>';
                            } elseif ($rowNew['userType'] == 'restaurant') {
                                echo '<span class="text-warning">Restaurant</span>';
                            } elseif ($rowNew['userType'] == 'rider') {
                                echo '<span class="text-primary">Rider</span>';
                            } else {
                                echo 'ไม่ทราบประเภท';
                            }
                            ?>
                        </td>
                        <td>
                        <form action="" method="post">
                            <input type="hidden" name="userid" value="<?php echo $rowNew['id']; ?>">
                            <select name="status" id="" class="form-select" onchange="this.form.submit()">
                                <option value="new"<?php if($rowNew['status'] === 'new') echo ' selected'; ?>>รอการอนุมัติ</option>
                                <option value="approved"<?php if($rowNew['status'] === 'approved') echo ' selected'; ?>>อนุมัติ</option>
                                <option value="cancelled"<?php if($rowNew['status'] === 'cancelled') echo ' selected'; ?>>ไม่อนุมัติ</option>
                            </select>
                        </form>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="userid" value="<?php echo $rowNew['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm w-100" name="delete">ลบผู้ใช้งาน</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <!-- RESTAURANT -->
        <h5 class="my-2">รายชื่อผู้ใช้งาน : ร้านอาหาร</h5>
        <div class="table-responsive">
            <table class="table table-light shadow">
                <tr class="table-warning">
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>อีเมลล์</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>ประเภทการสมัคร</th>
                    <th>สถานะการใช้งาน</th>
                    <th>จัดการผู้ใช้งาน</th>
                </tr>
                <?php
                while ($rowRes = mysqli_fetch_assoc($queryRestaurant)){
                ?>
                <tr>
                    <td><?php echo $rowRes['username'] ?></td>
                    <td><?php echo $rowRes['fullname'] ?></td>
                    <td><?php echo $rowRes['email'] ?></td>
                    <td><?php echo $rowRes['tel'] ?></td>
                    <td>
                        <?php
                            if ($rowRes['userType'] == 'member') {
                                echo '<span class="text-success">Member</span>';
                            } elseif ($rowRes['userType'] == 'restaurant') {
                                echo '<span class="text-warning">Restaurant</span>';
                            } elseif ($rowRes['userType'] == 'rider') {
                                echo '<span class="text-primary">Rider</span>';
                            } else {
                                echo 'ไม่ทราบประเภท';
                            }
                            ?>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="userid" value="<?php echo $rowRes['id']; ?>">
                            <select name="status" id="" class="form-select" onchange="this.form.submit()">
                                <option value="new" <?php if ($rowRes['status'] === 'new')
                                    echo ' selected'; ?>>รอการอนุมัติ</option>
                                <option value="approved" <?php if ($rowRes['status'] === 'approved')
                                    echo ' selected'; ?>>อนุมัติ</option>
                                <option value="cancelled" <?php if ($rowRes['status'] === 'cancelled')
                                    echo ' selected'; ?>>ไม่อนุมัติ</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="userid" value="<?php echo $rowRes['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm w-100" name="delete">ลบผู้ใช้งาน</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <!-- RIDER -->
        <h5 class="my-2">รายชื่อผู้ใช้งาน : ไรเดอร์</h5>
        <div class="table-responsive">
            <table class="table table-light shadow">
                <tr class="table-info">
                    <th>ชื่อผู้ใช้</th>
                    <th>ชื่อ-นามสกุล</th>
                    <th>อีเมลล์</th>
                    <th>เบอร์โทรศัพท์</th>
                    <th>ประเภทการสมัคร</th>
                    <th>สถานะการใช้งาน</th>
                    <th>จัดการผู้ใช้งาน</th>
                </tr>
                <?php
                while ($rowRider = mysqli_fetch_assoc($queryRider)){
                ?>
                <tr>
                    <td><?php echo $rowRider['username'] ?></td>
                    <td><?php echo $rowRider['fullname'] ?></td>
                    <td><?php echo $rowRider['email'] ?></td>
                    <td><?php echo $rowRider['tel'] ?></td>
                    <td>
                        <?php
                            if ($rowRider['userType'] == 'member') {
                                echo '<span class="text-success">Member</span>';
                            } elseif ($rowRider['userType'] == 'restaurant') {
                                echo '<span class="text-warning">Restaurant</span>';
                            } elseif ($rowRider['userType'] == 'rider') {
                                echo '<span class="text-primary">Rider</span>';
                            } else {
                                echo 'ไม่ทราบประเภท';
                            }
                            ?>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="userid" value="<?php echo $rowRider['id']; ?>">
                            <select name="status" id="" class="form-select" onchange="this.form.submit()">
                                <option value="new" <?php if ($rowRider['status'] === 'new')
                                    echo ' selected'; ?>>รอการอนุมัติ</option>
                                <option value="approved" <?php if ($rowRider['status'] === 'approved')
                                    echo ' selected'; ?>>อนุมัติ</option>
                                <option value="cancelled" <?php if ($rowRider['status'] === 'cancelled')
                                    echo ' selected'; ?>>ไม่อนุมัติ</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="userid" value="<?php echo $rowRider['id']; ?>">
                            <button type="submit" class="btn btn-danger btn-sm w-100" name="delete">ลบผู้ใช้งาน</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>
<?php
if(isset($_POST['status'])){
    $status = $_POST['status'];
    $userid = $_POST['userid'];
    $sqlUpdate = "UPDATE user SET status = '$status' WHERE id = '$userid'";
    $query = mysqli_query($conn, $sqlUpdate);
    if($query){
        echo '<script>alert("เปลี่ยนสถานะสำเร็จ"); window.location.href = "manage_user.php";</script>';
    }else{
        echo '<script>alert("เปลี่ยนสถานะไม่สำเร็จ"); window.location.href = "manage_user.php";</script>';
    }
}
if(isset($_POST['delete'])){
    $userid = $_POST['userid'];
    $sqlDelete = "DELETE FROM user WHERE id = '$userid'";
    $query = mysqli_query($conn, $sqlDelete);
    if($query){
        echo '<script>alert("ลบผู้ใช้งานสำเร็จ"); window.location.href = "manage_user.php";</script>';
    }else{
        echo '<script>alert("ลบผู้ใช้งานไม่สำเร็จ"); window.location.href = "manage_user.php";</script>';
    }
}
?>