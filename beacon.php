<?php
  header("HTTP/1.0 204 No Content");
  file_put_contents("metrics.txt", json_encode(array_merge($_GET, $_SERVER)));
?>
