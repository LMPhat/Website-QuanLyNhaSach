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

$db = new Database();
$pdo = $db->getConnect();


$data_category = Category::getAllCategory($pdo);
$product = Product::getOneByID($pdo, $id);
$category = Category::getOneByIDCategory($pdo, $product->maloai);

?>

<?php require 'inc/header.php'; ?>


<div class="container">
    <h2 style="margin-left: 500px; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Thông tin sản phẩm</h2>
    <table class="table table-primary">
        <tr>
            <td class="table-dark" style="width: 10%">Mã sản phẩm</td>
            <td><?= $product->id ?></td>
        </tr>
        <tr>
            <td class="table-dark">Tên sản phẩm</td>
            <td><?= $product->tensach ?></td>
        </tr>
        <tr>
            <td class="table-dark">Mô tả</td>
            <td><?= $product->mota ?></td>
        </tr>
        <tr>
            <td class="table-dark">Giá</td>
            <td><?= number_format($product->gia, 0, ',', '.') ?> VNĐ</td>
        </tr>
        <tr>
            <td class="table-dark">Thể loại</td>
            <td><?= $category->tenloai ?></td>
        </tr>
        <tr>
            <td class="table-dark">Hình ảnh</td>
            <td><img src="images/<?= $product->hinhanh?>" alt="" width="100px"></td>
        </tr>

        <tr>
            <td colspan="2" style="padding-left: 10%">
                <a class="btn btn-info" href="edit-product.php?id=<?= $product->id ?>">Edit</a> 
                <a class="btn btn-danger" href="delete-product.php?id=<?= $product->id ?>">Delete</a> 
            </td>
        </tr>
        <!-- <?php if ($_SESSION['phanquyen'] == 'admin'): ?>
        
        <?php endif; ?> -->

    </table>
</div>

<?php require 'inc/footer.php'; ?>