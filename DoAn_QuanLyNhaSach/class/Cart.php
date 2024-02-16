<?php

Class Cart
{
    public $username;
    public $masp;
    public $soluong;

    public static function getAll($pdo, $username) {
        $sql = "SELECT * FROM giohang where username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cart');
            return $stmt->fetchAll();
        }
    }

    public static function getSum_Soluong($pdo, $username) {
        $sql = "SELECT SUM(soluong) as soluong FROM giohang where username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cart');
            //$result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    public function create($pdo, $masp, $username) {
        $sql = "SELECT * FROM giohang WHERE masp = :masp and username = :username";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':masp', $masp, PDO::PARAM_INT);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);

        if($row)
        {
            $soluong = $row->soluong + 1;

            $sql = "UPDATE giohang SET soluong=:soluong WHERE masp=:masp and username = :username";
            $stmt = $pdo->prepare($sql);

            $stmt->bindValue(':masp', $masp, PDO::PARAM_INT);
            $stmt->bindValue(':soluong', $soluong, PDO::PARAM_INT);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $this->id = $pdo->lastInsertId();
                return true;
            }
        }
        else{
            $sql = "INSERT INTO giohang(username, masp, soluong) VALUES (:username, :masp, :soluong)";
            $stmt = $pdo->prepare($sql);

            $username = $_SESSION['log_detail'];
            $soluong = 1;

            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':masp', $masp, PDO::PARAM_INT);
            $stmt->bindValue(':soluong', $soluong, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $this->id = $pdo->lastInsertId();
                return true;
            }
        }
        
    }

    public function edit($pdo, $masp) {
        $sql = "UPDATE giohang SET soluong=:soluong WHERE masp=:masp";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':soluong', $this->soluong, PDO::PARAM_INT);
        $stmt->bindParam(':masp', $masp, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return true;
        }
    }

    public function remove($pdo, $masp) {
        $sql = "DELETE FROM giohang WHERE masp=:masp";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':masp', $masp, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return true;
        }
    }

    public static function removeAll($pdo, $username) {
        $sql = "DELETE FROM giohang WHERE username=:username";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        if($stmt->execute())
        {
            return true;
        }
    }

    public static function getOneByID($pdo, $masp) {
        $sql = "SELECT * FROM giohang WHERE masp = :masp";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':masp', $masp, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Cart');
            return $stmt->fetch();
        }
    }
}

?>