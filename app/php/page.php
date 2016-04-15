<?php
class Site {

	private $start;
	private $elements;
	private $page_id;
	private $page_content;
	private $json_request = false;
	
	function __construct()	{
		
		$this->start = microtime(true);
		$this->elements = new Elements;

	}
	
	function index() {
		$this->page_id = 'page-1';
		$obj=json_decode(file_get_contents('stubs/pages/page1.json'),true);
		$this->page_content = $obj['root'];

	}
	
	function page2() {
		$this->page_id = 'page-2';
		$obj=json_decode(file_get_contents('stubs/pages/page2.json'),true);
		$this->page_content = $obj['root'];
	}
	
	function generic($id) {
		$this->page_id = '';
		$this->page_content = 'generic' . $id['page'];
		
	}

	function __destruct()	{
		
		
		// combine the site structure
		$site_structure_object = (object) [
			"title" => "Test Site",
			"meta" => "",
			"css" => ["app/css/base.css","app/css/elements.css"],
			"js" => ["libs/js/jquery-2.2.2.min.js", "libs/js/underscore.js", "libs/js/grapnel.js", "app/js/elements.js", "index.js"],
			"root" => [
				[
					"id" => "root",
					"module_type" =>"block",
					"content" => [
						[
							"id" => "header",
							"module_type" =>"block",
							"content" => [
								[
									"id" => "page_title",
									"module_type" =>"block",
									"content" => "Page Title"
								],
								[
									"id" => "menu_button",
									"module_type" =>"block",
									"content" => "Menu"
								]
							]
						],
						[
							"id" => "navigation",
							"module_type" =>"block",
							"content" => [
								[
									"id" => "navigation_close",
									"module_type" => "block",
									"content" => "close"
								],
								[
									"id" => "navigaton_content",
									"module_type" => "block",
									"content" => dummy_api_call($this->page_id)
								]
							]
						],
						[
							"id" => "page_content",
							"module_type" =>"block",
							"content" => $this->page_content
						]
					]
				]
			]
		];
		
		// return a json object of the page, just incase
		if($this->json_request) {
			
			$json_site_structure = json_encode(($site_structure_object), true);
			echo $json_site_structure;
		
		} else {
			
			$this->elements->css($site_structure_object->css);
			$this->elements->js($site_structure_object->js);
			$this->elements->render($site_structure_object->root, $this->elements->body);
			echo $this->elements->finish();
			
			// Performance
			if(PERF) {
				$end = microtime(true);
				$creationtime = ($end - $this->start);
				printf("Page created in %.6f seconds.", $creationtime);
			}
		}	
	}
}

?>