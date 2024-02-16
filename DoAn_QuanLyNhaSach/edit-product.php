<?php
$title = 'New Product';
require 'class/Database.php';
require 'class/Product.php';
require 'class/Category.php';

session_start();

// $error = Auth::requireLogin();
if (!isset($_GET["id"])) {
    die("Cần cung cấp id sản phẩm !!!");
}

$id = $_GET["id"];
$db = new Database();
$pdo = $db->getConnect();

$product = Product::getOneByID($pdo, $id);
$data = Category::getAllCategory($pdo);
$category = Category::getOneByIDCategory($pdo, $product->maloai);

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $tacgia = $_POST['tacgia'];
    $loai = $_POST['loai'];

    $product->tensach = $name;
    $product->mota = $desc;
    $product->tacgia = $tacgia;
    $product->gia = $price;
    $product->maloai = $loai;

    if ($product->edit($pdo, $id)) {
        header("Location: product.php?id={$product->id}");
        exit;
    }

}
?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <form method="post" class="w-50 m-auto">
    <h2 style="margin-left: 0%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">
        Chỉnh sửa sản phẩm <?= $product->tensach ?> 
    </h2>
    <div class="mb-3">
            <label for="name" class="form-label"><h5>Tên sách</h5></label>
            <input class="form-control" id="name" name="name" value="<?= $product->tensach ?>" /> 
        </div>
        <div class="mb-3">
            <label for="desc" class="form-label"><h5>Mô tả</h5></label>
            <textarea class="form-control" id="desc" name="desc" rows="4"><?= $product->mota ?></textarea>
        </div>
        <div class="mb-3">
            <label for="tacgia" class="form-label"><h5>Tác giả</h5></label>
            <input class="form-control" id="tacgia" name="tacgia" value="<?= $product->tacgia ?>" />
        </div>
        <div class="mb-3">
            <label for="price" class="form-label"><h5>Giá</h5></label>
            <input class="form-control" id="price" name="price" type="number" value="<?= $product->gia ?>" />
        </div>
        <div class="mb-3">
            <label for="loai" class="form-label"><h5>Thể loại sách</h5></label> </br>
            <select class="form-select" name="loai">
            <?php foreach ($data as $category) : 
                if($product->maloai == $category->id): ?>
                    <option value="<?= $category->id ?>" selected> <?= $category->tenloai ?> </option>
                <?php else: ?>
                    <option value="<?= $category->id ?>"> <?= $category->tenloai ?> </option>
                <?php endif; ?>
            <?php endforeach; ?>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary" style="margin-left: 40%;">Submit</button>
    </form>
</div>

<?php require 'inc/footer.php'; ?>