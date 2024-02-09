<?php
include("api_functions.php");

function showCars()
{
    if (checkAuthorization()) {
        $pdo = conn();
        $stmt = $pdo->prepare("select * from autos");
        $stmt->execute();
        return $stmt->fetchAll();
    } else {
        return "not authorized";
    }
}

function addUser()
{
}
