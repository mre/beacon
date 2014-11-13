<?php

namespace mre;

use \Noodlehaus\Config as Config;

class Beacon
{
	public function __construct()
	{
		//file_put_contents("metrics.txt", json_encode(array_merge($_GET, $_SERVER)));
		file_put_contents("metrics.txt", "teste");
	}
}

?>
