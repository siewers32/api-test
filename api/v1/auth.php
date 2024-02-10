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
            }
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
            $stmt = $pdo->prepare("select id, login from tokens t join gebruikers g on t.user_id = g.id where token = :token");
            $stmt->execute(["token" => $auth[1]]);
            if ($stmt->rowCount() == 1) {
                return $stmt->fetch();
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
}

// function getToken($login, $userok)
// {
//     //Gebruiker wil inloggen en username en wachtwoord zijn gechecked
//     if ($login && $userok) {
//         return uniqid();
//     }

//     //Gebruiker wil niet inloggen, maar er is al een geldige cookie gezet.
//     if (!$login && isset($_SERVER['HTTP_AUTHORIZATION'])) {
//         $auth = explode(" ", $_SERVER['HTTP_AUTHORIZATION']);
//         if (isset($auth[1]) && $auth[1] != 'null' && $auth[0] == "Bearer" && $userok) {
//             //check if authorization token belongs to user
//             return $auth[1];
//         } else {
//             return uniqid();
//         }
//     } else {
//         return false;
//     }
// }
