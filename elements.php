<?php
class elements {
	
	public $dom;
	public $html;
	public $head;
	public $body;
	
	function __construct()	{
		
		$this->dom = new DOMDocument;
		$this->html = $this->dom->appendChild($this->dom->createElement('html'));
		$this->head = $this->html->appendChild($this->dom->createElement('head'));
		$this->body = $this->html->appendChild($this->dom->createElement('body'));

	}
	
	function render($_data,$parent) {
		
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
	
	function __destruct() {
		
	}
}