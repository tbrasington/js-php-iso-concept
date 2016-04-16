<?php
class Elements {
	
	public $dom;
	public $html;
	public $head;
	public $body;
	
	
	function __construct()	{
		

	}
	
	function page_header() {
		
		$this->dom = new DOMDocument;
		$this->html = $this->dom->appendChild($this->dom->createElement('html'));
		$this->head = $this->html->appendChild($this->dom->createElement('head'));
		
		$this->meta_viewport = $this->head->appendChild($this->dom->createElement('meta'));
		$this->meta_viewport->setAttribute("name","viewport");
		$this->meta_viewport->setAttribute("content","width = device-width, initial-scale = 1.0 ,  minimum-scale = 1.0,  maximum-scale=1.0");
		


		$this->body = $this->html->appendChild($this->dom->createElement('body'));
		
	}
	
	// rendrers an array of css files into the page

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
	
	// start the process of going through a node of content
	// this is the root block in the Array/Json
	function render($_data,$parent) {
		
		foreach ($_data as $attribute) {
			
			//print_r($attribute);
			
			$element_type = $attribute['module_type'];

			if( method_exists($this, $element_type) ) {
				
				$node = $this->$element_type($attribute);	
				
				// works out whether we want this item rendered stragith into it, or into its child container
				if(is_array($node)) {
					// apprend the main node 
					$parent = $parent->appendChild($node['node']);
					// then tell any next content to render into here
					$target = $node['child'];
					
				}	else {
					// or this just renders in
					$target = $parent->appendChild($node);
															
				}	
				// if the content is an array, it has child nodes that need rendering						
				if ( is_array($attribute['content'])){
					// loop
					// check where we are placing the node
					$child_content = $this->render($attribute['content'], $target);
				} else {
					// nothing else
				}
			}

		}
	}
	
	// renders out all of the html on to the page
	function finish() {
				
		// rener the page out
		$this->dom->formatOutput = true;
		return $this->dom->saveHTML();
	}
	
	
	/////////////////////////////////
	// bigger building blocks like , blocks and gallery
	/////////////////////////////////
	
	
	// A basic block
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
		
		// as we want this module to have some targeting
		$node_children = $this->dom->createElement("div");
		$node_children->setAttribute('class', 'gallery-card-container');
		$node->appendChild($node_children);
		
		if(isset($data['id'])) $node->setAttribute('id', $data['id']);
			if(isset($data['class_name']))  { 
			$node->setAttribute('class', "gallery " . $data['class_name']);
		} else {
			$node->setAttribute('class', "gallery");
		}
		
		// create the numbers 
		$total_numbers = sizeof($data['content']);
		if($total_numbers>1){
			$numbers = $this->dom->createElement("div");
			$numbers->setAttribute('class', 'gallery-numbers');
			
			$node->appendChild($numbers);
			
			for($a = 0; $a<$total_numbers; $a++) {
					
				$number = $this->dom->createElement("div");
				$number->setAttribute('class', 'gallery-number');
				$number->appendChild($this->dom->createTextNode(ceil(1+$a)));
				$numbers->appendChild($number);
			}
			
			// also add some left and right arrows
			$left = $this->dom->createElement("div");
			$left->setAttribute('class', 'gallery-arrows gallery-left');
			$node->appendChild($left);
			
			$right = $this->dom->createElement("div");
			$right->setAttribute('class', 'gallery-arrows gallery-right');
			$node->appendChild($right);
			
		}
			
		
		return ["node" => $node, "child" => $node_children];
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
		
		if(is_string($data['href'])) { 
			$node->setAttribute('href',$data['href']);
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