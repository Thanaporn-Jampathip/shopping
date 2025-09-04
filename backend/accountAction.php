<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
include 'db.php';
$username = $_POST['username'];
$password = $_POST['password'];
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$address = $_POST['address'] ?? null;
$email = $_POST['email'];
$tel = $_POST['tel'];
$userid = $_POST['userid'];

$sql = "UPDATE user SET username = '$username', password = '$password', name = '$name', lastname = '$lastname', address = '$address', email = '$email', tel = '$tel' WHERE id = $userid";
$query = mysqli_query($conn, $sql);
if($query){
    echo '<script>
            Swal.fire({
            title: "แก้ไขข้อมูลสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
        }).then(() =>{
            window.location.href="../account.php";
        })
    </script>';
}else{
    echo '<script>
            Swal.fire({
            title: "แก้ไขข้อมูลไม่สำเร็จ",
            icon: "error",
            confirmButtonText: "ปิด",
            draggable: true
        }).then(() =>{
            window.location.href="../account.php";
        })
    </script>';
}