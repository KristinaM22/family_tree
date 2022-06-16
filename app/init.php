<?php

// Učitaj definiciju bazne klase za controllere.
require_once __SITE_PATH . '/app/' . 'controller_base.class.php';

// Učitaj definiciju registry klase.
require_once __SITE_PATH . '/app/' . 'registry.class.php';

// Učitaj definiciju routera.
require_once __SITE_PATH . '/app/' . 'router.class.php';

// Učitaj definiciju templatea.
require_once __SITE_PATH . '/app/' . 'template.class.php';

// Učitaj definiciju spoja na bazu podataka.
require_once __SITE_PATH . '/app/database/' . 'db.class.php';

spl_autoload_register( function( $class_name ) 
{
	$filename = strtolower($class_name) . '.class.php';
	$file = __SITE_PATH . '/model/' . $filename;

	if( file_exists($file) === false )
	    return false;

	require_once ($file);
} );

?>
