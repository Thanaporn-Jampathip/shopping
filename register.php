<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>สมัครเข้าใช้งาน</title>
    <style>
        body {
            background: linear-gradient(to right, #56ccf2, #2f80ed); /* ไล่สีจากฟ้าไปฟ้าเข้ม */
            height: 100vh;
            margin: 0;
        }
        .card{
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <form action="./backend/registerAction.php" method="post">
            <div class="card shadow">
                <div class="card-body m-3">
                    <div class="text-center fs-4 mb-2">
                        สมัครเข้าใช้งาน
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col">
                                <label for="" class="mb-1">ชื่อผู้ใช้</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="" class="mb-1">รหัสผ่าน</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="mb-1">ชื่อจริง</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="" class="mb-1">นามสกุล</label>
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="mb-3">
                                <label for="" class="mb-1">อีเมลล์</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="" class="mb-1">เบอร์โทรศัพท์</label>
                                <input type="text" name="tel" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-1">ที่อยู่</label>
                        <textarea name="address" rows="3" id="" class="form-control" required></textarea>
                    </div>
                    <label for="" class="mb-1">สถานะผู้ใช้</label>
                    <select name="userType" class="form-select mb-3" required>
                        <option value="" selected disabled>-- เลือก --</option>
                        <option value="4">สมาชิก</option>
                        <option value="2">ร้านอาหาร</option>
                        <option value="3">ไรเดอร์</option>
                    </select>
                    <!-- btn register -->
                    <button class="btn btn-sm btn-primary w-100" type="submit">สมัครสมาชิก</button>
                    <div class="mt-1">
                        <a href="login.php">มีบัญชีอยู่แล้ว</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
</script>