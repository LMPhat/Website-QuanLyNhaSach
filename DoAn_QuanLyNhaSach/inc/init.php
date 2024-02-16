<?php
session_start();

if (!isset($_SESSION['data'])) {
    $_SESSION['data'] = Product::getAll('data.csv');
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}