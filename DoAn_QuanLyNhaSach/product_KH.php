<?php
$title = 'Product page';
session_start();

if (!isset($_GET["id"])) {
    die("Cần cung cấp id sản phẩm !!!");
}

$id = $_GET["id"];

require 'class/Database.php';
require 'class/Product.php';
require 'class/Category.php';
require 'class/Cart.php';

$db = new Database();
$pdo = $db->getConnect();


$data_category = Category::getAllCategory($pdo);
$product = Product::getOneByID($pdo, $id);
$category = Category::getOneByIDCategory($pdo, $product->maloai);

?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <h2 style="margin-left: 500px; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Thông tin sản phẩm</h2>
    <div class="card mb-3" style="max-width: 1000px; margin-left: 150px;">
        <div class="row g-0">
            <div class="col-md-6">
                <img src="images/<?= $product->hinhanh?>" alt="" width="500">
            </div>
            <div class="col-md-6">
            <div class="card-body">
                <h4 class="card-title">Tên sách: <?= $product->tensach ?></h4>
                <p class="card-text"><h5>Mô tả: </h5> <?= $product->mota ?></p>
                <p class="card-text" style="color: red;">
                    <b>Giá: <?= number_format($product->gia, 0, ',', '.') ?> VNĐ</b>
                </p>
                <a href="index.php?action=addcart&proid=<?= $product->id ?>" class="btn btn-primary">Thêm vào giỏ hàng</a>
            </div>
            </div>
        </div>
    </div>
</div>

<?php require 'inc/footer.php'; ?>