<?php
require 'class/Database.php';
require 'class/Bill.php';
require 'class/Pro_Bill.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$billid = $_GET["id"];
$bill = Bill::getOneByID_HoaDon($pdo, $billid);
$pro_bill = Pro_Bill::getByIDBill($pdo, $billid);

// Nếu đã nhận được thông tin cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flag = false;
    
    //Xóa trong bảng Chi tiết hóa đơn
    foreach ($pro_bill as $item) {
        if ($item->remove($pdo, $billid)) {
            $flag = true;
        }
    }

    //Xóa trong bảng Chi tiết hóa đơn
    if ($bill->remove($pdo, $billid)) {
        $flag = true;
    }
    if ($flag == true) {
        header("Location: bill.php");
        exit;
    }

}

// Hiển thị thông tin sản phẩm và xác nhận xoá
?>
<?php require 'inc/header.php'; ?>

<div class="container">
<h4 style="margin-left: 10%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">
    Xác nhận xoá hóa đơn của của UserName <span style="color: red;"> <?= $bill->username ?> </span> và được lập vào ngày  <span style="color: red;"> <?= $bill->ngaylaphd ?> </span> 
</h4>
<form method="post" class="w-50 m-auto">
    <button class="btn btn-success" type="submit">Yes</button>
    <a class="btn btn-success" href="customer.php"> Cancel </a> 
</form>
</div>