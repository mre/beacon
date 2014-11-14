<?php

namespace mre;

use \Noodlehaus\Config as Config;
use \Domnikl\Statsd\Connection\Socket;
use \Domnikl\Statsd\Client as Statsd;

class Beacon
{
	private $aData;
	private $aRawData;
	private $oStatsD;
	private $oConfig;

	public function __construct($sConfigFile, $analyze = True)
	{
		$this->oConfig = Config::load($sConfigFile);
		$this->aRawData["GET"] =  $_GET;
		$this->aRawData["SERVER"] =  $_SERVER;
		file_put_contents("test.txt", json_encode($this->aRawData));
		$this->initStatsD();
		$this->analyze();
	}

        private function initStatsd()
        {
                $_oConnection = new Socket(
                                $this->oConfig->get('statsd')['host'],
                                $this->oConfig->get('statsd')['port']
                                );
                $_sNamespace = $this->oConfig->get('statsd')['namespace'];
                $this->oStatsd = new Statsd($_oConnection, $_sNamespace);
        }

	public function analyze()
	{
		foreach ($this->aRawData as $data)
		{
			var_dump($data);
		}
		return $this->aData;
	}

	public function send()
	{

	}
}
