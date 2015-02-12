<?php

// Do not block the client just for metrics
// Immediately send response header
header('HTTP/1.0 200 OK');
header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: {now} GMT');
header("Content-Length: 0");
header('Connection: close');
flush();

// Only after that process the received data
require('bootstrap.php');