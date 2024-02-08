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

function readFromInput()
{
    $pre = file_get_contents('php://input');
    parse_str(trim($pre, "\""), $req);
    if (!is_array($req)) {
        $req = array();
    }
    return $req;
}

function getToken()
{
    // $auth = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
    // if (isset($auth[1]) && $auth[0] == "Bearer") {
    //     return $auth[1];
    // } else {
    //     return uniqid();
    // }
    return $_SERVER['HTTP_AUTHORIZATION'];
}
$req = [];
$resp = [];
//collect incoming parameters
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $req = readFromInput();
        $resp["method"] = "POST";
        $resp["token"] = getToken();
        break;
    case 'GET':
        $req = $_GET;
        break;
    case 'DELETE':
        $req = $_DELETE;
        break;
    case 'PUT':
    case 'PATCH':
        $_PATCH = readFromInput();
        break;
    default:
        //TODO: implement here any other type of request method that may arise.
        break;
}


if (isset($req["action"]) && $req["action"] == "login") {
    // check user login/password and add token to user
    $resp["token"] = uniqid();
}
// if (isset($req["action"]) && $req["action"] == "logout") {
//     // remove token from user-table and clear response
//     $resp = [];
// }


header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');

echo json_encode(["resp" => $resp, "req" => $req, "server" => $_SERVER]);
