<?php
include("controllers.php");

// empty response array
$resp = [];
//collect incoming request params
$req = getRequest();

$route = (isset($_GET['q'])) ? $_GET['q'] : false;
switch ($route) {
    case 'login':
        $resp = login($req['login'], $req['password']);
        break;
    case 'logout':
        $resp = [];
        $resp["msg"] = "Logout succesvol";
        break;
    case 'cars':
        $resp = cars();
        break;
    case 'car':
        $resp = car($req["merk"], $req["type"]);
        break;
    case 'delete_car':
        $resp = deleteCar($req["kenteken"]);
        break;
    default:
        $resp["msg"] = "No such route available";
        $resp["status"] = 404;
        break;
}

header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Origin: *');
echo json_encode(["req" => $req, "resp" => $resp]);
