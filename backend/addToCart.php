<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ตรวจสอบว่า $_SESSION['food'] เป็น array หรือไม่
    if (!isset($_SESSION['food'])) {
        $_SESSION['food'] = [];
    }
    $food = $_POST['food'];

    if(!isset($_SESSION['resid'])){
        $_SESSION['resid'] = [];
    }
    $resid = $_POST['resid'];

    $customer = $_POST['customer'];
    $_SESSION['customer'] = $customer;

    $_SESSION['resid'][] = $resid;

    // เพิ่มอาหารใหม่ลงในตะกร้า
    $_SESSION['food'][] = $food;

    // ตรวจสอบว่าอาหารที่เพิ่มเข้ามามีในตะกร้าแล้วหรือยัง
    $foodInCart = implode(',', $_SESSION['food']);
    $resid = implode(',', $_SESSION['resid']);
    echo json_encode([
        'resid' => $resid,
        'foodInCart' => $foodInCart
    ]);
}
?>
