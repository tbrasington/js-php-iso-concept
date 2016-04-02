<!DOCTYPE html>
<?php
	
include("elements.php");
$page = new elements();	


// echo the page out
$page->dom->formatOutput = true;
print $page->dom->saveHTML();

?>