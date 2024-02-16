<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title><?= $title ?? 'No title' ?></title>
</head>
<body>
    <nav class="navbar navbar-expand" style="background-color: #A0E4CB;">
        <div class="container">
            <a class="navbar-brand" href="#" style="color: #256D85;">Shop của tôi</a>
            <div class="navbar-collapse" style="color: #256D85;">
                <ul class="navbar-nav">
                    <li class="nav-item" >
                        <a class="nav-link" href="index.php" >Trang chủ</a>
                    </li>

                    <?php if (isset($_SESSION['phanquyen'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="new-product.php">Thêm SP mới</a>
                    </li>
                    <?php else: ?>
                    <li>
                    </li>
                    <?php endif; ?>

                    <?php if (!isset($_SESSION['log_detail'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Đăng nhập</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                    <?php endif; ?>

                </ul>
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Danh mục sách
                        </button>
                        <ul class="dropdown-menu">
                            
                        <?php foreach ($data_category as $category) : ?>

                            <li>
                                <a class="dropdown-item" href="index.php?action=showcategory&categoryid=<?= $category->id ?>">
                                    <?= $category->tenloai ?>
                                </a>
                            </li>

                        <?php endforeach; ?>
                        
                        </ul>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarNavDarkDropdown" style="margin-left:-180px;">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                        <button class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            Danh mục sắp xếp
                        </button>
                        <ul class="dropdown-menu">
                            
                        <li><a class="dropdown-item" href="index.php?action=sapxep&sapxep_id=1">Tăng dần theo giá</a></li>
                        <li><a class="dropdown-item" href="index.php?action=sapxep&sapxep_id=2">Giảm dần theo giá</a></li>

                        </ul>
                        </li>
                    </ul>
                </div>
                
                <div style="margin-right: 100px;">
                    <form class="form-inline my-2 my-lg-0 d-flex justify-content-center" action="index.php" method="POST">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
                <?php if (!isset($_SESSION['phanquyen'])): ?>
                    <div>
                    <?php  if (isset($_SESSION['log_detail'])){
                        
                                   $str = "cart.php";
                            }
                            else
                            {
                                $str = "login.php";
                            }
                            ?>
                        <a class="btn btn-outline-success" href= <?=$str ?>>Giỏ hàng
                            <?php  if (isset($_SESSION['log_detail'])){
                                   $tmp = Cart::getSum_Soluong($pdo, $_SESSION['log_detail']);
                                   echo $tmp['soluong'];
                            }
                             ?>

                        </a>
                    </div>
            
                <?php endif; ?>
            </div>
        </div>
    </nav>

