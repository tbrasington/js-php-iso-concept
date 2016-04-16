(function(){
	
	$(document).ready(function(){
		
		
		// Page set up
		var dom_elements = {
			root: $("#root"),
			page_content : $("#page_content"),
			navigation : $("#navigation")
		}
		
		// set up our page render
		var render_elements = new Elements();
			
		// routers
		// handle the routing
		var router = new Grapnel({
			pushState: true,
			root: "/"
		});
		
		var first_load = true;
		
		// page routers
		router.get('', function(req, e) {
			
			load_page('api/page/page-1');

			
		}).get('page-2', function(req, e) {
			load_page('api/page/page-2');
		});
		
		// click events
		dom_elements.root.on("click", "a", function(evt) {
			if ($(this).hasClass('external') == false) {
				evt.preventDefault();
				router.navigate($(this).attr('href'));
			}
		});


		function load_page(req){
			
			// as we don't want to re rerender the dom, only bootstrap
			if(!first_load) {
				
				dom_elements.page_content.empty();
			
				// load in a new page
				$.ajax({
					url : req,
					dataType : "json"
				}).done(function(data){
					
					render_elements.render_modules(data.root, dom_elements.page_content);
					
				});
					
			} else { 
				first_load = false;
			}
			//render_elements.re
		}
		
	});

})();