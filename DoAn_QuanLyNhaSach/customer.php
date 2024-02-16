<?php
$title = 'Customer page';
require 'class/Database.php';
require 'class/Customer.php';

session_start();

$db = new Database();
$pdo = $db->getConnect();

$data = Customer::getALL($pdo);

?>

<?php require 'inc/header.php'; ?>

<div class="container">
    <h2 style="margin-left: 35%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">Danh sách khách hàng</h2>
    <a class="btn btn-secondary mb-3" href="register.php">Add new</a>
    <table class="table table-primary table-bordered">
        <thead class="table-dark">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>STT</th>
                    <th style="width: 160px;">Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>UserName</th>
                    <th style="width: 200px;">Password</th>
                    <th></th>
                </tr>
            </thead>
        </thead>
        <tbody>
            <?php $i=1; foreach ($data as $cus): ?>
                <tr>
                    <td class="text-center"> <?= $i ?> </td>
                    
                    <td>
                        <?= $cus->hoten ?>
                    </td>

                    <td class="text-center"> <?= $cus->sdt ?> </td>

                    <td class="text-center"> <?= $cus->diachi ?> </td>

                    <td> <?= $cus->username ?> </td>

                    <td> <?= $cus->password ?> </td>

                    <td colspan="2" style="padding-left: 1%; padding-top: 1%;">
                        <a class="btn btn-info" href="edit-customer.php?user=<?= $cus->username ?>" >Edit</a> 
                        <a class="btn btn-danger" href="delete-customer.php?user=<?= $cus->username ?>">Delete</a> 
                    </td>
                </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</div>


<?php require 'inc/footer.php'; ?>