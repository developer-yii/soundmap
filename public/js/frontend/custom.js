
jQuery(document).ready(function(
	) {

	// Scroll to start
	jQuery('.scrolltotop').click(function(){
		jQuery('html').animate({'scrollTop' : '0px'}, 300);
		return false;
	});

	jQuery(window).scroll(function(){
		var upto = jQuery(window).scrollTop();
		if(upto > 500) {
			jQuery('.scrolltotop').fadeIn();
		} else {
			jQuery('.scrolltotop').fadeOut();
		}
	});

// Scroll to end

//search-bar
$('#show-search-box').click(function(){
  // $("#hidden-search-box").toggle();
  // $("#show-search-box").hide();
  $("#hidden-search-box").slideDown("fast");
  $("#myInput").focus();

});


$('#hidden-search-box .search-btn').click(function(){
	$("#hidden-search-box").slideUp("fast");
	// $("#show-search-box").show();
});

 










//main
});