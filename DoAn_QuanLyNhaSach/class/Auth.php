<?php
class Auth 
{
    public static function login ($pdo, $username, $password) {
        try{
            $sql = "SELECT password, phanquyen FROM taikhoan WHERE username=:username";
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            if ($stmt->execute()) {

                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $hashed_password = $stmt->fetch(); //lấy một bản ghi
                
                if (password_verify($password, $hashed_password['password'])) {
                    $_SESSION['log_detail'] = $username;
                    $_SESSION['phanquyen'] = $hashed_password['phanquyen'];
                    header('location: index.php');
                    exit();
                } else {
                    return 'Login Fail';
                }
            }
        }
        catch(Exception $e)
        {
            return 'Login Fail';
        }

    }

    public static function logout() {
        unset($_SESSION['phanquyen']);
        unset($_SESSION['log_detail']); //hủy tất cả tài khoản trong session
        
        header('location: index.php');
        exit;
    }

    public static function requireLogin() {
        if (!isset($_SESSION['log_detail'])) {
            return 'Bạn không được phép truy cập';
        }
        return '';
    }
}