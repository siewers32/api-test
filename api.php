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
    // Manually create $_POST server array
    $pre = file_get_contents('php://input');
    parse_str(trim($pre, "\""), $_POST);

    // Clear token
    if (isset($_POST["action"]) && $_POST["action"] == "logout") {
        //setcookie("token", "", time() - 3600);
        if (isset($_COOKIE["token"])) {
            setcookie('token', 'content', 1);
        }
        $token = "no token";
    } else {
        // Check if token is set
        $token = "no token";
        if (!isset($_COOKIE["token"])) {
            $token = uniqid();
            setcookie('token', $token, ["expires" => time() + 3600, "httponly" => true]);
        } else if ($_COOKIE["token"] == "") {
            $token = uniqid();
            $_COOKIE["token"] = $token;
        } else {
            $token = $_COOKIE["token"];
        }
    }

    $resp = ["token" => $token];
    $data = ["request" => $_POST, "response" => $resp, "token" => $token];
    // $sql = "SELECT * FROM autos";
    // $stmt = $pdo->query($sql);
    // $result = $stmt->fetchAll();
    // $data = ["req" => $_POST, "resp" => $result];
    // $myfile = fopen("testfile.txt", "w");
    // $txt = $pre;
    // fwrite($myfile, trim($pre, "\""));
    // fclose($myfile);
    echo json_encode($data);
}
