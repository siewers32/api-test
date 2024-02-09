<?php
function checkAuthorization()
{
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        return $_SERVER['HTTP_AUTHORIZATION'];
    } else {
        return "unauthorized";
    }
}
function readFromInput()
{
    $pre = file_get_contents('php://input');
    parse_str(trim($pre, "\""), $req);
    mylog($pre);
    if (!is_array($req)) {
        $req = array();
    }
    return $req;
}

function getToken($login, $userok = true)
{
    if ($login && $userok) {
        return uniqid();
    } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $auth = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
        if (isset($auth[1]) && $auth[1] != 'null' && $auth[0] == "Bearer" && $userok) {
            //check if authorization token belongs to user
            return $auth[1];
        } else {
            return uniqid();
        }
    } else {
        return false;
    }
}

function conn()
{
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
    return $pdo;
}

function mylog($var)
{
    $myFile = "log.txt";
    $fh = fopen($myFile, 'a') or die("can't open file");
    if (is_array($var)) {
        foreach ($var as $v) {
            fwrite($fh, $v . "/n");
        }
    } else {
        fwrite($fh, $var . "/n");
    }
    fclose($fh);
}
