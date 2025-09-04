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
    $price = $_POST['price'];
    $foodtype = $_POST['foodType'];

    $sqlEdit = "UPDATE foodmenu SET name = '$name', price = $price, foodtype_id = $foodtype WHERE id = $id";
    $queryEdit = mysqli_query($conn, $sqlEdit);
    if($queryEdit){
        echo '<script>
            Swal.fire({
            title: "แก้ไขข้อมูลสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="../food.php";
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
                window.location.href="../food.php";
            })
        </script>';
    }
}
?>