<?php

//Register UUDI

session_start();


$_SESSION['UUID'] = 
array(
    'a16ce630-b42a-404e-a1ab-37c9a8361260',
    'e09f8c6d-f8de-4522-970f-cb4b0ed618df'
);

$title_array = 'UUID_'.$_SESSION['UUID'][0].'_title';

$_SESSION[$title_array] = 
array(
    'นายปฏิพัทธ์ จันทร์รุ่งเรือง',
    'ผู้ช่วยพยาบาล'
);

$title_array = 'UUID_'.$_SESSION['UUID'][1].'_title_name';

$_SESSION[$title_array] = 
array(
    'นายโปงลาง',
    'ผู้ช่วยพยาบาล'
);