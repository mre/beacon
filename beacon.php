<?php
  echo "TEST";
  header("HTTP/1.0 204 No Content");

  foreach($_GET as $key => $value){
      echo $key . " : " . $value . PHP_EOL;
  }
  var_dump(get_browser());
?>
