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
    if( isset($data_json) )
    {
        if(isset($data_json['nurse'])&& isset($data_json['information']))
        {
            $nurse_data = $data_json['nurse'];
            $information_data = $data_json['information'];
            $write_deviceId = $information_data['deviceId'];
            if($write_deviceId!='')
            {
                //Write Log
                $filename = "jsonlogs/".$information_data['deviceId']."_data_detect.json";
                $file_encode = json_encode($data_json,true);
                file_put_contents($filename, $file_encode );
                chmod($filename,0777);     
                 
                //
                // for($num=0;$num<count($nurse_data);$num++)
                // {
                //     $title = $nurse_data[$num]['title'];
                //     if($title=='iTAG            ')
                //     {
                //         $mac_address = $nurse_data[$num]['mac_address'];
                //         $distance = $nurse_data[$num]['distance'];
                //         $data_input = [array(  'mac_address'=> $mac_address,'title'=> $title,'distance'=> $distance)];
                //     }
                // }
                for($num=0;$num<count($nurse_data);$num++)
                {
                    if( isset($nurse_data[$num]['title']) ){$title = $nurse_data[$num]['title'];}else{$title =null;}
                  
                    $mac_address = $nurse_data[$num]['mac_address'];
                    $distance = $nurse_data[$num]['distance'];
                    $data_input[$num] = array(  'mac_address'=> $mac_address,'title'=> $title,'distance'=> $distance);
                    
                }
                
                $data = [
                    "head"=>array("code"=>200,"message"=>"OK"),
                    "body"=>array( "iTAG"=> $data_input )
                ];
                
            }
            else
            {
                $data = [
                    "head"=>array("code"=>200,"message"=>"Thank You Pong"),
                    "body"=>[]
                ];   
            }
        }
        else
        {
            $data = [
                "head"=>array("code"=>400,"message"=>"Kick Pong"),
                "body"=>[]
            ];

        }
        // echo json_encode($data,JSON_PRETTY_PRINT);

        // //Backend
        // if($write_deviceId!='' && count($data_input))
        // {
        //     $filename = "json/".$information_data['deviceId'].".json";
        //     $file_encode = json_encode($data_input,true);
        //     file_put_contents($filename, $file_encode );
        //     chmod($filename,0777); 
        // }


            $filename = "json/".$information_data['deviceId'].".json";
            $file_encode = json_encode($data_input,true);
            file_put_contents($filename, $file_encode );
            chmod($filename,0777); 
        
            //GET Room
            if( !isset($FLAG_GetDataAPI) )
            {
                $device_json = trim(file_get_contents("device.json"));
                $device_json = json_decode($device_json, true);

                for($getRoom=0;$getRoom<count($device_json['device']);$getRoom++)
                {
                    $get_nurse_list=[];
                    $device_deviceId = $device_json['device'][$getRoom]['deviceId'];
                    $device_title = $device_json['device'][$getRoom]['title'];
                    $device_ordinal = $device_json['device'][$getRoom]['ordinal'];
                    $device_deviceId_URL = "json/".$device_deviceId.".json";

                    if( file_exists($device_deviceId_URL) )
                    {
                        $iTAG_json = trim(file_get_contents($device_deviceId_URL));
                        $iTAG_json = json_decode($iTAG_json, true);
                        $get_nurse_list = [];
                        
                        for($getNurse=0;$getNurse<count($iTAG_json);$getNurse++)
                        {
                            $mac_address = $iTAG_json[$getNurse]['mac_address'];
                            $distance = $iTAG_json[$getNurse]['distance'];
                            $title = $iTAG_json[$getNurse]['title'];

                            // $distance_cal = ($distance + 49.751)/-1.2824;
                            // $distance_rating_5m = -56.38;
                            // $distance_rating_1m = -51.45;

                            if( strstr( $title,"iTAG") )
                            {
                                $get_nurse_list[$getNurse] = array(
                                    'mac_address'=>$mac_address,
                                    'distance'=>$distance,
                                    'title'=>$title,
                                );
                            }

                               
                    

                        } 

                        //Sort
                        sort($get_nurse_list);
                        foreach ($get_nurse_list as $key => $val) {
                            $get_nurse_list[$key] = array(
                                'mac_address'=>$val['mac_address'],
                                'distance'=>$val['distance'],
                                'title'=>$val['title'],
                            );
                        }
                        //

                    }
                    if(!isset($get_nurse_list)){ $get_nurse_list=[]; }
                    $DataRoom[$getRoom] = array(
                                                "ordinal"=>$device_ordinal,
                                                "deviceId"=>$device_deviceId,
                                                "room_title"=>$device_title,
                                                "nurse_list"=>$get_nurse_list
                                            );

                }

                //Sort
                sort($DataRoom);
                foreach ($DataRoom as $key => $val) {
                    $DataRoom[$key] = array(
                        "ordinal"=>$val['ordinal'],
                        "deviceId"=>$val['deviceId'],
                        "room_title"=>$val['room_title'],
                        "nurse_list"=>$val['nurse_list']
                    );
                }
                //
                if(count($DataRoom)>1)
                {
                    $DataRoom = $DataRoom;
                }
                else
                {
                    $DataRoom = [$DataRoom];
                }
                $RefURL = array("https://www.gujarattourism.com/file-manager/ebrochure/thumbs/testing_e_brochure_3.pdf","http://www3.eng.psu.ac.th/pec/6/pec6/paper/CoE/PEC6OR170.pdf","https://forums.estimote.com/t/use-rssi-measure-the-distance/3665/3");
                $GetDataAPI = [
                    "head"=>array("code"=>200,"message"=>"OK"),
                    "body"=>array("room"=> $DataRoom ),
                    "footer"=>array("Ref."=>$RefURL)
                ]; 
                $filenameGetDataAPI = "json/GetDataAPI.json";
                $file_encodeGetDataAPI = json_encode($GetDataAPI,true);
                file_put_contents($filenameGetDataAPI, $file_encodeGetDataAPI );
                chmod($filenameGetDataAPI,0777);  
            }
            //
        
        echo json_encode($GetDataAPI);
    }
}
else if($_SERVER['REQUEST_METHOD']=='GET')
{
    $data = [
        "head"=>array("code"=>400,"message"=>"Kick Pong"),
        "body"=>['No No']
    ];
    echo json_encode($data,JSON_PRETTY_PRINT);
}

