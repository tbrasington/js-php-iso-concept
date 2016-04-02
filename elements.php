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
	
	function heading($_data) {
		
		$data = $_data;	
  	
		$node = $doc->createElement($element_type);
		$node->setAttribute('id', $attributes['id']);
	}
	
	function __destruct() {
		
	}
}