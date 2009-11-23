$(document).ready(function(){
		
	$('.thumbnail').equalHeights();

	$('.album').pinball();


//  Insert a login form into the DOM using jQuery
    var loginForm = jQuery(document.createElement('form'));
    loginForm.attr('id', 'login_form');
    loginForm.attr('method', 'post');
    loginForm.attr('action', $('a#login_link').attr('href'));
    $('#extraDiv1').append(loginForm);

    var inputUser = jQuery(document.createElement('input'));
    inputUser.attr('type', 'text');
    inputUser.attr('name', 'uname');
    inputUser.attr('id', 'uname');
    $('#login_form').append(inputUser);

    var inputPass = jQuery(document.createElement('input'));
    inputPass.attr('type', 'password');
    inputPass.attr('name', 'pword');
    inputPass.attr('id', 'pword');
    $('#login_form').append(inputPass);

    var inputLogin = jQuery(document.createElement('input'));
    inputLogin.attr('type', 'hidden');
    inputLogin.attr('name', 'login');
    inputLogin.attr('id', 'login');
    inputLogin.attr('value', 'true');
    $('#login_form').append(inputLogin);

    var inputSubmit = jQuery(document.createElement('input'));
    inputSubmit.attr('type', 'submit');
    inputSubmit.attr('value', 'Login');
    $('#login_form').append(inputSubmit);

    $('a#login_link').click(function () {
        $('#login_form').toggle('slow');
        return false;
    });



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

	var originalBG = "#FBFCE7";
	var fadeColor = "#D4DD55";

	this.each(function() {

		var $this = $(this);

			$this.hover(function(e) {
				$(this).animate({ backgroundColor: fadeColor }, "fast");
				$this.addClass('active');

			}, function() {
				$(this).animate({ backgroundColor: originalBG }, "fast");
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



/*
 * jQuery Color Animations
 * Copyright 2007 John Resig
 * Released under the MIT and GPL licenses.
 */

(function(jQuery){

	// We override the animation for all of these color styles
	jQuery.each(['backgroundColor', 'borderBottomColor', 'borderLeftColor', 'borderRightColor', 'borderTopColor', 'color', 'outlineColor'], function(i,attr){
		jQuery.fx.step[attr] = function(fx){
			if ( fx.state == 0 ) {
				fx.start = getColor( fx.elem, attr );
				fx.end = getRGB( fx.end );
			}

			fx.elem.style[attr] = "rgb(" + [
				Math.max(Math.min( parseInt((fx.pos * (fx.end[0] - fx.start[0])) + fx.start[0]), 255), 0),
				Math.max(Math.min( parseInt((fx.pos * (fx.end[1] - fx.start[1])) + fx.start[1]), 255), 0),
				Math.max(Math.min( parseInt((fx.pos * (fx.end[2] - fx.start[2])) + fx.start[2]), 255), 0)
			].join(",") + ")";
		}
	});

	// Color Conversion functions from highlightFade
	// By Blair Mitchelmore
	// http://jquery.offput.ca/highlightFade/

	// Parse strings looking for color tuples [255,255,255]
	function getRGB(color) {
		var result;

		// Check if we're already dealing with an array of colors
		if ( color && color.constructor == Array && color.length == 3 )
			return color;

		// Look for rgb(num,num,num)
		if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color))
			return [parseInt(result[1]), parseInt(result[2]), parseInt(result[3])];

		// Look for rgb(num%,num%,num%)
		if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*,\s*([0-9]+(?:\.[0-9]+)?)\%\s*\)/.exec(color))
			return [parseFloat(result[1])*2.55, parseFloat(result[2])*2.55, parseFloat(result[3])*2.55];

		// Look for #a0b1c2
		if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color))
			return [parseInt(result[1],16), parseInt(result[2],16), parseInt(result[3],16)];

		// Look for #fff
		if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color))
			return [parseInt(result[1]+result[1],16), parseInt(result[2]+result[2],16), parseInt(result[3]+result[3],16)];

		// Otherwise, we're most likely dealing with a named color
		return colors[jQuery.trim(color).toLowerCase()];
	}
	
	function getColor(elem, attr) {
		var color;

		do {
			color = jQuery.curCSS(elem, attr);

			// Keep going until we find an element that has color, or we hit the body
			if ( color != '' && color != 'transparent' || jQuery.nodeName(elem, "body") )
				break; 

			attr = "backgroundColor";
		} while ( elem = elem.parentNode );

		return getRGB(color);
	};

	
})(jQuery);




