<?php
$title = 'New Product';
require 'class/Database.php';
require 'class/Product.php';
require 'class/Category.php';

session_start();

$error = '';

$name = '';
$desc = '';
$price = '';
$tacgia = '';
$loai = '';

$nameErrors = '';
$descErrors = '';
$priceErrors = '';
$tacgiaErrors = '';

$db = new Database();
$pdo = $db->getConnect();

$data = Category::getAllCategory($pdo);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $image = $_FILES['file'];
    $tacgia = $_POST['tacgia'];
    $loai = $_POST['loai'];

    if (empty($name)) {
        $nameErrors = 'Name is required';
    }

    if (empty($desc)) {
        $descErrors = 'Description is required';
    }

    if (empty($price)) {
        $priceErrors = 'Price is required';
    } elseif ($price % 1000 != 0) {
        $priceErrors = 'Price must be devisible by 1000.';
    }

    try {
        if (empty($_FILES['file'])) {
            throw new Exception('Invalid upload');
        }

        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                throw new Exception('No file uploaded.');
            default:
                throw new Exception('An error occured');
        }

        if ($_FILES['file']['size'] > 1000000) {
            throw new Exception('File too large.');
        }

        $mime_types = ['image/gif', 'image/jpeg', 'image/png'];
        $file_info = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($file_info, $_FILES['file']['tmp_name']);
        if (!in_array($mime_type, $mime_types)) {
            throw new Exception('Invalid file type.');
        }

        $pathinfo = pathinfo($_FILES['file']['name']);
        $fname = $image['name'];
        $extension = $pathinfo['extension'];

        $dest = 'images/' . $fname;

        // Write file
        if (move_uploaded_file($_FILES['file']['tmp_name'], $dest)) {
            //
        } else {
            throw new Exception('Unable to move file');
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    // No errors ???
    if (!$nameErrors && !$descErrors && !$priceErrors) {
        $db = new Database();
        $pdo = $db->getConnect();
        
        $product = new Product();
        $product->tensach = $name;
        $product->mota = $desc;
        $product->tacgia = $tacgia;
        $product->gia = $price;
        $product->hinhanh = $image['name'];
        $product->maloai = $loai;

        if ($product->create($pdo)) {
            header("Location: product.php?id={$product->id}");
            exit;
        }
    }

}
?>

<?php require 'inc/header.php'; ?>

<?php if (!$error) : ?>


<form method="post" class="w-50 m-auto" enctype="multipart/form-data">
    <h2 style="margin-left: 0%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Thêm sản phẩm mới</h2>
    <div class="mb-3">
        <label for="name" class="form-label"><h5>Tên sách (*)</h5></label>
        <input class="form-control" id="name" name="name" value="<?= $name ?>" /> <span class="text-danger fw-bold"><?= $nameErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="desc" class="form-label"><h5>Mô tả (*)</h5></label>
        <textarea class="form-control" id="desc" name="desc" rows="4"><?= $desc ?></textarea> <span class="text-danger fw-bold"><?= $descErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="tacgia" class="form-label"><h5>Tác giả (*)</h5></label>
        <textarea class="form-control" id="tacgia" name="tacgia" rows="4"><?= $tacgia ?></textarea> <span class="text-danger fw-bold"><?= $tacgiaErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label"><h5>Giá (*)</h5></label>
        <input class="form-control" id="price" name="price" type="number" value="<?= $price ?>" /> <span class="text-danger fw-bold"><?= $priceErrors ?></span>
    </div>
    <div class="mb-3">
        <label for="loai" class="form-label"><h5>Thể loại sách</h5></label> </br>
        <select class="form-select" name="loai">
            <?php foreach ($data as $category) : ?>

                    <option value="<?= $category->id ?>"> <?= $category->tenloai ?></option>
                    
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="file" class="form-label"><h5>File hình ảnh</h5></label>
        <input class="form-control" type="file" name="file" id="file"/>
    </div>

    <button type="submit" class="btn btn-primary" style="margin-left: 40%; margin-bottom: 10px;">Add new</button>
</form>

<?php else: ?>

<h2 class="text-center text-danger"><?= $error ?></h2>

<?php endif; ?>

<?php require 'inc/footer.php'; ?>