<?php

	define('ENV', 'DEV');
	define('PERF', false);
	
	// Routing
	require('libs/php/AltoRouter.php');
	
	// page class
	require('app/php/page.php');
	require('app/php/elements.php');
	
	// page sources
	require("stubs/pages/navigation.php");
	

	// Start the router
	$router = new AltoRouter();
	$router->setBasePath('');
	

	// route to the pages and functions we want
	$router->map('GET', '/', "Site#index");
	$router->map('GET', '/page-2', "Site#page2"); 
	$router->map('GET', '/page/[*:page]', "Site#generic"); 
	$router->map('GET', '/api/page/[*:page]', "Site#api"); 

				
	// match current request url
	$match = $router->match();
	
	// call closure or throw 404 status
	if($match) {
		list( $controller, $action ) = explode( '#', $match['target'] );
		if ( is_callable(array($controller, $action)) ) {
		    
		    $obj = new $controller();
		    
		    call_user_func_array(array($obj,$action), array($match['params']));
		
		} else if ($match['target']==''){
		    
		    echo 'Error: no route was matched'; 
		    //possibly throw a 404 error
		
		} else {
		  
		    echo 'Error: can not call '.$controller.'#'.$action; 
		    //possibly throw a 404 error
		}
	}




?>