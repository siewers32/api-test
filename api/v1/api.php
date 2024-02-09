<?php
include("controllers.php");
$req = [];
$resp = [];

//collect incoming request params
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $req = readFromInput();
        $req["method"] = "POST";
        break;
    case 'GET':
        $req = $_GET;
        break;
    case 'DELETE':
        $req = $_DELETE;
        break;
    case 'PUT':
    case 'PATCH':
        $req = readFromInput();
        break;
    default:
        //TODO: implement here any other type of request method that may arise.
        break;
}

// Routes
if (isset($_GET["q"]) && $_GET["q"] == "login") {
    $token = checkLogin($req['inpLogin'], $req['inpPassword']);
    if ($token) {
        $resp["msg"] = "Login succesvol";
        $resp["token"] = $token;
    } else {
        $resp["msg"] = "Not authorized";
        $resp["token"] = false;
    }
    $req["route"] = $_GET["q"];
    $resp["status"] = "200";
    $resp["debug"] = checkAuthorization();
}

if (isset($_GET["q"]) && $_GET["q"] == "logout") {
    // remove token from user-table and clear response
    $resp = [];
    $resp["msg"] = "Logout succesvol";
}

if (isset($_GET["q"]) && $_GET["q"] == "show") {

    $userok = false;
    $login = false;
    $resp["token"] = getToken($login, $userok);
    $resp["msg"] = "Just showing";
    $resp["data"] = showCars();
}

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
echo json_encode(["req" => $req, "resp" => $resp, "auth" => checkAuthorization()]);
