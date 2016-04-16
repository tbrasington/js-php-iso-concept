var Elements = function(options) {
	
	var that = this;
	
	var options = options || {}
	
	this.module = {}
	
	
    /*
	  
	  renders through all the modules of a page
	    
	*/

    this.render_modules = function(data, parent, folder) {

        _.each(data, function(item, index) {

       //
  	        if(that.module[item.module_type] !== undefined) {
	           
	            var module = new that.module[item.module_type](item);
					
				// When we have as more complex node
				if(module.elements.node) {
					module.elements.node.appendTo(parent);
					var target = module.elements.child
					console.log(target)
				} else {
					module.elements.appendTo(parent);
					target = module.elements;
				}
	      
	            // has children render more
	            if (typeof(item.content) === 'object') {
	                that.render_modules(item.content, target, folder)
	            }
		            
            } else {
	            console.info('module does not exist');
            }
        });
    }
    
    
	    
	/////////////////////////////////
	// bigger building blocks like , blocks and gallery
	/////////////////////////////////
    /*
	  
	  renders new block tag
	    
	*/
    this.module.block = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.class_name || "";
	 	var _content = _data.content || "";
 	 	var base = { 
 	 		elements :  $("<div />", { "class" :"basics " + _class_name})
 	 	};
	 	
	 	
	 	return base;
    }
    
    /*
	  
	  renders new gallery module
	    
	*/
    this.module.gallery = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.class_name || "";
	 	var _content = _data.content || "";
	 	var unique_id = _.uniqueId();
 	 	var base = { 
 	 		elements :  {
	 	 		node: $("<div />", { "class" :"gallery" + _class_name, "id" : "gallery-"+unique_id}),
	 	 		child: $("<div />", { "class" :"gallery-card-container", "id" : "gallery-card-container-"+unique_id}),
	 	 		numbers: $("<div />", { "class" :"gallery-numbers", "id" : "gallery-numbers-"+unique_id})
	 	 	}
 	 	};
 	 	
	 	// render the container for the gallery
	 	base.elements.child.appendTo(base.elements.node);
	 	
	 	// count the numbers
	 	var total_numbers = _.size(_content);
	 	if(total_numbers>1) {
	 		// render the numbers
	 		base.elements.numbers.appendTo(base.elements.node);
		 	for(var a =0; a<total_numbers; a++){
			 	var number = $("<div />", { "class" :"gallery-number", "text" : Math.ceil(a+1)}).appendTo(base.elements.numbers);
		 	}
		 	
		 	var left_arrow = $("<div />", { "class" :"gallery-arrows gallery-left"}).appendTo(base.elements.node);
		 	var right_arrow = $("<div />", { "class" :"gallery-arrows gallery-right"}).appendTo(base.elements.node);
	 	}
	 	
	 	return base;
    }
    
	/*
	  
	  renders a new image
	    
	*/
    this.module.image = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.class_name || "";
	 	var _content = _data.content || "";
 	 
 	 	var base = { 
 	 		elements: $("<img />", {
                "src":   _content 
            })
		};

	    base.elements.on('load', function() {
	        base.elements.addClass('fade-in');
	    });
	 	
	 	return base;
    }
    
	/////////////////////////////////
	// text, headings, paragraph, links
	/////////////////////////////////

    /*
	  
	  renders new h tag
	    
	*/
    this.module.heading = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.class_name || "";
	 	var _content = _data.content || "";
	 	
	 	var base = { elements :  $("<h />", { "class" : _class_name }).text(_content) };
	 	
	 	return base;
    }
    /*
	  
	  renders new p tag
	    
	*/
    this.module.paragraph = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.class_name || "";
	 	var _content = _data.content || "";
	 	
	 	var base = { elements :  $("<p />", { "class" : _class_name }).text(_content) };
	 	
	 	return base;
    }
    
    /*
	  
	  renders new a tag
	    
	*/
    this.module.a = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.class_name || "";
	 	var _content = _data.content || "";
	 	var _href = _data.href || "";
	 	
	 	var base = { elements :  $("<a />", { "class" : _class_name, "href" : _href }).text(_content) };
	 	
	 	return base;
    }
    
    
    // event delegations
    this.events = function() {
	    
	    // check that we have a root to delegate off
	    if(options.root) {
		    
		    // events for the gallery
		    module_events_gallery(options.root);
		    
	    } else {
		    // there is no root set so don't bother
	    }
	    
    }
    
	
	return that;
	
}