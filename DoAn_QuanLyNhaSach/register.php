<?php
require 'class/Database.php';
require 'class/User.php';

session_start();

$hotenErrors = "";
$passErrors = "";
$confPassErrors = "";
$userErrors = "";
$diachiErrors = "";
$sdtErrors = "";

$hoten = "";
$username = "";
$pass = "";
$confPass = "";
$diachi = "";
$sdt = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(empty($_POST['hoten']))
    {
        $hotenErrors = "Họ tên is required.";
    }
    else{
        $hoten=$_POST['hoten'];
    }

    if(empty($_POST['username']))
    {
        $userErrors = "Username is required.";
    }
    else{
        $username = $_POST['username'];
    }

    if(empty($_POST['pass']))
    {
        $passErrors = "Pass is required.";
    }
    else{
        $pass = $_POST['pass'];
    }

    if(empty($_POST['confPass']))
    {
        $confPassErrors = "Confim Pass is required.";
    }
    else
    {
        if($_POST['pass'] != $_POST['confPass'] )
        {
            $confPassErrors = "Confim Pass và Pass phải giống nhau.";
        }
        else{
            $confPass = $_POST['confPass'];
        }
    }

    $diachi = $_POST['diachi'];
    $sdt = $_POST['sdt'];

    if (!$userErrors && !$passErrors && !$confPassErrors && !$hotenErrors) {
        $db = new Database();
        $pdo = $db->getConnect();
        
        $user = new User();
        $user->username = $username;
        $user->password = $pass;
        $user->hoten = $hoten;
        $user->diachi = $diachi;
        $user->sdt = $sdt;

        if ($user->create($pdo)) {
            if(!isset($_SESSION['log_detail']))
            {
                header("Location: login.php");
                exit;
            }
            else
            {
                header("Location: index.php");
                exit;
            }
        }
    }
}

?>

<?php require 'inc/header.php' ?>
<form class="w-50 m-auto" method="post"> 
    <h2 style="margin-left: 0%; margin-top: 10px; margin-bottom: 10px; color: #256D85;">ĐĂNG KÝ</h2>             
    <div class="mb-3">
        <label for="hoten" class="form-label"><h5>Họ tên</h5></label>
        <input type="text" class="form-control" id="hoten" name="hoten" placeholder="Họ tên khách hàng" value="<?= $hoten ?>">
    </div>
    <div class="mb-3">
        <label for="username" class="form-label"><h5>UserName</h5></label>
        <input type="text" class="form-control" id="username" name="username" placeholder="UserName" value="<?= $username ?>">
        <p style="color: red;"><?= $userErrors ?></p>
    </div>
    <div class="mb-3">
        <label for="pass" class="form-label"><h5>Password</h5></label>
        <input type="Password" class="form-control" id="pass" name="pass" placeholder="Password" value="<?= $pass ?>">
        <p style="color: red;"><?= $passErrors ?></p>
    </div>
    <div class="mb-3">
        <label for="confPass" class="form-label"><h5>Confim Password</h5></label>
        <input type="Password" class="form-control" id="confPass" name="confPass" placeholder="Confim Password" value="<?= $confPass ?>">
        <p style="color: red;"><?= $confPassErrors ?></p>
    </div>
    <div class="mb-3">
        <label for="diachi" class="form-label"><h5>Địa chỉ</h5></label>
        <input type="text" class="form-control" id="diachi" name="diachi" placeholder="Địa chỉ" value="<?= $diachi ?>">
        <p style="color: red;"><?= $diachiErrors ?></p>
    </div>
    <div class="mb-3">
        <label for="sdt" class="form-label"><h5>Số điện thoại</h5></label>
        <input type="text" class="form-control" id="sdt" name="sdt" placeholder="Số điện thoại" value="<?= $sdt ?>">
        <p style="color: red;"><?= $sdtErrors ?></p>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-left: 40%; margin-bottom: 10px;">Sign in</button>
</form>
<?php require 'inc/footer.php' ?>