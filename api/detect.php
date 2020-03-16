<?php 

session_start();

header('Content-Type: application/json');

//Make sure that it is a POST request.
// if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
//     throw new Exception('Request method must be POST!');
// }
 
//Make sure that the content type of the POST request has been set to application/json
// $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
// if(strcasecmp($contentType, 'application/json') != 0){
//     throw new Exception('Content type must be: application/json');
// }
 
//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));
 
//Attempt to decode the incoming RAW post data from JSON.
$data_json = json_decode($content, true);

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($data_json['nurse'])&& isset($data_json['information']))
    {
        $nurse_data = $data_json['nurse'];
        $information_data = $data_json['information'];

        $filename = "json/data_detect_".$information_data['deviceId'].".json";
        $file_encode = json_encode($data_json,true);
        file_put_contents($filename, $file_encode );
        chmod($filename,0777);
        //
        //

        //
        //
        $data = [
            "head"=>array("code"=>200,"message"=>"Thank You Pong"),
            "body"=>array("data_input"=>$data_json)
        ];        
    }
    else
    {
        $data = [
            "head"=>array("code"=>400,"message"=>"Kick Pong"),
            "body"=>[]
        ];

    }
    echo json_encode($data,JSON_PRETTY_PRINT);
}
else if($_SERVER['REQUEST_METHOD']=='GET')
{
    $data = [
        "head"=>array("code"=>400,"message"=>"Kick Pong"),
        "body"=>['No No']
    ];
    echo json_encode($data,JSON_PRETTY_PRINT);
}