<?php 

// 316800 = 5 	mile

session_start();

//Register DeviceId
$_SESSION['deviceId'] = '7e49d38c03225ea4';
$_SESSION['7e49d38c03225ea4_room_name'] = '1001';

//Register UUDI
$_SESSION['UUID'] = 'a16ce630-b42a-404e-a1ab-37c9a8361260';
$_SESSION['a16ce630-b42a-404e-a1ab-37c9a8361260_title_name'] = 'นายปฏิพัทธ์ จันทร์รุ่งเรือง';
$_SESSION['a16ce630-b42a-404e-a1ab-37c9a8361260_title_position'] = 'ผู้ช่วยพยาบาล';

$_SESSION['UUID'] = 'e09f8c6d-f8de-4522-970f-cb4b0ed618df';
$_SESSION['e09f8c6d-f8de-4522-970f-cb4b0ed618df_title_name'] = 'นายโปงลาง';
$_SESSION['e09f8c6d-f8de-4522-970f-cb4b0ed618df_title_position'] = 'พยาบาล';

header('Content-Type: application/json');
 
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
    $display_nurse = array("UUID"=>$a);

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
                            
                            $nurse_firstname = $_SESSION[$UUID.'_title_name'];  
                            $nurse_position = $_SESSION[$UUID.'_title_position'];  
                            $nurse_list[$numDetect] = array("UUID"=>$UUID,"nurse_title_name"=> $nurse_firstname,"nurse_title_position"=> $nurse_position,"distance"=>$distance);
                        }
                    }
                }

                if(!isset($nurse_list)){ $nurse_list = []; }
                $a[$numRoom] = array("deviceId"=>$deviceId, "room_name"=>$room_name,"nurse_list"=> $nurse_list );
            }
           $room_name = $a;
        }
    
        $data = [
            "head"=>array("code"=>200,"message"=>"View Room"),
            "body"=>array("display_room"=>$room_name,"display_nurse"=>$display_nurse)
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