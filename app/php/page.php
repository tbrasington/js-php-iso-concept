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
		
		
		// render out the page html
		$this->render();

	}
	
	function page2() {
		$this->page_id = 'page-2';
		$obj=json_decode(file_get_contents('stubs/pages/page2.json'),true);
		$this->page_content = $obj['root'];
		
		// render out the page html
		$this->render();
	}
	
	function generic($id) {
		$this->page_id = '';
		$this->page_content = 'generic' . $id['page'];
		
		
		// render out the page html
		$this->render();
		
	}
	
	// basic remapping to json file
	function api($id) {
		
		$page_id =  $id['page'];
		
		// would be a db query of sorts
		if($page_id==='page-1'){
			$file = 'page1';
		} else if($page_id==='page-2'){
			$file = 'page2';
		} else {
			//404
		}
		
		$obj=json_decode(file_get_contents('stubs/pages/'.$file.'.json'),true);
 
		$json_site_structure = json_encode($obj, true);
		echo $json_site_structure;
		
	}
	
	function render() {
		
		if(ENV==='DEV') {
			
			$js_files = [
			// libraries
			"libs/js/jquery-2.2.2.min.js", "libs/js/underscore.js", "libs/js/grapnel.js",  "libs/js/fastdom.js", 
			// element modules
			"app/js/elements.js", 
				"app/js/modules/gallery.js", 
			// custom / generic app starter
			"index.js"
			];
			
			
			$css_files = ["app/css/base.css","app/css/elements.css"];

		} else {
			$js_files = ["deploy/js/concat.min.js"];
			$css_files = ["deploy/css/concat.min.css"];
		}
		
		// combine the site structure
		$site_structure_object = (object) [
			"title" => "Test Site",
			"meta" => "",
			"css" => $css_files,
			"js" => $js_files,
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
			$this->elements->page_header();
			$this->elements->css($site_structure_object->css);
			$this->elements->render($site_structure_object->root, $this->elements->body);
			
			$this->elements->js($site_structure_object->js, $this->elements->body);
			
			echo $this->elements->finish();
			
			// Performance
			if(PERF) {
				$end = microtime(true);
				$creationtime = ($end - $this->start);
				printf("Page created in %.6f seconds.", $creationtime);
			}
		}
	}

	function __destruct()	{
		
			
	}
}

?>