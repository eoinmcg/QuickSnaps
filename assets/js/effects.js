$(document).ready(function(){
		
	$('.photo').equalHeights();

	$('.album').pinball();

	$('a.frame').fancybox({
		'titlePosition' : 'inside',
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200
	});


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
        $('#login_form input:first').focus();
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



