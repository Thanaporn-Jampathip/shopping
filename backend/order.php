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
session_start();
include 'db.php';

if (isset($_POST['order'])) {
    // ตรวจสอบการรับข้อมูลจากฟอร์ม
    $customer = isset($_POST['customer']) ? (int)$_POST['customer'] : 0;
    $resid    = isset($_POST['restaurant']) ? (int)$_POST['restaurant'] : 0;

    // ตรวจสอบว่ามีการส่งข้อมูลที่ถูกต้อง
    if ($customer <= 0 || $resid <= 0) {
        echo "<script>
                Swal.fire({
                    title: 'ข้อมูลไม่ครบถ้วน',
                    icon: 'error'
                }).then(() => { window.location.href='../showCart.php'; });
              </script>";
        exit;
    }

    // เชื่อมต่อฐานข้อมูล
    // สร้างใบสั่งอาหาร (order header)
    $sqlOrder = "INSERT INTO foodorder (customer_id, restaurant_id, order_date)
                 VALUES (?, ?, NOW())";
    $stmtOrder = mysqli_prepare($conn, $sqlOrder);
    mysqli_stmt_bind_param($stmtOrder, "ii", $customer, $resid);

    if (mysqli_stmt_execute($stmtOrder)) {
        $orderId = mysqli_insert_id($conn); // ดึง ID ของใบสั่งซื้อที่เพิ่งเพิ่มเข้าไป

        // เพิ่มรายละเอียดทุกรายการอาหารในตะกร้า (fooddetail)
        if (!empty($_SESSION['cart'][$resid])) {
            $sqlDetail = "INSERT INTO orderdetail (foodOrder_id, foodMenu_id, qty) 
                          VALUES (?, ?, ?)";
            $stmtDetail = mysqli_prepare($conn, $sqlDetail);
            
            foreach ($_SESSION['cart'][$resid] as $foodId => $info) {
                $qty = (int)($info['qty'] ?? 0);
                if ($qty > 0) {
                    mysqli_stmt_bind_param($stmtDetail, "iii", $orderId, $foodId, $qty);
                    mysqli_stmt_execute($stmtDetail);
                }
            }
            mysqli_stmt_close($stmtDetail); // ปิด statement ของการบันทึกรายละเอียด
        }

        // ล้างตะกร้าของร้านนี้
        unset($_SESSION['cart'][$resid]);
        if (empty($_SESSION['cart'])) unset($_SESSION['cart']); // ถ้าตะกร้าทั้งหมดว่างให้ลบ session ออก

        // แจ้งผลลัพธ์การสั่งซื้อสำเร็จ
        echo "<script>
                Swal.fire({
                    title: 'สั่งอาหารเรียบร้อย',
                    icon: 'success',
                    timer: 1000,
                    didOpen: () => Swal.showLoading()
                }).then(() => { window.location.href='../showCart.php'; });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'เกิดข้อผิดพลาดในการสั่งซื้อ',
                    icon: 'error'
                }).then(() => { window.location.href='../showCart.php'; });
              </script>";
    }

    // ปิด statement ของใบสั่งซื้อ
    mysqli_stmt_close($stmtOrder);
}
?>
