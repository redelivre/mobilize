/**
 * Adjust the site-lead size for absolute positioning based on .entry-content height
 */
jQuery(document).ready(function() {
	var fontSize = parseFloat(jQuery("body").css("font-size"));
	
    // Add the 2em positioning in entry-content on the site-lead total height
    var contentHeight = jQuery(".site-lead .entry-content").css("height");
    contentHeight = parseInt(contentHeight, 10) + (fontSize * 2);
    jQuery(".site-lead").css("height", contentHeight);
});

jQuery(window).resize(function() {

	var fontSize = parseFloat(jQuery("body").css("font-size"));
	console.log(fontSize);

	// Get the page width in ems
	var pageWidthEm = jQuery(window).width() / fontSize;

	if ( pageWidthEm >= 64.063 ) {
		// Add the 2em positioning in entry-content on the site-lead total height
	    var contentHeight = jQuery(".site-lead .entry-content").css("height");
	    contentHeight = parseInt(contentHeight, 10) + (fontSize * 2);
	    jQuery(".site-lead").css("height", contentHeight);
	}
	else {
		jQuery(".site-lead").removeAttr("style");
	}
});