<?php
class Elements {
	
	public $dom;
	public $html;
	public $head;
	public $body;
	
// 	private $mustache;
	
	function __construct()	{
		
		$this->dom = new DOMDocument;
		$this->html = $this->dom->appendChild($this->dom->createElement('html'));
		$this->head = $this->html->appendChild($this->dom->createElement('head'));
		
		$this->meta_viewport = $this->head->appendChild($this->dom->createElement('meta'));
		$this->meta_viewport->setAttribute("name","viewport");
		$this->meta_viewport->setAttribute("content","width = device-width, initial-scale = 1.0 ,  minimum-scale = 1.0,  maximum-scale=1.0");
		


		$this->body = $this->html->appendChild($this->dom->createElement('body'));
		
// 		$this->mustache = new Mustache_Engine;

	}
	
	// renderes an array of css files into the page

	function css($_data) {
		
		foreach ($_data as $css_file) {
				
				$css_element  = $this->head->appendChild($this->dom->createElement('link'));
				$css_element->setAttribute('rel','stylesheet');
				$css_element->setAttribute('type','text/css');
				$css_element->setAttribute('href',$css_file);
		}
	}
	
	// renderes an array of javascript files into the page, 
	// optional ability to load them into diffferent parts of the page
	function js($_data, $_parent = null) {
		
		
		$parent = (isset($_parent) ? $_parent :  $this->head);

		
		foreach ($_data as $js_file) {
				
				$css_element  = $parent->appendChild($this->dom->createElement('script'));
				$css_element->setAttribute('type','text/javascript');
				$css_element->setAttribute('src',$js_file);
		}
	}
	
	function render($_data,$parent) {
		
		foreach ($_data as $attribute) {
			
			//print_r($attribute);
			
			$element_type = $attribute['module_type'];

			if( method_exists($this, $element_type) ) {
				
				$node = $this->$element_type($attribute);	
				$rendered_node = $parent->appendChild($node);
				
				if ( is_array($attribute['content'])){
					// loop
					$child_content = $this->render($attribute['content'], $rendered_node);
				} else {
					// nothing else
				}
			}

		}
	}
	
	function finish() {
				
		// rener the page out
		$this->dom->formatOutput = true;
		return $this->dom->saveHTML();
	}
	
	function block($_data) {
		
		$data = $_data;	
		
  	
		$node = $this->dom->createElement("div");
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
		
		if(isset($data['class_name']))  { 
			$node->setAttribute('class', "basics " . $data['class_name']);
		} else {
			$node->setAttribute('class', "basics");
		}
		
		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}
		
		return $node;
	}
	
	// although its a block, we render in additioanl features such as arrows and numbers
	function gallery($_data) {
		
		$data = $_data;	
		
  	
		$node = $this->dom->createElement("div");
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
		if(isset($data['class_name'])) $node->setAttribute('class', $data['class_name']);

		
		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}
		
		return $node;
	}
	
	/////////////////////////////////
	// text, headings, paragraph, links
	/////////////////////////////////
	
	function heading($_data) {
		
		$data = $_data;	
  	
		$node = $this->dom->createElement("h");
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
		if(isset($data['class_name'])) $node->setAttribute('class', $data['class_name']);

		
		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}

		return $node;		
	}
	
	function paragraph($_data) {
		
		$data = $_data;	
  	
		$node = $this->dom->createElement("p");
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
		if(isset($data['class_name'])) $node->setAttribute('class', $data['class_name']);


		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}

		return $node;		
	}
	
	function a($_data) {
		
		$data = $_data;	
  	
		$node = $this->dom->createElement("a");
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
		if(isset($data['class_name'])) $node->setAttribute('class', $data['class_name']);

		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}
		
		return $node;		
	}
	
	/////////////////////////////////
	// images, gallery
	/////////////////////////////////
	
	function image($_data) {
		
		$data = $_data;	
  	
		$node = $this->dom->createElement("img");
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
		if(isset($data['class_name'])) $node->setAttribute('class', $data['class_name']);

		
		if(is_string($data['content'])) { 
				$node->setAttribute('src', $data['content']);	
		}

		return $node;		
	}
	
	
	function __destruct() {
		
	}
}