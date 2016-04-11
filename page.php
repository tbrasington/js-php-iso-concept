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
	require("app/php/elements.php");
	$page = new elements();	
	
	// include any project specific libraries
	require("stubs/pages/navigation.php");
	
	
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
								"content" => dummy_api_call($page_id)
							]
						]
					],
					[
						"id" => "page_content",
						"type" =>"block",
						"content" => $page_content
					]
				]
			]
		]
	];
				

		
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
	

/*

*/


?>