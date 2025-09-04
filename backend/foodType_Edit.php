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
if(isset($_POST['edit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $restaurant = $_POST['restaurant'];

    $sql = "UPDATE foodtype SET name = '$name', restaurant_id = '$restaurant' WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    if($query){
        echo '<script>
                Swal.fire({
                title: "แก้ไขหมวดหมู่อาหารสำเร็จ",
                icon: "success",
                confirmButtonText: "ปิด",
                draggable: true
                }).then(() =>{
                    window.location.href="../foodType.php";
                })
            </script>';
    }else{
        echo '<script>
                Swal.fire({
                title: "แก้ไขหมวดหมู่อาหารไม่สำเร็จ",
                icon: "error",
                confirmButtonText: "ปิด",
                draggable: true
                }).then(() =>{
                    window.location.href="../foodType.php";
                })
            </script>';
    }
}
?>