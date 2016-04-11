<?php
	// Performance
	$start = microtime(true);


	// Routing
	require('libs/php/AltoRouter.php');
	
	
	// page class
	require('page.php');
	
	// Start the router
	$router = new AltoRouter();
	$router->setBasePath('');

	// this will need to be rewritten just as a routing page, the rest as a class for the page controlelr
	$router->map('GET', '/', "page1");
	$router->map('GET', '/page-2', "page2"); 


				
	// match current request url
	$match = $router->match();
	
	// call closure or throw 404 status
	if( $match && is_callable( $match['target'] ) ) {
		
		 call_user_func_array( $match['target'], $match['params'] ); 
	
		
	} else {
		// no route was matched
		header( $_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
	}

/*

*/


?>