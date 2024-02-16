<?php
Class Category
{
    public $id;
    public $tenloai;

    public static function getAllCategory($pdo) {
        $sql = "SELECT * FROM loai";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            return $stmt->fetchAll();
        }
    }

    public static function getOneByIDCategory($pdo, $id) {
        $sql = "SELECT * FROM loai WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            return $stmt->fetch();
        }
    }

    public static function getNameCategory($pdo, $id) {
        $sql = "SELECT tenloai FROM loai WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Category');
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['tenloai'];
        }
    }
}