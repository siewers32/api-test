<?php
session_start();
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
    $token = "";
    $user = "";
    if (isset($_POST["action"]) && $_POST["action"] == "logout") {
        // clear session
        $_SESSION = [];
        session_destroy();
        // setcookie("token", "", time() - 3600);
        if (isset($_COOKIE["token"])) {
            setcookie('token', 'content', 1);
        }
    } else {
        // Check if token is set
        if (!isset($_COOKIE["token"])) {
            $token = uniqid();
            setcookie('token', $token, ["expires" => time() + 24 * 3600, "httponly" => true]);
        } else if ($_COOKIE["token"] == "") {
            $token = uniqid();
            $_COOKIE["token"] = $token;
        } else {
            $token = $_COOKIE["token"];
        }
    }

    $resp = [
        "cookie_token" => $token,
        "session_id" => session_id(),
    ];
    $data = [
        "request" => $_POST,
        "response" => $resp,
    ];
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
