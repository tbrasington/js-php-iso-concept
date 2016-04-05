<!DOCTYPE html>
<?php
// Performance
$start = microtime(true);
// Performance

// mustache
require 'libs/php/Mustache/Autoloader.php';
Mustache_Autoloader::register();
$mustache = new Mustache_Engine;

// page creator
include("elements.php");
$page = new elements();	


// get our page date
$site_structure = file_get_contents('stubs/site.json');	

/*
	Here we replace core features of the page that may change on page load
	
	Examples would be
	
	- Page title
	- Where the json for the content is for that page
		
*/


$mustached_site_structure_object =  $mustache->render($site_structure, array(
'page_title' => 'Thomas Brasington',
'navigation_file' => 'stubs/navigation.json', 
'content' => 'api page content' 
));



// turn it into json
$site_structure_object = json_decode($mustached_site_structure_object, TRUE);

// create the page elements
$page->render($site_structure_object['root']['content'], $page->body);

// rener the page out
$page->dom->formatOutput = true;
print $page->dom->saveHTML();

// Performance
$end = microtime(true);
$creationtime = ($end - $start);
printf("Page created in %.6f seconds.", $creationtime);
// Performance
?>