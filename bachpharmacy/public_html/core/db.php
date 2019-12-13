<?php //db.php
$host='localhost';
$db='sneidi_pharmacy';
$user='sneidi_pharmacy';
$pass='dVs9XNN4';

$dsn = "mysql:host=$host;dbname=$db";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    try{
    $pdo = new PDO($dsn, $user, $pass, $opt);
    } 
    catch (PDOException $e) {
    die("Невозможно подключиться к MySQL: " . $e->getMessage());
}
?>