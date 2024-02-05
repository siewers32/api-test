<?php
$host = '127.0.0.1';
$db   = 'autoverhuur';
$user = 'root';
$pass = 'root';
$port = 8889;
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //echo '{"jo":"jo"}';
    echo json_encode($_GET);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$pre = $_POST;
    $pre = json_decode(file_get_contents('php://input'), true);
    //$pre = $_POST;
    $sql = "SELECT * FROM autos";
    $stmt = $pdo->query($sql);
    $result = $stmt->fetchAll();
    $data = [$pre, $result];
    echo json_encode($data);
}
