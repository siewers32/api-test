<?php

function getRequest()
{
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $req = readFromInput();
            $req["method"] = "POST";
            break;
        case 'GET':
            $req = $_GET;
            break;
        case 'DELETE':
            $req = readFromInput();
            break;
        case 'PUT':
        case 'PATCH':
            $req = readFromInput();
            break;
        default:
            //TODO: implement here any other type of request method that may arise.
            break;
    }
    return $req;
}

function readFromInput()
{
    $pre = file_get_contents('php://input');
    parse_str(trim($pre, "\""), $req);
    return $req;
}
