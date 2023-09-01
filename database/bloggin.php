<?php
require "config.php";

$dsn = "mysql:host=$host; dbname=$dbname;charset=UTF8mb4";
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die($e->getMessage());
}
