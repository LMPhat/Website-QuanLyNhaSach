<?php
class User
{
    public $username;
    public $password;
    public $phanquyen;
    public $hoten;
    public $diachi;
    public $sdt;
    
    public static function getAll($pdo) {
        $sql = "SELECT * FROM taikhoan";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetchAll();
        }
    }

    public static function getOneByID($pdo, $username) {
        $sql = "SELECT * FROM taikhoan WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $username, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            return $stmt->fetch();
        }
    }

    public function create($pdo) {
        $flag = false;
        $sql = "INSERT INTO taikhoan(username, password, phanquyen) VALUES (:username, :password, :phanquyen)";
        $stmt = $pdo->prepare($sql);

        var_dump($this->password);

        $password = password_hash($this->password, PASSWORD_DEFAULT);

        var_dump($this->username);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':phanquyen', $this->phanquyen, PDO::PARAM_STR);

        if($stmt->execute())
        {
            $id = $pdo->lastInsertId();
            $flag = true;
        }

        $sql = "INSERT INTO khachhang(username, password, hoten, sdt, diachi) 
                VALUES (:username, :password, :hoten, :sdt, :diachi)";
        $stmt = $pdo->prepare($sql);
        $password = password_hash($this->password, PASSWORD_DEFAULT);
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':hoten', $this->hoten, PDO::PARAM_STR);
        $stmt->bindValue(':sdt', $this->sdt, PDO::PARAM_STR);
        $stmt->bindValue(':diachi', $this->diachi, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            $flag = true;
        }

        return $flag;
    }

}