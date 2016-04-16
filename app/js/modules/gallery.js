// gallery
function module_events_gallery(root_element){
	
	var gallery_setup = function(el,id,callback){
	    
	    if(el.data('setup')) {
		    // run the callback
		    if(callback) callback();
	    } else {
		   
		   el.data({
			   'setup': true,
			   'id': id,
			   'position': 0,
			   'total': el.find('.gallery-card').length
			}); 
			
		   if(callback) callback();
	    }
	}
	
	var gallery_next = function(gallery) {
	    
	    
        var tmp_gallery_item = gallery.find('.gallery-current')
        tmp_gallery_item.addClass('gallery-animate-next');

        tmp_gallery_item.bind('transitionend', function(evt) {
            tmp_gallery_item.removeClass('gallery-animate-next')
        });

        //remove the peaking class
        tmp_gallery_item.removeClass('gallery-peaking-next');

        // the next item remove its peaking class
        var next_position = gallery.data('position') + 1;
	    if(next_position>=gallery.data('total')) next_position = 0; 
		
		var tmp_next_el = gallery.find('.gallery-card:eq('+next_position+")");
		tmp_next_el.removeClass('gallery-peak-next');

	    
	    gallery.data('position',next_position)
	    gallery_set_current(gallery);
	    
	}
	
	// prepare to go to the previous element
	var gallery_previous = function(gallery) {
	   
        var tmp_gallery_item = gallery.find('.gallery-current')
        tmp_gallery_item.addClass('gallery-animate-previous');

        tmp_gallery_item.bind('transitionend', function(evt) {
            tmp_gallery_item.removeClass('gallery-animate-previous')
        });

        //remove the peaking class
        tmp_gallery_item.removeClass('gallery-peaking-previous');

        // the next item remove its peaking class
        var next_position = gallery.data('position') - 1;
	    if(next_position<0) next_position = gallery.data('total')-1;  
		
		var tmp_next_el = gallery.find('.gallery-card:eq('+next_position+")");
		tmp_next_el.removeClass('gallery-peak-previous');

	    
	    gallery.data('position',next_position)
	    gallery_set_current(gallery);
	}
	
	// set the current element
	var gallery_set_current = function(gallery) {
		// card
		gallery.find('.gallery-current').removeClass('gallery-current');
		gallery.find('.gallery-card:eq('+gallery.data('position')+")").addClass('gallery-current');
		// numbers
		gallery.find('.gallery-number.selected').removeClass('selected');
		gallery.find('.gallery-number:eq('+gallery.data('position')+")").addClass('selected');
	}
	
	// number event
	root_element.on('click', '.gallery-number', function(evt){

		var id = $(this).parent().attr('id').replace('gallery-numbers-','');
		
		$('#gallery-'+id).data('position',$(this).data('position'));

		gallery_setup( $('#gallery-'+id), id, gallery_set_current($('#gallery-'+id)));
		
	});
	
	
	// hover events
	root_element.on('click', '.gallery-right', function(evt){
		var id = $(this).parent().attr('id').replace('gallery-','');
		gallery_setup( $('#gallery-'+id), id, gallery_next($('#gallery-'+id)));
		
	}).on('mouseenter', '.gallery-right', function(evt){
		
		var id = $(this).parent().attr('id').replace('gallery-','');
		gallery_setup($('#gallery-'+id), id, function() {
		
			var gallery_el = $('#gallery-'+id);
			var gallery_data = gallery_el.data();
			
			$('#gallery-'+id + ' .gallery-current').addClass('gallery-peaking-next');
			
				
			var tmp_next = gallery_data.position + 1;
			if (tmp_next >= gallery_data.total) tmp_next = 0;
			
			var tmp_next_el = $('#gallery-'+id + ' .gallery-card:eq('+tmp_next+")");
			tmp_next_el.addClass('gallery-peak-next');
	    });
		
	}).on('mouseleave', '.gallery-right', function(evt){
		var id = $(this).parent().attr('id').replace('gallery-','');
		$('#gallery-'+id + ' .gallery-current').removeClass('gallery-peaking-next');
		$('#gallery-'+id + ' .gallery-peak-next').removeClass('gallery-peak-next');
	});
	
	root_element.on('click', '.gallery-left', function(evt){

		var id = $(this).parent().attr('id').replace('gallery-','');
		gallery_setup( $('#gallery-'+id), id, gallery_previous($('#gallery-'+id)));
	
	}).on('mouseenter', '.gallery-left', function(evt){
		
		var id = $(this).parent().attr('id').replace('gallery-','');
		gallery_setup($('#gallery-'+id), id, function() {
		
			var gallery_el = $('#gallery-'+id);
			var gallery_data = gallery_el.data();
			
			$('#gallery-'+id + ' .gallery-current').addClass('gallery-peaking-previous');
			
				
			var tmp_next = gallery_data.position - 1;
			if (tmp_next<0 ) tmp_next = gallery_data.total-1;
			
			var tmp_next_el = $('#gallery-'+id + ' .gallery-card:eq('+tmp_next+")");
			tmp_next_el.addClass('gallery-peak-previous');
	    });
		
	}).on('mouseleave', '.gallery-left', function(evt){
		var id = $(this).parent().attr('id').replace('gallery-','');
		$('#gallery-'+id + ' .gallery-current').removeClass('gallery-peaking-previous');
		$('#gallery-'+id + ' .gallery-peak-previous').removeClass('gallery-peak-previous');
	});
	
	// end of gallery module function
}