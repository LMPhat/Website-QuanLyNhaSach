<?php
Class Pro_Bill
{
    public $masp;
    public $mahd;
    public $soluong;

    public static function getAllPro_Bill($pdo, $mahd) {
        $sql = "SELECT * FROM chitiet_hd WHERE mahd = :mahd";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':mahd', $mahd, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pro_Bill');
            return $stmt->fetchAll();
        }
    }

    public function getByIDBill($pdo, $mahd) {
        $sql = "SELECT * FROM chitiet_hd WHERE mahd = :mahd";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':mahd', $mahd, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pro_Bill');
            return $stmt->fetchAll();
        }
    }

    public function getByIDPro_Bill($pdo, $masp, $mahd) {
        $sql = "SELECT * FROM chitiet_hd WHERE masp = :masp && mahd = :mahd";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':masp', $masp, PDO::PARAM_INT);
        $stmt->bindValue(':mahd', $mahd, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pro_Bill');
            return $stmt->fetchAll();
        }
    }

    public function create($pdo) {
        $sql = "INSERT INTO chitiet_hd(masp, mahd, soluong) VALUES (:masp, :mahd, :soluong)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':masp', $this->masp, PDO::PARAM_INT);
        $stmt->bindValue(':mahd', $this->mahd, PDO::PARAM_INT);
        $stmt->bindValue(':soluong', $this->soluong, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
    }

    public function remove($pdo, $mahd) {
        var_dump($mahd);
        $sql = "DELETE FROM chitiet_hd WHERE mahd=:mahd";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':mahd', $mahd, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return true;
        }
    }

    public function getSum_HoaDon($pdo, $mahd) {
        $sql = "SELECT SUM(soluong) as soluong FROM chitiet_hd where mahd = :mahd";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':mahd', $mahd, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pro_Bill');
            //$result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}