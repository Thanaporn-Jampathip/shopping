<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    
</body>
</html>

<?php
include 'db.php';
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT id, userType_id, username, password, status FROM user WHERE username = '$username' AND password = '$password'";
$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) == 1){
    $row = mysqli_fetch_assoc($query);
    $_SESSION['user'] = $row;
    $_SESSION['userid'] = $row['id'];
    $_SESSION['userType'] = $row['userType_id'];
    $_SESSION['status'] = $row['status'];

    echo '<script>
            Swal.fire({
            title: "เข้าสู่ระบบสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="../index.php";
            })
        </script>';
}else{
    echo '<script>
            Swal.fire({
            title: "เข้าสู่ระบบไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="../login.php";
            })
        </script>';
}
?>