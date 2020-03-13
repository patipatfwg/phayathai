<?php 

// session_start();

header('Content-Type: application/json');

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0){
    throw new Exception('Request method must be POST!');
}
 
//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}
 
//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));
 
//Attempt to decode the incoming RAW post data from JSON.
$data_json = json_decode($content, true);

if(isset($data_json['nurse'])&& isset($data_json['information']))
{
    $nurse_data = $data_json['nurse'];
    $information_data = $data_json['information'];

    $data = [
        "head"=>array("code"=>200,"message"=>"Thank You Pong"),
        "body"=>array("count information"=>count($information_data),"count nurse"=>count($nurse_data))
    ];

    // file_put_contents('json/datajson.json', json_encode($data_json,true) );
}
else
{
    $data = [
        "head"=>array("code"=>400,"message"=>"Kick Pong"),
        "body"=>[]
    ];

}

echo json_encode($data,JSON_PRETTY_PRINT);