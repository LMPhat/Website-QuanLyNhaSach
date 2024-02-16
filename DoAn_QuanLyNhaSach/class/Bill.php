<?php
class Bill
{
    public $id;
    public $username;
    public $ngaylaphd;
    public $thanhtien;

    public static function getAll_Bill($pdo) {
        $sql = "SELECT * FROM hoadon";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Bill');
            return $stmt->fetchAll();
        }
    }

    public static function getAll($pdo) {
        $sql = "SELECT * FROM hoadon";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Bill');
            $results = $stmt->fetchAll();
            return end($results);
        }
    }

    public static function getOneByID_HoaDon($pdo, $id) {
        $sql = "SELECT * FROM hoadon WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Bill');
            return $stmt->fetch();
        }
    }

    public function create($pdo) {
        $sql = "INSERT INTO hoadon(username, ngaylaphd, thanhtien) VALUES (:username, :ngaylaphd, :thanhtien)";
        $stmt = $pdo->prepare($sql);

        $ngaylaphd = date('d-m-Y');
        
        $stmt->bindValue(':username', $this->username, PDO::PARAM_STR);
        $stmt->bindValue(':ngaylaphd', $ngaylaphd, PDO::PARAM_STR);
        $stmt->bindValue(':thanhtien', $this->thanhtien, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
    }

    public function remove($pdo, $id) {
        $sql = "DELETE FROM hoadon WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return true;
        }
    }
}