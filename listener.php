<?php
$address = '127.0.0.1';
$port = 9000;

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die("ایجاد سوکت ناموفق");
}

if (socket_connect($socket, $address, $port) === false) {
    die("اتصال ناموفق");
}

$message = $_GET["message"];
socket_write($socket, $message, strlen($message));

$response = socket_read($socket, 1024);
echo "$response\n";

socket_close($socket);