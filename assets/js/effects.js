$(document).ready(function(){
		
	$('.photo').equalHeights();

	$('.album').pinball();


});



/*-------------------------------------------------------------------- 
 * JQuery Plugin: "EqualHeights"
 * by:	Scott Jehl, Todd Parker, Maggie Costello Wachs (http://www.filamentgroup.com)
 *
 * Copyright (c) 2008 Filament Group
 * Licensed under GPL (http://www.opensource.org/licenses/gpl-license.php)
 *
 * Description: Compares the heights or widths of the top-level children of a provided element 
 		and sets their min-height to the tallest height (or width to widest width). Sets in em units 
 		by default if pxToEm() method is available.
 * Dependencies: jQuery library, pxToEm method	(article: 
		http://www.filamentgroup.com/lab/retaining_scalable_interfaces_with_pixel_to_em_conversion/)							  
 * Usage Example: $(element).equalHeights();
  		Optional: to set min-height in px, pass a true argument: $(element).equalHeights(true);
 * Version: 2.0, 08.01.2008


 * 29 May 09	- EDITED to work without dependencies & doesn't bother with children just the class passed to the fn
				- eoin@starfish.ie
--------------------------------------------------------------------*/

$.fn.equalHeights = function() {
	var currentTallest = 0;
	$(this).each(function(){

			if ($(this).height() > currentTallest) { currentTallest = $(this).height(); }
	});

	$(this).each(function(){

		$(this).css({'height': currentTallest}); 

	});

	return this;
};







/*
 * jQuery Pinball
 * Copyright 2009 Eoin McGrath
 * Released under the MIT and GPL licenses.
 */

(function($) {
	$.fn.pinball = function(options) {


	this.each(function() {

		var $this = $(this);

			$this.hover(function(e) {

				$this.addClass('active');

			}, function() {
				$this.removeClass('active');
			});

			$this.click(function (e) {
			  	var $link = $('a.target', this).attr("href");

				if($link) {
					window.location = $link;
				}

			});

		  });

		  return this;

	}
})(jQuery);



