<?php
//session_start();
include("api_functions.php");
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

if (isset($_GET["q"]) && $_GET["q"] == "login") {
    // check user login/password and add token to user
    $userok = true;
    $login = true;
    $resp["msg"] = "Login succesvol";
    $resp["token"] = getToken($login, $userok);
    $req["route"] = $_GET["q"];
    $resp["status"] = "200";
}

if (isset($_GET["q"]) && $_GET["q"] == "logout") {
    // remove token from user-table and clear response
    $resp = [];
    $resp["msg"] = "Logout succesvol";
}

if (isset($_GET["q"]) && $_GET["q"] == "show") {
    // check token
    $userok = true;
    $login = false;
    $resp["token"] = getToken($login, $userok);
    $resp["msg"] = "Just showing";
}

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');

echo json_encode(["data" => $resp, "req" => $req, "server" => $_SERVER]);
