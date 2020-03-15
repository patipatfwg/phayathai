<?php 

session_start();

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
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
$nurse_data = $data_json['nurse'];
$nurse_count =  count($nurse_data);
if($nurse_count>0)
{
    for($numA=0;$numA<$nurse_count;$numA++)
    {
        $nurse_profile[$numA] = array(  'nurse_uid'=> $nurse_data['nurse'][$numA]['nurse_uid'],
                                        'nurse_firstname' => $nurse_data['nurse'][$numA]['nurse_firstname'],
                                        'nurse_lastname' => $nurse_data['nurse'][$numA]['nurse_lastname']

                                    );
                                    
        $room_data[$numA] = $nurse_data['nurse'][$numA]['detect_room'];
                                 
    }

    // for($numB=0;$numB<$room_count;$numB++)
    // {
    //     $room_data[$numB] = array(   'room_id'=> $room_arr['detect_room'][$numB]['room_id'],
    //                                 'room_title' => $room_arr['detect_room'][$numB]['room_title'],
    //                                 'room_distance' => $room_arr['detect_room'][$numB]['room_distance']
    //                             );        
    // }

}

//Nurse Data
// $nurse_uid = $nurse_data['nurse']['nurse_uid'];
// $nurse_firstname = $nurse_data['nurse']['nurse_firstname'];
// $nurse_lastname = $nurse_data['nurse']['nurse_lastname'];

        //Room Data
// $detect_room = $data_json['nurse']['detect_room'];  


 
// $nurse_data = array('nurse_uid'=>'','nurse_firstname'=>'','nurse_lastname'=>'');
// 
// 
// $room_count =  count($room_arr);
// if($room_count>0)
// {
//     for($num=0;$num<$room_count;$num++)
//     {
//         $room_data[$num] = array(   'room_id'=> $room_arr['detect_room'][$num]['room_id'],
//                                     'room_title' => $room_arr['detect_room'][$num]['room_title'],
//                                     'room_distance' => $room_arr['detect_room'][$num]['room_distance']
//                                 );
//     }
// }
// else
// {
//     $room_data = [];
// }
// $data = array("detect_room"=>$room_data);
// // $_SESSION['session_detect'] = $data;
// date_default_timezone_set("Asia/Bangkok");
// header('Content-Type: application/json');

// // echo json_encode($data);

// // echo json_encode($_SESSION['session_room']);

// $head = array('code'=>200,'title'=>'Add Data at '.date("Y-m-d H:i"));
// $data_response = array('head'=>$head,'body'=>$data);
// echo json_encode($data_response);
