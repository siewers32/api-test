<?php

function checkLogin($login, $password)
{
    if ($login == "Admin") {
        $pdo = conn();
        $stmt = $pdo->prepare("select * from gebruikers where login = ?");
        $stmt->execute([$login]);
        $result = $stmt->fetch();
        if ($result) {
            if (password_verify($password, $result['password'])) {
                $token = uniqid();
                $stmt = $pdo->prepare("insert into tokens (user_id, token) values (:id, :token)");
                $stmt->execute(["id" => $result["id"], "token" => $token]);
                return $token;
            };
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function checkAuthorization()
{
    if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
        $auth = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
        if (isset($auth[1]) && $auth[1] != 'null' && $auth[0] == "Bearer") {
            $pdo = conn();
            $stmt = $pdo->prepare("select * from tokens where token = :token");
            $stmt->execute(["token" => $auth[1]]);
            if($stmt->rowCount() == 1) {
                return $auth[1];
            } else {
                return false;
            } 
        }
    }
}


function readFromInput()
{
    $pre = file_get_contents('php://input');
    parse_str(trim($pre, "\""), $req);
    return $req;
}

function getToken($login, $userok)
{
    //Gebruiker wil inloggen en username en wachtwoord zijn gechecked
    if ($login && $userok) {
        return uniqid();
    }

    //Gebruiker wil niet inloggen, maar er is al een geldige cookie gezet.
    if (!$login && isset($_SERVER['HTTP_AUTHORIZATION'])) {
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

function fvar_dump($var)
{
    // $myFile = "log.txt";
    // $fh = fopen($myFile, 'a') or die("can't open file");
    // if (is_array($var)) {
    //     foreach ($var as $v) {
    //         fwrite($fh, $v . "/n");
    //     }
    // } else {
    //     fwrite($fh, $var . "/n");
    // }
    // fclose($fh);
    ob_flush();
    ob_start();
    // var_dump($var);
    // file_put_contents("log.txt", ob_get_flush());
}
