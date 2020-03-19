<?php

session_start();

header('Content-Type: application/json');

$headers_Authorization = $_SERVER['HTTP_AUTHORIZATION'];

// $content = trim(file_get_contents("php://input"));
// $data_json = json_decode($content, true);


if($_SERVER['REQUEST_METHOD']=='POST')
{
    if($headers_Authorization=='Phayathai')
    {

        $GetDataAPI = trim(file_get_contents("json/GetDataAPI.json"));
        $GetDataAPI = json_decode($GetDataAPI, true);
        echo json_encode($GetDataAPI);
    }
}