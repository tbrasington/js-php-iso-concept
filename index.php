<?php
	
	// Performance
	$start = microtime(true);
  
	// is this page html or json?
	if(isset($_GET["json"])) {
		$json_request = true;
	} else {
		$json_request = false;
	}
	
	// page creator
	include("app/php/elements.php");
	$page = new elements();	
	
	// Routing
	require('libs/php/AltoRouter.php');
	$router = new AltoRouter();
	
	$router->map( 'GET', '/', function() {
    	$page_content = array();
	});
	
	
	$router->map( 'GET', '/projects', function() {
    	$page_content = array();
	});


	
	$router->map( 'GET', '/cv', function() {
    	$page_content = array();
	});
	
	// combine the site structure
	$site_structure_object = (object)  [
		"title" => "Test Site",
		"meta" => "",
		"root" => [
			[
				"id" => "root",
				"type" =>"block",
				"content" => [
					[
						"id" => "header",
						"type" =>"block",
						"content" => [
							[
								"id" => "page_title",
								"type" =>"block",
								"content" => "Page Title"
							],
							[
								"id" => "menu_button",
								"type" =>"block",
								"content" => "Menu"
							]
						]
					],
					[
						"id" => "navigation",
						"type" =>"block",
						"content" => [
							[
								"id" => "navigation_close",
								"type" => "block",
								"content" => "close"
							],
							[
								"id" => "navigaton_content",
								"type" => "block",
								"content" => api_call()
							]
						]
					],
					[
						"id" => "page_content",
						"type" =>"block",
						"content" => "page_content"
					]
				]
			]
		]
	];
										 
	function api_call() {
		$file = file_get_contents("stubs/navigation.json");
		return  json_decode($file,true);
	}


	// return a json object of the page, just incase
	if($json_request) {
		$json_site_structure = json_encode(($site_structure_object), true);
		echo $json_site_structure;
	} else {
		
		$page->render($site_structure_object->root, $page->body);
		echo $page->finish();
		
		// Performance
		$end = microtime(true);
		$creationtime = ($end - $start);
		printf("Page created in %.6f seconds.", $creationtime);
	}


?>