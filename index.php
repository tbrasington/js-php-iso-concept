<!DOCTYPE html>
<?php
$doc = new DOMDocument;
$html = $doc->appendChild($doc->createElement('html'));
$head = $html->appendChild($doc->createElement('head'));

 	
$script = $head->appendChild($doc->createElement('script'));
 	$script->setAttribute('src', 'libs/jquery-2.2.2.min.js');

$script = $head->appendChild($doc->createElement('script'));
 	$script->setAttribute('src', 'libs/underscore.js');

$script = $head->appendChild($doc->createElement('script'));
 	$script->setAttribute('src', 'index.js');
 	
 	
$body = $html->appendChild($doc->createElement('body'));
 
 
 
$site_structure = file_get_contents('stubs/site.json');	
$site_structure_object = json_decode($site_structure, TRUE);
	
	
	
foreach ($site_structure_object['root']['content'] as $attributes) {
	
	//print_r($attributes);
	
	$element_type = $attributes['type'];
	
	if($element_type==='block') {
		$element_type = 'div';
	}
   
    $node = $head->appendChild($doc->createElement($element_type));
	$node->setAttribute('id', $attributes['id']);

}

$doc->formatOutput = true;
print $doc->saveHTML();


// 	print_r($site_structure_object['root']);
?>