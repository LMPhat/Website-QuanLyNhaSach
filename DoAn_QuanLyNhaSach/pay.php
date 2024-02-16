<?php
$title = 'Pay page';
require 'class/Database.php';
require 'class/Product.php';
require 'class/Cart.php';
require 'class/Customer.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$data = Cart::getAll($pdo, $_SESSION['log_detail']);

$cus = Customer::getOneByID($pdo, $_SESSION['log_detail']);

?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-3">
            <h4 style="margin-left: 30px; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Thông tin khách hàng</h4>
            <table class="table my-3 table-bordered">
                <tr style="width: 100px">
                    <td class="table-light" style="width: 100px">Tên khách hàng</td>
                    <td style="width: 100px"><?= $cus->hoten ?></td>
                </tr>
                <tr style="width: 100px">
                    <td class="table-light">Số điện thoại</td>
                    <td style="width: 100px"><?= $cus->sdt ?></td>
                </tr>
                <tr style="width: 100px">
                    <td class="table-light">Địa chỉ</td>
                    <td style="width: 100px"><?= $cus->diachi ?></td>
                </tr>
                
            </table>
        </div>
        <div class="col-9">
        <h4 style="margin-left: 40%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Thông tin đơn hàng</h4>
            <table class="table my-3 table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>STT</th>
                        <th>Tên sách</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($_SESSION['log_detail'])):
                        $i = 1; $total = 0; 
                        foreach ($data as $cart) : 
                            $tong = 0;
                            $product = Product::getOneByID($pdo, $cart->masp);
                            $qty = Cart::getOneByID($pdo, $cart->masp);
                            $tong += $product->gia * $qty->soluong;
                    ?>
                            <tr class="text-center">
                                <form method="post">
                                    <td><?= $i ?></td>
                                    <td><?= $product->tensach ?></td>
                                    <td><?= number_format($product->gia, 0, ',', '.') ?> VNĐ</td>
                                    <td><?= $qty->soluong ?></td>
                                    <td><?= number_format($tong, 0, ',', '.') ?> VNĐ </td>
                                </form>
                            </tr>
                    <?php 
                            $i++; 
                            $total += $product->gia * $qty->soluong;
                        endforeach;
                    endif; ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            <h4>Total: <?= number_format($total, 0, ',', '.') ?> VNĐ</h4>
                            <a href="thongbao.php?action=thanhtoan&thanhtien=<?= $total ?>" class="btn btn-danger">Thanh toán</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php require 'inc/footer.php'; ?>