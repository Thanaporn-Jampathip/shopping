<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #56ccf2); /* ไล่สีจากขาวไปฟ้า */
    margin: 0;
}
        a{
            text-decoration: none;
            color: red;
        }
        a:hover{
            color: #CA4242;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow">
        <div class="container-fluid">
            <a class="navbar-brand px-5" href="index.php">Lazapee</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    // สมาชิก
                    if($userType == '4'){
                        include './component/menu/member.php';
                    }
                    // แอดมิน
                    elseif($userType == '1'){
                        include './component/menu/admin.php';
                    }
                    // ร้านอาหาร
                    elseif($userType == '2'){
                        include './component/menu/restaurant.php';
                    }
                    // ไรเดอร์
                    elseif($userType == '3'){
                        include './component/menu/rider.php';
                    }
                    ?>
                </ul>
                <div class="me-3">
                    <a href="./backend/logout.php" class="btn btn-danger btn-sm">ออกจากระบบ</a>
                </div>
            </div>
        </div>
    </nav>
</body>

</html>