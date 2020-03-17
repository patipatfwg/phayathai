<?php 

//Register DeviceId

session_start();

$_SESSION['deviceId'] = 
array(
    '7e49d38c03225ea4'
);

$title_array = 'deviceId_'.$_SESSION['deviceId'][0].'_title';

$_SESSION[$title_array] = 
array(
    '1001'
);