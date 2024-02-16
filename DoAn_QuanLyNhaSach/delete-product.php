<?php
require 'class/Database.php';
require 'class/Product.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$id = $_GET['id'];
$product = Product::getOneByID($pdo, $id);
       
// Nếu đã nhận được thông tin cập nhật sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($product->remove($pdo, $id)) {
        header("Location: index.php?id={$product->id}");
        exit;
    }
}

// Hiển thị thông tin sản phẩm và xác nhận xoá
?>
<?php require 'inc/header.php'; ?>

<div class="container">
<h4 style="margin-left: 10%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">
    Xác nhận xoá sản phẩm <span style="color: red;"> <?= $product->tensach ?> </span> 
</h4>
<form method="post" class="w-50 m-auto">
    <button class="btn btn-success" type="submit">Yes</button>
    <a class="btn btn-success" href="product.php?id=<?= $product->id?>"> Cancel </a> 
</form>
</div>