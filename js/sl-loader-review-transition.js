/*  Script for review transitions */





jQuery('a.pageLoader').click(function() {
	var currentPage = jQuery('div.page.active');
	jQuery(currentPage).next().addClass( 'active' );
	jQuery(currentPage).removeClass( 'active', 3000, 'easeOutBounce' );
});


jQuery('a.pageLoader-restart').click(function() {
	
	var currentPage = jQuery('div.page.active');
	jQuery(currentPage).removeClass( 'active', 3000, 'easeOutBounce' );
	jQuery('div.page1').addClass( 'active' );

});



function loopReviews() {
	jQuery('.customerReviews.loop div.page:hidden:first').fadeIn(700).delay(10000).fadeOut(700,function() {

		jQuery(this).appendTo($(this).parent());
		loopReviews();
	});

}

loopReviews();




