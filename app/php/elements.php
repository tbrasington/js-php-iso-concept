<?php
class elements {
	
	public $dom;
	public $html;
	public $head;
	public $body;
	
// 	private $mustache;
	
	function __construct()	{
		
		$this->dom = new DOMDocument;
		$this->html = $this->dom->appendChild($this->dom->createElement('html'));
		$this->head = $this->html->appendChild($this->dom->createElement('head'));
		$this->body = $this->html->appendChild($this->dom->createElement('body'));
		
// 		$this->mustache = new Mustache_Engine;

	}
	
	function render($_data,$parent) {
		//print_r($_data);
		foreach ($_data as $attribute) {
			
			//print_r($attribute);
			
			$element_type = $attribute['type'];
			
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
		
	//	print_r($data);
  	
		$node = $this->dom->createElement("div");
		
		$node->setAttribute('id', $data['id']);
		
		
		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}
		
		return $node;
	}
	
	function heading($_data) {
		
		$data = $_data;	
  	
		$node = $this->dom->createElement("h");
		
		$node->setAttribute('id', $data['id']);
		
		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}

		return $node;		
	}
	
	
	function a($_data) {
		
		$data = $_data;	
  	
		$node = $this->dom->createElement("a");
		
		$node->setAttribute('id', $data['id']);
		
		if(is_string($data['content'])) { 
			$node->appendChild($this->dom->createTextNode($data['content']));
		}
		
		return $node;		
	}
	
	/*
function data_source($_data) {

		$data = $_data;	

		$node = $this->dom->createElement("div");
		
		$node->setAttribute('id', $data['id']);
		
		$data_source = file_get_contents($data['content']);	
		$json = json_decode($data_source);
		
		$child_content = $this->render($json, $node);


		return $node;
	}
*/
	
	function __destruct() {
		
	}
}