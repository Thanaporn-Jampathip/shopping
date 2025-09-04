<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>เข้าสู่ระบบ</title>
    <style>
        body {
            background: linear-gradient(to right, #56ccf2, #2f80ed); /* ไล่สีจากฟ้าไปฟ้าเข้ม */
            height: 100vh;
            margin: 0;
        }
        .card {
            border-radius: 10px;
            min-width: 400px;
            max-width: 600px;
            max-width: 100%;
            margin: auto;
        }
        .container {
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center">
        <form action="./backend/loginAction.php" method="post">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center fs-4 mb-4">
                        เข้าสู่ระบบ
                    </div>
                    <div class="mb-3">
                        <label for="username" class="mb-1">ชื่อผู้ใช้</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="mb-1">รหัสผ่าน</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button class="btn btn-sm btn-primary w-100" type="submit">เข้าสู่ระบบ</button>
                    <div class="mt-1">
                        <a href="register.php" >สมัครสมาชิก</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
