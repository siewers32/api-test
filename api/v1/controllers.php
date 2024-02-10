<?php
include("request.php");
include("auth.php");
include("db.php");

function login($login, $password)
{
    $token = checkLogin($login, $password);
    if ($token) {
        $resp["msg"] = "Login succesvol";
        $resp["token"] = $token;
    } else {
        $resp["msg"] = "Not authorized";
        $resp["token"] = false;
    }
    return $resp;
}

function cars()
{
    $pdo = conn();
    $stmt = $pdo->prepare("select * from autos");
    $stmt->execute();
    $resp["data"] = $stmt->fetchAll();
    return ($resp);
}

function car($merk, $type)
{
    if (checkAuthorization()) {
        $pdo = conn();
        $stmt = $pdo->prepare("insert into autos (Kenteken, Merk, Type, Kilometerstand, DatumApk) 
                               values (:kenteken, :merk, :type, :kilometerstand, :datumapk)");
        $stmt->execute([
            "kenteken" => getKenteken(),
            "merk" => $merk,
            "type" => $type,
            "kilometerstand" => random_int(100000, 380000),
            "datumapk" => date("Y-m-d")
        ]);
        if ($stmt->rowCount() == 1) {
            $resp["msg"] = "1 car added";
        } else {
            $resp["msg"] = "No cars added";
        }
        return $resp;
    } else {
        return $resp["msg"] = "Not authorized";
    }
}

function deleteCar($kenteken)
{
    if (checkAuthorization()) {
        $pdo = conn();
        $stmt = $pdo->prepare("delete from autos where kenteken = :kenteken");
        $stmt->execute(["kenteken" => $kenteken]);
        if ($stmt->rowCount() == 1) {
            $resp["msg"] = "1 car deleted";
        } else {
            $resp["msg"] = "No cars deleted";
        }
        return $resp;
    } else {
        return $resp["msg"] = "Not authorized";
    }
}

function getKenteken()
{
    $part1 = random_int(10, 99);
    $part2 = random_int(10, 99);
    $part3 = chr(random_int(65, 90)) . chr(random_int(65, 90));
    return $part1 . "-" . $part2 . "-" . $part3;
}

