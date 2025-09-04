<?php
session_start();
include './backend/db.php';

$userType   = $_SESSION['userType'] ?? null;
$userid     = $_SESSION['userid'] ?? null;
$statusUser = $_SESSION['status'] ?? null;

    $cart = $_SESSION['cart'] ?? []; // โครงสร้าง: cart[resid][foodId]['qty']

    // สร้างรายการ id เมนู และ mapping ต่างๆ
    $foodIds = [];
    $qtyMap = [];        // [foodId] => qty
    $foodResidMap = [];  // [foodId] => resid
    $resIds = [];        // resid ที่มีของอยู่

    foreach ($cart as $resid => $foods) {
        foreach ($foods as $foodId => $info) {
            $qty = (int)($info['qty'] ?? 0);
            if ($qty > 0) {
                $foodIds[] = (int)$foodId;
                $qtyMap[$foodId] = $qty;
                $foodResidMap[$foodId] = (int)$resid;
                $resIds[(int)$resid] = true;
            }
        }
    }

    $foodRows = [];
    $resMap = []; // [resid] => restaurant name

    if (!empty($foodIds)) {
        $foodIdsSql = join(',', array_map('intval', $foodIds));
        $sqlFood = "SELECT f.id, f.name, f.price, f.image, t.name AS foodTypeName
                    FROM foodmenu f
                    JOIN foodtype t ON f.foodType_id = t.id
                    WHERE f.id IN ($foodIdsSql)";
        $queryFood = mysqli_query($conn, $sqlFood);
        while ($r = mysqli_fetch_assoc($queryFood)) {
            $foodRows[] = $r;
        }
    }

    if (!empty($resIds)) {
        $resIdsSql = join(',', array_keys($resIds));
        $sqlRes = "SELECT id, name FROM restaurant WHERE id IN ($resIdsSql)";
        $queryRes = mysqli_query($conn, $sqlRes);
        while ($r = mysqli_fetch_assoc($queryRes)) {
            $resMap[(int)$r['id']] = $r['name'];
        }
    }

    // ลบสินค้า (ลบทั้งเมนูออกจากตะกร้า ไม่ใช่แค่ลดจำนวน)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
        $foodId = (int)($_POST['foodId'] ?? 0);
        $resid  = (int)($_POST['resid'] ?? 0);
        if (isset($_SESSION['cart'][$resid][$foodId])) {
            unset($_SESSION['cart'][$resid][$foodId]);
            // ถ้าร้านนั้นไม่มีรายการแล้ว ลบทิ้ง
            if (empty($_SESSION['cart'][$resid])) {
                unset($_SESSION['cart'][$resid]);
            }
        }
        // ป้องกันกด F5 ยิงซ้ำ
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>ตะกร้าสินค้า</title>
</head>
<body>
<?php include 'component/navbar.php'; ?>

<div class="container mt-5">
    <h2>ตะกร้าสินค้า</h2>

    <?php if (empty($foodRows)) { ?>
        <div class="text-center mt-4">
            <p>ไม่มีสินค้าในตะกร้า</p>
        </div>
    <?php } else { ?>
        <div class="table-responsive">
            <table class="table mt-3 table-light shadow">
                <tr class="table table-dark">
                    <th>รูปอาหาร</th>
                    <th>ชื่ออาหาร</th>
                    <th>ประเภทอาหาร</th>
                    <th>ร้าน</th>
                    <th class="text-end">ราคา</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-end">รวม</th>
                    <th>การจัดการ</th>
                </tr>
                <?php
                $grandTotal = 0;
                foreach ($foodRows as $rowFood) {
                    $fid   = (int)$rowFood['id'];
                    $qty   = (int)($qtyMap[$fid] ?? 0);
                    $resid = (int)($foodResidMap[$fid] ?? 0);
                    $resName = $resMap[$resid] ?? '-';
                    $price = (float)$rowFood['price'];
                    $lineTotal = $price * $qty;
                    $grandTotal += $lineTotal;
                ?>
                    <tr>
                        <td><img src="<?php echo htmlspecialchars($rowFood['image']); ?>" alt="<?php echo htmlspecialchars($rowFood['name']); ?>" class="img-fluid" style="max-width: 100px;"></td>
                        <td><?php echo htmlspecialchars($rowFood['name']); ?></td>
                        <td><?php echo htmlspecialchars($rowFood['foodTypeName']); ?></td>
                        <td><?php echo htmlspecialchars($resName); ?></td>
                        <td class="text-end"><?php echo number_format($price, 2); ?></td>
                        <td class="text-center"><?php echo $qty; ?></td>
                        <td class="text-end"><?php echo number_format($lineTotal, 2); ?></td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="foodId" value="<?php echo $fid; ?>">
                                <input type="hidden" name="resid" value="<?php echo $resid; ?>">
                                <button class="btn btn-danger btn-sm w-100" name="delete">ลบ</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th colspan="6" class="text-end">ยอดรวมทั้งหมด</th>
                    <th class="text-end"><?php echo number_format($grandTotal, 2); ?></th>
                    <th>
                        <form action="./backend/order.php" method="post">
                            <input type="hidden" name="customer" value="<?php echo $userid ?>">
                            <input type="hidden" name="restaurant" value="<?php echo $resid ?>">
                            <button class="btn btn-success btn-sm w-100" type="submit" name="order">สั่ง</button>
                        </form>
                    </th>
                </tr>
            </table>
        </div>
    <?php } ?>
</div>
</body>
</html>
