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
if(isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $tel = $_POST['tel'];
    $address = $_POST['address'];
    $discount = $_POST['discount'];
    $minimum_price = $_POST['minimum_price'];
    $resType = $_POST['resType'];

    $sql = "UPDATE restaurant SET name='$name', tel='$tel', address='$address', discount='$discount', minimum_price='$minimum_price', restaurantType_id='$resType' WHERE id='$id'";
    $query = mysqli_query($conn, $sql);
    if($query) {
        echo '<script>
            Swal.fire({
            title: "แก้ไขสำเร็จ",
            icon: "success",
            confirmButtonText: "ปิด",
            draggable: true
            }).then(() =>{
                window.location.href="../manage_restaurant.php";
            })
        </script>';
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "แก้ไขไม่สำเร็จ",
                    icon: "error",
                    confirmButtonText: "ปิด",
                    draggable: true
                }).then(() => {
                    window.location.href = "../manage_restaurant.php";
                });
            </script>';
    }
}
?>