<?php
require dirname(__FILE__) . '/../../Holo/Request/ArrayObject.php';
$data = array('a', 'b', 'c');
$hra = new Holo_Request_ArrayObject($data, 'UTF-8');
var_dump(count($hra) === 3);

$data = array('a', 'b', pack("C*", 0xC0, 0xAF));
try {
    $hra = new Holo_Request_ArrayObject($data, 'UTF-8');
} catch(Exception $e) {
    var_dump($e->getMessage());
}

$hra = new Holo_Request_ArrayObject($data, 'UTF-8', Holo_Request_ArrayObject::ERROR_REMOVE_ONRY);
var_dump(count($hra) === 2);

$data = array('a', 'b', "\0");
$hra = new Holo_Request_ArrayObject($data, 'UTF-8');
var_dump($hra[2] === '');
$hra = new Holo_Request_ArrayObject($data, 'UTF-8', Holo_Request_ArrayObject::IGNORE_SNITIZE);
var_dump($hra[2] === "\0");
