<?php
$title = 'Xác nhận thanh toán';
require 'class/Database.php';
require 'class/Product.php';
require 'class/Cart.php';
require 'class/Bill.php';
require 'class/Pro_Bill.php';
require 'class/Category.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'thanhtoan') {
        if (isset($_SESSION['log_detail']) && isset($_GET['thanhtien'])) {
            $flag = false;
            $user = $_SESSION['log_detail'];
            $thanhtien = $_GET['thanhtien'];

            $bill = new Bill();
            $bill->username = $user;
            $bill->thanhtien = $thanhtien;
            //Thêm vào bảng Hóa đơn
            if ($bill->create($pdo)) {
                $flag = true;
            }

            //Thêm từng sản phẩm của giỏ hàng vào chi tiết hóa đơn
            $carts = Cart::getAll($pdo, $_SESSION['log_detail']); //Lấy tất cả sản phẩm của một user trong giỏ hàng
            $bill = Bill::getAll($pdo);

            foreach ($carts as $cart)
            {
                $pro_bill = new Pro_Bill(); // Tạo mới đối tượng Pro_Bill cho mỗi sản phẩm
                $pro_bill->masp = $cart->masp;
                $pro_bill->mahd = $bill->id;
                $pro_bill->soluong = $cart->soluong;
                if ($pro_bill->create($pdo, $pro_bill)) {
                    $flag = true;
                }
            }

            if($flag == true)
            {
                if (Cart::removeAll($pdo, $_SESSION['log_detail'])) {
                    header("Location: thongbao.php");
                    exit;
                }
            }

        }
    }
}

?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <h1 style="margin-left: 29%; margin-top: 10%; margin-bottom: 5%; color: #256D85;">Xác nhận đặt hàng thành công!</h1>
    <a href="index.php" style="margin-left: 80%; margin-bottom: 30%; font-size:20px;">Quay lại trang chủ</a>
</div>


<?php require 'inc/footer.php'; ?>