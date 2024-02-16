<?php
$title = 'Home page';
require 'class/Database.php';
require 'class/Product.php';
require 'class/Cart.php';
require 'class/Category.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$data = Product::getAll($pdo);
$data_category = Category::getAllCategory($pdo);

//Xử lý lọc sản phẩm theo danh mục loại
if (isset($_GET['action']) && isset($_GET['categoryid'])) {
    $action = $_GET['action'];
    $categoryid = $_GET['categoryid'];
    if ($action == 'showcategory') {
        $data = Product::getPro_Category($pdo, $categoryid);
    }
}

//Xử lý thêm vào giỏ hàng
if (isset($_GET['action']) && isset($_GET['proid']) && isset($_SESSION['log_detail'])) {
    $action = $_GET['action'];
    $proid = $_GET['proid'];
    $username = $_SESSION['log_detail'];
    if ($action == 'addcart') {
        $cart = new Cart();

        if ($cart->create($pdo, $proid, $username)) {
            header("Location: index.php");
            exit;
        }
    }
}

//Xử lý sắp xếp sản phẩm theo giá
if (isset($_GET['action']) && isset($_GET['sapxep_id'])) {
    $action = $_GET['action'];
    $sapxep_id = $_GET['sapxep_id'];
    if ($action == 'sapxep') {
        if($sapxep_id == 1)
        {
            $data = Product::getPro_SapXepTang($pdo);
        }
        else
        {
            $data = Product::getPro_SapXepGiam($pdo);
        }
    }
}

//Xử lý tìm kiếm
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ten = $_POST['search'];
    // var_dump($ten);
    $data = Product::findPro($pdo, $ten);
    // var_dump($data);
}

//Xử lý phân trang
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'getpage') {
        
        $product_per_page = 4; //số lượng sản phẩm
        $page = $_GET['page'] ?? 1; //đặt giá trị mặc định

        $total_products = Product::getCout_SP($pdo); // Lấy tổng số sản phẩm
        $total_pages = ceil($total_products['tongSL'] / $product_per_page); // Tính tổng số trang

        $limit = $product_per_page;
        $offset = ($page - 1) * $product_per_page; //tính giới hạn và vị trí bắt đầu của các sản phẩm

        $data = Product::getPage($pdo, $limit, $offset);
    }
}
?>

<?php require 'inc/header.php'; ?>

<div class="container">
<h2 style="margin-top: 10px; margin-bottom: 10px; color: #256D85;">Danh sách sản phẩm</h2>
<a class="btn btn-secondary mb-3" href="index.php?action=getpage">Phân trang</a> 
    <?php if(!isset($_SESSION['phanquyen'])): ?>
        <div class="row">
            <?php foreach ($data as $product): ?>
                <div class="col-3" style="margin-bottom: 15px;">
                    <div class="card text-center h-100" >

                        <a href="product_KH.php?id=<?= $product->id ?>" style="text-decoration: none;">
                            <img src="images/<?= $product->hinhanh ?>" class="card-img-top" alt="" style="width:200px; margin:0 auto;">
                        </a>  

                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="product_KH.php?id=<?= $product->id ?>" style="text-decoration: none;"><?= $product->tensach ?></a>  
                            </h5>

                            <p class="card-text" style="color: red; font-size: 18px;">
                                <b><?= number_format($product->gia, 0, ',', '.') ?> VNĐ </b>
                            </p>
                            <a href="index.php?action=addcart&proid=<?= $product->id ?>" class="btn btn-primary">Thêm vào giỏ hàng</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <a class="btn btn-secondary mb-3" href="customer.php">Quản lý khách hàng</a> 
        <a class="btn btn-secondary mb-3" href="bill.php">Quản lý hóa đơn</a> 
        <div class="row">
            <table class="table table-primary table-bordered">
                <thead class="table-dark">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th>Mã sách</th>
                            <th>Tên sách</th>
                            <th>Giá</th>
                            <th>Tác giả</th>
                            <th>Thể loại</th>
                            <th>Hình ảnh</th>
                            <th></th>
                        </tr>
                    </thead>
                </thead>
                <tbody>
                    <?php foreach ($data as $product): ?>
                        <tr>
                            <td class="text-center"> <?= $product->id ?> </td>
                            
                            <td style="width: 300px;">
                                <a href="product.php?id=<?= $product->id ?>" style="text-decoration: none; color: black;"> 
                                    <?= $product->tensach ?>
                                </a> 
                            </td>

                            <td class="text-center"> <?= number_format($product->gia, 0, ',', '.') ?> VNĐ</td>

                            <td style="width: 150px;"> <?= $product->tacgia ?> </td>

                            <td class="text-center"> <?= Category::getNameCategory($pdo, $product->maloai); ?> </td>

                            <td style="width: 200px;"> 
                                <div style="width:150px; margin:0 auto;">
                                    <img src="images/<?= $product->hinhanh ?>" class="card-img-top" alt="">
                                </div> 
                            </td>

                            <td colspan="2" style="padding-left: 3%; padding-top: 5%;">
                                <a class="btn btn-info" href="edit-product.php?id=<?= $product->id ?>" >Edit</a> 
                                <a class="btn btn-danger" href="delete-product.php?id=<?= $product->id ?>">Delete</a> 
                                <!-- </br> <a class="btn btn-info" href="product.php?id=<?= $product->id ?>" style="margin-top:10px; margin-left:10px;">Show Detail</a>  -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['action'])) {
            $action = $_GET['action'];
            if ($action == 'getpage') {
                // Hiển thị button 'Trang trước' khi không phải trang đầu tiên
                if ($page > 1) {
                    echo '<a class="btn btn-secondary mb-3" style=" margin-left: 0%; margin-right: 10px;" 
                        href="index.php?action=getpage&page='.($page-1).'">Trang trước</a>';
                }

                for ($i = 1; $i <= $total_pages; $i++) {
                    // Hiển thị link cho từng trang
                    echo '<a class="btn btn-light mb-3" style="margin-left: 0%;" 
                        href="index.php?action=getpage&page='.$i.'">'.$i.'</a> ';
                }
                
                // Hiển thị button 'Trang sau' khi không phải trang cuối cùng
                if ($page < $total_pages) {
                    echo '<a class="btn btn-secondary mb-3" style="margin-left: 7px;" 
                        href="index.php?action=getpage&page='.($page+1).'">Trang sau</a>';
                }
            }
    } ?>
    
</div>

<?php require 'inc/footer.php'; ?>
    