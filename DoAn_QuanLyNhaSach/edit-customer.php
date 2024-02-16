<?php
$title = 'New Product';
require 'class/Database.php';
require 'class/Customer.php';

session_start();

$user = $_GET["user"];
$db = new Database();
$pdo = $db->getConnect();

$cus = Customer::getOneByID($pdo, $user);

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $hoten = $_POST['hoten'];
    $sdt = $_POST['sdt'];
    $diachi = $_POST['diachi'];

    $cus->hoten = $hoten;
    $cus->sdt = $sdt;
    $cus->diachi = $diachi;

    if ($cus->edit($pdo, $user)) {
        header("Location: customer.php");
        exit;
    }

}
?>

<?php require 'inc/header.php'; ?>
<div class="container">
    <form method="post" class="w-50 m-auto">
    <h2 style="margin-left: 0%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">
        Chỉnh sửa khách hàng có UserName là <?= $cus->username ?> 
    </h2>
    <div class="mb-3">
            <label for="hoten" class="form-label"><h5>Họ tên</h5></label>
            <input class="form-control" id="hoten" name="hoten" value="<?= $cus->hoten ?>" /> 
        </div>
        <div class="mb-3">
            <label for="sdt" class="form-label"><h5>Số điện thoại</h5></label>
            <textarea class="form-control" id="sdt" name="sdt" rows="4"><?= $cus->sdt ?></textarea>
        </div>
        <div class="mb-3">
            <label for="diachi" class="form-label"><h5>Địa chỉ</h5></label>
            <input class="form-control" id="diachi" name="diachi" value="<?= $cus->diachi ?>" />
        </div>
        
        <button type="submit" class="btn btn-primary" style="margin-left: 40%;">Submit</button>
    </form>
</div>

<?php require 'inc/footer.php'; ?>