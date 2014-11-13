<?php

namespace mre;

class Beacon
{
	public function __construct()
	{
		file_put_contents("metrics.txt", json_encode(array_merge($_GET, $_SERVER)));
	}
}

?>
