<?php

require __SITE_PATH . '/vendor/' . 'autoload.php';

use Laudis\Neo4j\Authentication\Authenticate;
use Laudis\Neo4j\ClientBuilder;

class DB
{
	private static $client = null;

	private function __construct() { }
	private function __clone() { }

	public static function getConnection() 
	{
		if( DB::$client === null ) {
	    	$client = ClientBuilder::create()
				->withDriver('aura', 'neo4j+s://0df6d930.databases.neo4j.io', Authenticate::basic('neo4j', 'lv5PdN16PMP3JdPnaRMImoYN7E-VgJrQAZyIL3NqnJs'))
				->withDefaultDriver('aura')
				->build();

	    }
		return DB::$client;
	}
}

?>
