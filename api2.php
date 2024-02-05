<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //$pre = $_POST;
    
    echo json_encode($_POST);
}