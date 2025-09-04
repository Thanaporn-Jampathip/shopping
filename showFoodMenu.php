<?php
include './backend/db.php';
session_start();

$userType   = isset($_SESSION['userType']) ? $_SESSION['userType'] : null;
$userid     = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
$statusUser = isset($_SESSION['status']) ? $_SESSION['status'] : null;

// --- รับค่า GET อย่างปลอดภัย ---
$foodType = isset($_GET['foodTypeId']) ? intval($_GET['foodTypeId']) : 0;
$resid    = isset($_GET['resid']) ? intval($_GET['resid']) : 0;

if ($foodType && $resid) {
    // --- ควรใช้ prepared statement ในโปรดักชัน ที่นี่ขอย่อด้วย intval ---
    $sqlFoodMenu = "
        SELECT foodmenu.id, foodmenu.name, foodmenu.price, foodmenu.image, foodtype.name AS foodTypeName
        FROM foodmenu
        JOIN foodtype ON foodmenu.foodType_id = foodtype.id
        WHERE foodmenu.foodType_id = $foodType
    ";
    $queryFoodMenu = mysqli_query($conn, $sqlFoodMenu);

    $sqlFoodType = "SELECT foodtype.name FROM foodtype WHERE foodtype.id = $foodType";
    $queryFoodType = mysqli_query($conn, $sqlFoodType);
    $rowFoodType = mysqli_fetch_assoc($queryFoodType);

    $sqlRes = "
        SELECT restaurant.id, restaurant.name, restauranttype.name AS resType
        FROM restaurant
        JOIN restauranttype ON restaurant.restaurantType_id = restauranttype.id
        WHERE restaurant.id = $resid
    ";
    $queryRes = mysqli_query($conn, $sqlRes);
    $rowRes = mysqli_fetch_assoc($queryRes);
}

// โครงสร้างตะกร้า: แยกตามร้าน เพื่อกันชนกันระหว่างหลายร้าน
if (!isset($_SESSION['cart'][$resid])) {
    $_SESSION['cart'][$resid] = []; // cart ต่อร้าน
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foodId   = isset($_POST['food']) ? intval($_POST['food']) : 0;
    $customer = isset($_POST['customer']) ? intval($_POST['customer']) : 0;
    $residPost= isset($_POST['resid']) ? intval($_POST['resid']) : 0;

    if ($residPost !== $resid) {
        // กันกรณีโพสต์ข้ามร้าน/ข้ามหน้า (กรณีผู้ใช้เปิดหลายแท็บ)
        $resid = $residPost;
        if (!isset($_SESSION['cart'][$resid])) {
            $_SESSION['cart'][$resid] = [];
        }
    }

    if ($foodId > 0) {
        if (!isset($_SESSION['cart'][$resid][$foodId])) {
            $_SESSION['cart'][$resid][$foodId] = [
                'qty'      => 0,
                'customer' => $customer,
                'resid'    => $resid
            ];
        }

        // เพิ่มจำนวน
        if (isset($_POST['increase'])) {
            $_SESSION['cart'][$resid][$foodId]['qty']++;
        }

        // ลดจำนวน (ไม่ให้ติดลบ)
        if (isset($_POST['decrease'])) {
            if ($_SESSION['cart'][$resid][$foodId]['qty'] > 0) {
                $_SESSION['cart'][$resid][$foodId]['qty']--;
            }
        }

        // ปุ่มเพิ่มลงตะกร้า (กรณีส่งแบบไม่ใช่ AJAX)
        if (isset($_POST['addToCart'])) {
            $_SESSION['cart'][$resid][$foodId]['qty']++;
        }
    }

    // PRG: ลดปัญหา F5 แล้วยิงซ้ำ
    $redirect = "showFoodMenu.php?foodTypeId={$foodType}&resid={$resid}";
    header("Location: $redirect");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>รายการอาหาร</title>
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    height: 100vh;
    margin: 0;
}
    </style>
</head>
<body>
<?php include './component/navbar.php'; ?>
<div class="container mt-5">
    <a href="showFoodType.php?resid=<?php echo $resid; ?>" class="btn btn-danger btn-sm mb-3">ย้อนกลับ</a>
    <h4><b><?php echo htmlspecialchars($rowRes['name'] ?? '-'); ?></b></h4>
    <h5><b>ร้านอาหารประเภท:</b> <?php echo htmlspecialchars($rowRes['resType'] ?? '-'); ?></h5>
    <h5><b>ประเภทอาหาร:</b> <?php echo htmlspecialchars($rowFoodType['name'] ?? '-'); ?></h5>
    <hr>
    <h4 class="text-center mb-3">รายการอาหาร</h4>

    <div class="table-responsive">
        <table class="table table-light shadow">
            <tr class="table table-dark">
                <th>รูปอาหาร</th>
                <th>ชื่ออาหาร</th>
                <th>ราคาอาหาร</th>
                <th>จำนวน</th>
                <?php if ($userType == '4') { ?>
                    <th></th>
                <?php } ?>
            </tr>

            <?php while ($rowFoodMenu = mysqli_fetch_assoc($queryFoodMenu)) {
                $foodId = (int)$rowFoodMenu['id'];
                // ดึงจำนวนจาก session (ตามร้าน + เมนู) ถ้าไม่มีให้เป็น 0
                $qty = isset($_SESSION['cart'][$resid][$foodId]['qty']) ? (int)$_SESSION['cart'][$resid][$foodId]['qty'] : 0;
            ?>
                <tr>
                    <td>
                        <img src="<?php echo htmlspecialchars($rowFoodMenu['image']); ?>"
                             alt="<?php echo htmlspecialchars($rowFoodMenu['name']); ?>"
                             class="img-fluid" style="max-width:100px;">
                    </td>
                    <td><?php echo htmlspecialchars($rowFoodMenu['name']); ?></td>
                    <td><?php echo number_format($rowFoodMenu['price'], 2); ?></td>

                    <td>
                        <form method="post" style="display:flex;align-items:center;gap:5px;">
                            <input type="hidden" name="food" value="<?php echo $foodId; ?>">
                            <input type="hidden" name="customer" value="<?php echo (int)$userid; ?>">
                            <input type="hidden" name="resid" value="<?php echo $resid; ?>">

                            <button type="submit" name="decrease" class="btn btn-danger btn-sm" <?php echo $qty<=0?'disabled':''; ?>>-</button>
                            <input type="text" value="<?php echo $qty; ?>" readonly
                                   class="form-control form-control-sm text-center" style="width:60px;">
                            <button type="submit" name="increase" class="btn btn-success btn-sm">+</button>
                        </form>
                    </td>

                    <?php if ($userType == '4') { ?>
                        <td>
                            <!-- เปลี่ยน id ซ้ำ เป็น class -->
                            <form class="addToCart" method="post">
                                <input type="hidden" name="food" value="<?php echo $foodId; ?>">
                                <input type="hidden" name="customer" value="<?php echo (int)$userid; ?>">
                                <input type="hidden" name="resid" value="<?php echo $resid; ?>">
                                <button class="btn btn-primary btn-sm w-100" type="submit" name="addToCart">เพิ่มลงตระกร้า</button>
                            </form>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ใช้ event delegation เพราะมีหลายฟอร์ม และ class เดียวกัน
$(document).on('submit', 'form.addToCart', function (e) {
    e.preventDefault();
    const $form = $(this);

    $.ajax({
        url: './backend/addToCart.php',
        method: 'POST',
        data: $form.serialize(),
        // ควรกำหนดให้ backend ส่ง JSON กลับมา เช่น { "ok": true }
        // แล้วเปิดใช้งานบรรทัดด้านล่าง:
        // dataType: 'json',
        success: function (resp) {
            // ถ้า backend ยังส่งเป็นข้อความธรรมดาอยู่ ให้เช็คแบบ truthy ไปก่อน
            if (resp) {
                Swal.fire({
                    title: "เพิ่มลงตระกร้าเรียบร้อย",
                    icon: "success",
                    timer: 1000,
                    didOpen: () => Swal.showLoading()
                });
            } else {
                Swal.fire({
                    title: "เกิดข้อผิดพลาด",
                    icon: "error",
                    timer: 1000,
                    didOpen: () => Swal.showLoading()
                });
            }
        },
        error: function () {
            Swal.fire({
                title: "เชื่อมต่อเซิร์ฟเวอร์ไม่ได้",
                icon: "error"
            });
        }
    });
});
</script>
</body>
</html>
