<?php
$title = 'Cart page';
require 'class/Database.php';
require 'class/Product.php';
require 'class/Cart.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$data = Cart::getAll($pdo, $_SESSION['log_detail']);

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'empty') {
        if (Cart::removeAll($pdo, $_SESSION['log_detail'])) {
            header("Location: cart.php");
            exit;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update']) && isset($_POST['proid']) && isset($_POST['qty'])) {
        $product_id = $_POST['proid'];
        $new_qty = intval($_POST['qty']);
        $user = $_SESSION['log_detail'];

        $cart = new Cart();

        $cart->username = $user;
        $cart->masp = $cart_id;
        $cart->soluong = $new_qty;

        if ($cart->edit($pdo, $product_id)) {
            header('Location: cart.php');
            exit();
        }
    } 
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action == 'detele') {
        if (isset($_GET['proid'])) {
            $proid = $_GET['proid'];

            $cart = new Cart();

            if ($cart->remove($pdo, $proid)) {
                header("Location: cart.php");
                exit;
            }
        }
    }
}
?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <table class="table my-3">
        <a href="cart.php?action=empty" class="btn btn-danger mt-2">Empty Cart</a>
        <thead>
            <tr class="text-center">
                <th>STT</th>
                <th>Tên sách</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng tiền</th>
                <th></th>
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
                        <td>
                            <input type="number" value="<?= $qty->soluong ?>" name="qty" min="1" style="width: 50px;" />
                            <input type="hidden" name="proid" value="<?= $product->id ?>" />
                        </td>
                        <td><?= number_format($tong, 0, ',', '.') ?> VNĐ </td>
                        <td>
                            <button type="submit" class="btn btn-warning" name="update" value="<?= $cart->masp ?>">Update</button> 
                            <a href="cart.php?action=detele&proid=<?= $product->id ?>" class="btn btn-danger">Delete</a>
                        </td>
                        </form>
                    </tr>
            <?php 
                    $i++; 
                    $total += $product->gia * $qty->soluong;
                endforeach;
            endif; ?>
            <tr>
                <td colspan="6" class="text-center">
                    <h4>Total: <?= number_format($total, 0, ',', '.') ?> VNĐ</h4>
                    <a href="pay.php" class="btn btn-danger">Thanh toán</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<?php require 'inc/footer.php'; ?>