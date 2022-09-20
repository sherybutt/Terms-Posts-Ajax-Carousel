jQuery( document ).ready( function($) {

	// Show the first tab and hide the rest
	$('.tabContent:first').show();
	
	// Click function
	$('.catsHolder p').click(function(event){
		event.preventDefault();
		$('.sliderContainer').html('');
		$('.catsHolder h4').removeClass('active');
		$(this).addClass('active');
		var selectedTabb = $(this).find('a').attr('href'); //Get anchor value
		$('.catsHolder p').css('pointer-events', 'none'); //Disbale anchor link
		
	
		var postDataa = {
			action: 'advancedAjaxTest',
			the_tab: selectedTabb
		}
		
		jQuery.ajax({
			url: ajax_object.ajax_url,
			type: 'post',
			data: postDataa,
		 }).done(function(response){
			console.log(response);
			var results = '<div class="owl-carousel slider-1">'
			$.each(response, function(index, object){
				 results += '<div class="item">';
					results += '<a href="'+ object.link +'">'+ object.name +'</a>';
					results += '</div>';	
			});
			results += '</div>';

			$('.sliderContainer').append(results);
			$('.catsHolder p').css('pointer-events', 'unset'); //enable anchor link on ajax complete
		 });

		 $( document ).ajaxComplete(function() {
			$('.owl-carousel.slider-1').owlCarousel({
			loop:true,
			margin:10,
			nav:true,
			dots: true,
			items: 1
			});
		});

	  });
	
	
	$('.owl-carousel.slider-1').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		dots: true,
		items: 1
	});

});