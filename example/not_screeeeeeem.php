<?php 
$_POST = Holo_Request_ArrayObject($_POST, 
                         mb_string_internal_encoding(),
                         Holo_Request_ArrayObject::RESULT_DEFAULTVALUE
                         ||  Holo_Request_ArrayObject::ERROR_REMOVE_ONRY);

//false
var_dump(isset($_POST['notvalue'])); 

//not output notice
//null
var_dump(($_POST['notvalue']);

$_POST->setDefaultValue('mote');

//string "mote"
var_dump(($_POST['notvalue']);

//but this respnse false..
var_dump((is_array($_POST));


