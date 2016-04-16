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
	
	var gallery_next = function() {
	    console.log('next');
	}
	
	var gallery_previous = function() {
	    console.log('previous');
	}
	
	root_element.on('click', '.gallery-number', function(evt){
		var id = $(this).parent().attr('id').replace('gallery-numbers-','');
		gallery_setup( $('#gallery-'+id), id, gallery_next);
	});
	
	
	root_element.on('click', '.gallery-right', function(evt){
		
		var id = $(this).parent().attr('id').replace('gallery-','');
		gallery_setup( $('#gallery-'+id), id, gallery_next);
		
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
		gallery_setup( $('#gallery-'+id), id, gallery_previous);
	
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