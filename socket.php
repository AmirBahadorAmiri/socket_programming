<?php
error_reporting(E_ALL);

// ایجاد سوکت
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die("ایجاد سوکت ناموفق: " . socket_strerror(socket_last_error()));
}

// Bind به آدرس و پورت
$address = 'localhost';
$port = 9000;

// اضافه کردن این دو خط خیلی مهم است
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

if (socket_bind($socket, $address, $port) === false) {
    die("Bind ناموفق: " . socket_strerror(socket_last_error($socket)));
}

// گوش دادن به اتصالات
if (socket_listen($socket, 5) === false) {
    die("Listen ناموفق: " . socket_strerror(socket_last_error($socket)));
}

echo "سرور در حال گوش دادن روی $address:$port ...\n";

while (true) {
    $client = socket_accept($socket);
    if ($client === false) {
        continue;
    }

    $inputToServer = socket_read($client, 1024);
    if ( trim($inputToServer) == "سلام" ) {
        $outputToClient = "سلام عزیزم";
    } elseif (trim($inputToServer) == "خوبی") {
        $outputToClient = "هی شکر میگذره";
    } else {
        $outputToClient = "سلامتو خوردی ؟";
    }

    echo "$inputToServer\n";
    socket_write($client, $outputToClient, strlen($outputToClient));
    socket_close($client);
}

socket_close($socket);