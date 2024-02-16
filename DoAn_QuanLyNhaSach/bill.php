<?php
$title = 'Bill page';
require 'class/Database.php';
require 'class/Customer.php';
require 'class/Product.php';
require 'class/Bill.php';
require 'class/Pro_Bill.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$customers = Customer::getALL($pdo);
$products = Product::getALL($pdo);
$bills = Bill::getALL_Bill($pdo);


?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <h2 style="margin-left: 35%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Danh sách hóa đơn</h2>
    <table class="table table-primary table-bordered">
        <thead class="table-dark">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>STT</th>
                    <th>Tên khách hàng</th>
                    <th>Ngày lập</th>
                    <th>Chi tiết hóa đơn</th>
                    <th>Tổng tiền</th>
                    <th></th>
                </tr>
            </thead>
        </thead>
        <tbody>
            <?php $i=1; $tongTT=0; foreach ($bills as $bill):
                    $pro_bills = Pro_Bill::getAllPro_Bill($pdo, $bill->id);
                    $customer = Customer::getOneByID($pdo, $bill->username);
                    $sl = Pro_Bill::getSum_HoaDon($pdo, $bill->id);
                    $tongTT += $bill->thanhtien;
                ?>
                <tr>
                    <td class="text-center"> <?= $i ?> </td>
                    
                    <td>
                        <?= $customer->hoten ?>
                    </td>

                    <td class="text-center"> <?= $bill->ngaylaphd ?> </td>

                    <td class="text-center">
                        <table class="table table-hover">
                            <tr>
                                <th>Mã SP</th>
                                <th>Tên SP</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Tổng tiền</th>
                            </tr>

                            <?php foreach ($pro_bills as $pro_bill): 
                                    $tong = 0;
                                    $pro = Product::getOneByID($pdo, $pro_bill->masp);
                                    $tong += $pro->gia * $pro_bill->soluong;
                            ?>
                                <tr>
                                    <td><?= $pro_bill->masp ?></td>
                                    <td style="width: 25%;"><?= $pro->tensach ?></td>
                                    <td><?= $pro_bill->soluong ?></td>
                                    <td style="width: 20%;"><?= number_format($pro->gia, 0, ',', '.') ?> VNĐ</td>
                                    <td style="width: 25%;"><?= number_format($tong, 0, ',', '.') ?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        
                    </td>

                    <td class="text-center"><?= number_format($bill->thanhtien, 0, ',', '.') ?> VNĐ</td>

                    <td colspan="2" style="padding-left: 1%; padding-top: 1%;">
                        <a class="btn btn-danger" href="delete-bill.php?id=<?= $bill->id ?>">Delete</a> 
                    </td>
                </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
    <h4 style="float:right; margin-top: 10px; margin-bottom: 30px; color: #256D85;">
        Tổng thành tiền: <?= number_format($tongTT, 0, ',', '.') ?> VNĐ
    </h4>
</div>


<?php require 'inc/footer.php'; ?>

<!-- <div class="nav navbar">
                        
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle text-dark" id="a" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
                                        <span><?= $sl['soluong'] ?></span>
                                    </a>
                                    <div style="position:relative;" class="dropdown-menu collapse list-unstyled" aria-labelledby="a">
                                        <table class="table table-hover">
                                            <tr>
                                                <th>Mã SP</th>
                                                <th>Tên SP</th>
                                                <th>Số lượng</th>
                                                <th>Tổng tiền</th>
                                            </tr>

                                            <?php foreach ($pro_bills as $pro_bill): 
                                                    $tong = 0;
                                                    $pro = Product::getOneByID($pdo, $pro_bill->masp);
                                                    $tong += $pro->gia * $pro_bill->soluong;
                                            ?>
                                                <tr>
                                                    <td><?= $pro_bill->masp ?></td>
                                                    <td><?= $pro->$tensach ?></td>
                                                    <td><?= $pro_bill->soluong ?></td>
                                                    <td><?= $tong ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            
                        </div> -->