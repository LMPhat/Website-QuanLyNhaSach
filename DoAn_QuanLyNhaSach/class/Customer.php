<?php
class Customer
{
    public $username;
    public $password;
    public $hoten;
    public $sdt;
    public $diachi;

    public static function getAll($pdo) {
        $sql = "SELECT * FROM khachhang";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Customer');
            return $stmt->fetchAll();
        }
    }

    public static function getOneByID($pdo, $username) {
        $sql = "SELECT * FROM khachhang WHERE username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Customer');
            return $stmt->fetch();
        }
    }

    public function edit($pdo, $username) {
        $sql = "UPDATE khachhang SET hoten=:hoten, sdt=:sdt, diachi=:diachi WHERE username=:username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':hoten', $this->hoten, PDO::PARAM_STR);
        $stmt->bindValue(':diachi', $this->diachi, PDO::PARAM_STR);
        $stmt->bindValue(':sdt', $this->sdt, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return true;
        }
    }

    public function remove($pdo, $username) {
        $sql = "DELETE FROM khachhang WHERE username=:username";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return true;
        }
    }
}