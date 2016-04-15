var elements = function() {
	
	var that = this;
	
	this.module = {}
	    
    /*
	  
	  renders new block tag
	    
	*/
    this.module.block = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.content_class || "";
	 	var _content = _data.content || "";
 	 	var base = { 
	 	 		element :  $("<div />", { "class" :"col  block " + _class_name}),
	 	 		children_element :  $("<div />", { "class" :"col " }) 
	 	 	};
	 	
	 	base.children_element.appendTo(base.element);
	 	
	 	return base;
    }
    
	/*
	  
	  renders a new image
	    
	*/
    this.module.image = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.content_class || "";
	 	var _content = _data.content || "";
 	 
 	 	var base = { 
 	 		element: $("<img />", {
                "src":   _content 
            })
		};

	    base.element.on('load', function() {
	        base.element.addClass('fade-in');
	    });
	 	
	 	return base;
    }
    

    /*
	  
	  renders new h tag
	    
	*/
    this.module.heading = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.content_class || "";
	 	var _content = _data.content || "";
	 	
	 	var base = { element :  $("<h />", { "class" : _class_name }).text(_content) };
	 	
	 	return base;
    }
    /*
	  
	  renders new p tag
	    
	*/
    this.module.paragraph = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.content_class || "";
	 	var _content = _data.content || "";
	 	
	 	var base = { element :  $("<p />", { "class" : _class_name }).text(_content) };
	 	
	 	return base;
    }
    
    
    	
    /*
	  
	  renders a new text card that has a nice pastel background
	    
	*/
	
    this.module.text_card = function(data) {
	 	
	 	var _data  = data || "";
	 	var _class_name = _data.content_class || "";
	 	var _content = _data.content || "";
 	 	var base = { 
	 	 		element :  $("<div />", { "class" :"col  text-card margin-2-bottom " + _class_name}),
	 	 		children_element :  $("<div />", { "class" :"col text-card-content" }) 
	 	 	};
	 	
	 	base.children_element.appendTo(base.element);
	 	
	 	return base;
    }
    

    /*
	  
	  renders through all the modules of a page
	    
	*/

    this.render_modules = function(data, parent, folder) {

        _.each(data, function(item, index) {

       //
  	        if(that.module[item.module_type] !== undefined) {
	            var module = new that.module[item.module_type](item);
					module.element.appendTo(parent);
		      
	            // has children render more
	            if (typeof(item.content) === 'object') {
	                that.render_modules(item.content, module.children_element, folder)
	            }
            } else {
	            console.info('module does not exist');
            }
        });
    }
    
    /*
		
		start
		    
	*/
    this.render_page = function(data, parent, callback) {
 
        var folder = data.folder || "";
        folder = '/app/files/' + folder
       
        var content = data.content || "";
        var parent = parent || $('body');
     
		that.render_modules(content, parent, folder);
		 
		if(callback) callback();
    }
	
	return that;
	
}