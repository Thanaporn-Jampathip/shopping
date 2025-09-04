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
$name = $_POST['name'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$tel = $_POST['tel'];
$userType = $_POST['userType'];
$address = $_POST['address'];
$image = '../image/default_profile.png';

if ($userType == 4) {
    $sql = "INSERT INTO user (username, password, name, lastname, email, tel, image,userType_id, address) VALUES ('$username', '$password', '$name', '$lastname', '$email', '$tel', '$image', '$userType', '$address')";
} elseif ($userType == 2) {
    $sql = "INSERT INTO user (username, password, name, lastname, email, tel, image,userType_id, address) VALUES ('$username', '$password', '$name', '$lastname', '$email', '$tel', '$image', '$userType', '$address')";
} elseif ($userType == 3) {
    $sql = "INSERT INTO user (username, password, name, lastname, email, tel, image,userType_id, address) VALUES ('$username', '$password', '$name', '$lastname', '$email', '$tel', '$image', '$userType', '$address')";
}

$query = mysqli_query($conn, $sql);
if($query){
    echo '<script>
            Swal.fire({
            title: "สมัครสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="../login.php";
            })
        </script>';
}
?>