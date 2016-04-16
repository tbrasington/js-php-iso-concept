var Elements = function() {
	
	var that = this;
	
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
 	 	var base = { 
 	 		elements :  {
	 	 		node: $("<div />", { "class" :"gallery " + _class_name}),
	 	 		child: $("<div />", { "class" :"gallery-container "})
	 	 	}
 	 	};
	 	
	 	base.elements.child.appendTo(base.elements.node);
	 	
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
    
    
	
	return that;
	
}