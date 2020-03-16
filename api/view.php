<?php 

// 316800 = 5 	mile

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

$label_room = trim(file_get_contents("json/label_room.json"));
$label_room_json = json_decode($label_room, true);

$label_nurse = trim(file_get_contents("json/label_nurse.json"));
$label_nurse_json = json_decode($label_nurse, true);

if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($label_room_json['room']))
    {
        $room_data = $label_room_json['room'];
        $nurse_data = $label_nurse_json['nurse'];

        if(count($room_data)>0 && count($nurse_data)>0)
        {
           for($numRoom=0;$numRoom<count($room_data);$numRoom++)
           {
                $deviceId = $room_data[$numRoom]['deviceId'];
                $room_name = $room_data[$numRoom]['room_name'];
                $file_url = "json/data_detect_".$deviceId.".json";

                $data_detect = trim(file_get_contents($file_url));
                $data_detect_json = json_decode($data_detect, true);

                if(file_exists($file_url))
                {
                    $data_detect = trim(file_get_contents($file_url));
                    $data_detect_json = json_decode($data_detect, true);
                    
                    for($numDetect=0;$numDetect<count($data_detect_json);$numDetect++)
                    {
                        if($data_detect_json['information']['deviceId']==$deviceId)
                        {
                            $UUID = $data_detect_json['nurse'][$numDetect]['UUID'];
                            $distance = $data_detect_json['nurse'][$numDetect]['distance'];
                            $nurse_list[$numDetect] = array("UUID"=>$UUID,"nurse_firstname"=> "First","nurse_lastname"=> "Last","distance"=>$distance);
                        }
                    }
                }


                // for($numNurse=0;$numNurse<count($nurse_data);$numNurse++)
                // {
                        // $deviceId = $room_data[$numRoom]['deviceId'];
                        // $room_name = $room_data[$numRoom]['room_name'];

                        // $file_url = "json/data_detect_".$room_data[$numRoom]['deviceId'].".json";
                        // if(file_exists($file_url))
                        // {
                            
                        //     if($data_device_json['information']['deviceId']==$deviceId)
                        //     {
                        //         $data_device_json['nurse']['']
                        //     }
                        // }

                        // $b[$numNurse] = array("UUID"=>"0051","nurse_firstname"=>"ABC","nurse_lastname"=>"DEF","distance"=>1.9);
                // }

                // $nurse_name = $b;

                if(!isset($nurse_list)){ $nurse_list = []; }
                $a[$numRoom] = array("deviceId"=>$deviceId, "room_name"=>$room_name,"nurse_list"=> $nurse_list );
           }

           $room_name = $a;

        }

        //
        //
        
        //
        //
    
        $data = [
            "head"=>array("code"=>200,"message"=>"View Room"),
            "body"=>array("display_room"=>$room_name)
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


                // $file_url = "json/data_detect_".$room_data[$numRoom]['deviceId'].".json";
                // if(file_exists($file_url))
                // {
                //     $data_room = trim(file_get_contents($file_url));
                //     $data_room_json = json_decode($data_room, true);
                //     if($data_room_json['information']['deviceId']==$deviceId)
                //     {
                //         for($numNurse=0;$numNurse<count($data_room_json['nurse']);$numNurse++)
                //         {
                //             $nurse_arr = $data_room_json['nurse'][$numNurse];
                //             $w[$numNurse] = $nurse_arr;
                //             // in_array("Glenn",  $nurse_arr);
                //         }
                //     }                    
                // }