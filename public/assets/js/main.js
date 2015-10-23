
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
    	console.log('clicked!');
        window.document.location = $(this).data("href");
    });
});