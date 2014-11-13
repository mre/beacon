<?php

header("HTTP/1.0 204 No Content");

require __DIR__ . "/vendor/autoload.php";
//file_put_contents("metrics.txt", json_encode(array_merge($_GET, $_SERVER)));
$beacon = new \mre\Beacon();
