
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
    	console.log('clicked!');
        window.document.location = $(this).data("href");
    });


    var searchbutton = $('.searchIcon');
	var searchBar = $('.searchBar');

    searchbutton.click(function(e){
		searchBar.toggleClass( 'sClosed');
    });
});

