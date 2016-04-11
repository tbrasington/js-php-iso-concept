<?php
// combine the site structure
function dummy_api_call($current_page) {
	
	$data_object = (object) [
		[
			"type" =>"block",
			"class_name"=> "menu-item " . ($current_page==='page-1' ? 'selected' : ''),
			"content" => [
				[
					"type" =>"block",
					"class_name" => "menu-selected",
					"content" => "—"
				],
				[
					"type" =>"a",
					"class_name" => "menu-list-item",
					"content" => "Page 1",
					"href"  =>"/page-1"
				]
			]
		],
		[
			"type" =>"block",
			"class_name"=> "menu-item ". ($current_page==='page-2' ? 'selected' : ''),
			"content" => [
				[
					"type" =>"block",
					"class_name" => "menu-selected",
					"content" => "—"
				],
				[
					"type" =>"a",
					"class_name" => "menu-list-item",
					"content" => "Page 2",
					"href"  =>"/page-2"
				]
			]
		]
	];
	
	return $data_object;	
}
?>