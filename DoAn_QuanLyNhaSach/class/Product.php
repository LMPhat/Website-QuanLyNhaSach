<?php
class Product
{
    public $id;
    public $tensach;
    public $mota;
    public $gia;
    public $hinhanh;
    public $tacgia;
    public $maloai;
    
    public static function getAll($pdo) {
        $sql = "SELECT * FROM sach";
        //$sql = "SELECT product.*, category.name as catname FROM product LEFT JOIN pro_cat ON pro_cat.proid = product.id LEFT JOIN category ON pro_cat.catid = category.id";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function getPro_Category($pdo, $maloai) {
        $sql = "SELECT * FROM sach where maloai = :maloai";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':maloai', $maloai, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function getPro_SapXepTang($pdo) {
        $sql = "SELECT * FROM sach ORDER BY gia ASC";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function getPro_SapXepGiam($pdo) {
        $sql = "SELECT * FROM sach ORDER BY gia DESC";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function findPro($pdo, $tensach) {
        $sql = "SELECT * FROM sach WHERE tensach LIKE :tensach";
        $stmt = $pdo->prepare($sql);
        $tens = '%' . $tensach . '%';
        $stmt->bindParam(':tensach', $tens, PDO::PARAM_STR);

        if($stmt->execute())
        {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function getPage($pdo, $limit, $offset) {
        $sql = "SELECT * FROM sach ORDER BY id LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetchAll();
        }
    }

    public static function getOneByID($pdo, $id) {
        $sql = "SELECT * FROM sach WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            return $stmt->fetch();
        }
    }

    public function create($pdo) {
        $sql = "INSERT INTO sach(tensach, mota, tacgia, gia, hinhanh, maloai) VALUES (:tensach, :mota, :tacgia, :gia, :hinhanh, :maloai)";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindValue(':tensach', $this->tensach, PDO::PARAM_STR);
        $stmt->bindValue(':mota', $this->mota, PDO::PARAM_STR);
        $stmt->bindValue(':tacgia', $this->tacgia, PDO::PARAM_STR);
        $stmt->bindValue(':gia', $this->gia, PDO::PARAM_INT);
        $stmt->bindValue(':hinhanh', $this->hinhanh, PDO::PARAM_STR);
        $stmt->bindValue(':maloai', $this->maloai, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
    }

    public function edit($pdo, $id) {
        $sql = "UPDATE sach SET tensach=:tensach, mota=:mota, tacgia=:tacgia, gia=:gia, hinhanh=:hinhanh, maloai=:maloai WHERE id=:id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':tensach', $this->tensach, PDO::PARAM_STR);
        $stmt->bindValue(':mota', $this->mota, PDO::PARAM_STR);
        $stmt->bindValue(':tacgia', $this->tacgia, PDO::PARAM_STR);
        $stmt->bindValue(':gia', $this->gia, PDO::PARAM_INT);
        $stmt->bindValue(':hinhanh', $this->hinhanh, PDO::PARAM_STR);
        $stmt->bindValue(':maloai', $this->maloai, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return true;
        }
    }

    public function remove($pdo, $id) {
        $sql = "DELETE FROM sach WHERE id=:id";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute())
        {
            return true;
        }
    }

    public static function getCout_SP($pdo) {
        $sql = "SELECT COUNT(*) AS tongSL FROM sach";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
            //$result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
}