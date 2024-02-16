<?php
require 'class/Database.php';
require 'class/Customer.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$user = $_GET["user"];
$cus = Customer::getOneByID($pdo, $user);
       
// Nếu đã nhận được thông tin cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($cus->remove($pdo, $user)) {
        header("Location: customer.php");
        exit;
    }
}

// Hiển thị thông tin sản phẩm và xác nhận xoá
?>
<?php require 'inc/header.php'; ?>

<div class="container">
<h4 style="margin-left: 10%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">
    Xác nhận xoá khách hàng có UserName là <span style="color: red;"> <?= $cus->username ?> </span> 
</h4>
<form method="post" class="w-50 m-auto">
    <button class="btn btn-success" type="submit">Yes</button>
    <a class="btn btn-success" href="customer.php"> Cancel </a> 
</form>
</div>