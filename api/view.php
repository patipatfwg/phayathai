<?php

session_start();

include "UUID.php";
include "detect.php";

//Register DeviceId
// $_SESSION['deviceId'] = '7e49d38c03225ea4';
// $_SESSION['7e49d38c03225ea4_room_name'] = '1001';

//Register UUDI
// $_SESSION['UUID'] = 'a16ce630-b42a-404e-a1ab-37c9a8361260';
// $_SESSION['a16ce630-b42a-404e-a1ab-37c9a8361260_title_name'] = 'นายปฏิพัทธ์ จันทร์รุ่งเรือง';
// $_SESSION['a16ce630-b42a-404e-a1ab-37c9a8361260_title_position'] = 'ผู้ช่วยพยาบาล';

// $_SESSION['UUID'] = 'e09f8c6d-f8de-4522-970f-cb4b0ed618df';
// $_SESSION['e09f8c6d-f8de-4522-970f-cb4b0ed618df_title_name'] = 'นายโปงลาง';
// $_SESSION['e09f8c6d-f8de-4522-970f-cb4b0ed618df_title_position'] = 'พยาบาล';

header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD']=='GET')
{
    $data = [
        "head"=>array("code"=>400,"message"=>"Kick Pong"),
        "body"=>[]
    ];
    echo json_encode($data,JSON_PRETTY_PRINT);
}
else if($_SERVER['REQUEST_METHOD']=='POST')
{




    $data = [
        "head"=>array("code"=>200,"message"=>"View Room"),
        "body"=>array("display_room"=>$room_name,"display_nurse"=>$display_nurse)
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