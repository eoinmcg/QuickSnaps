
$(document).ready(function() {


//	basic effects for smoother UX
//
	$('.error').hide().fadeIn(1000);
	$('.info').hide().fadeIn(1000);

    if(QUICKSNAPS.growl)
    {
      $.jGrowl(QUICKSNAPS.growl);
    }

	$('table tr').hover(
		function () {
			$(this).addClass('ruled');
	}, 
		function () {
			$(this).removeClass('ruled');
	});


	$('.photo_block').equalHeights();
	$('.theme').equalHeights();


	$('a.delete').click(
		function() {
			var answer = confirm('Delete "'+jQuery(this).attr('title')+'" ?');
			return answer;
	});

    $('form input, form textarea, form select, form checkbox').focus(function () {
        $(this).parents('div:first').addClass('active');
    });
    $('form input, form textarea, form select, form checkbox').blur(function () {
        $(this).parents('div:first').removeClass('active');
    });

    $('#reOrder li').addClass('draggable');

//    $('form#crop').show();


//	image editing options on the photo thumbnail page
//
	$('.photo_block .caption').hide();

	$('.img_wrap').click(function(){
		$('.photo_block .caption').hide();
		$(this).next('.caption').fadeIn(500);
		return false;
	});


	$('body').click(function(){
		$('.photo_block .caption').fadeOut('fast');		
	});


	$('a.close').click(function(){
		$(this).parent('.caption').fadeOut('fast');
		return false;
	});


	$('a#quick_tour').click(function(){
		$('#tour_body').toggle();
        return false;
	});



//	$('a#quick_tour').click(function()){
//		$('#tour_body').toggle();
//	});

//	fadeout image libray path if gd/ gd2 selected
//
	if(document.getElementById('lib'))
	{
		toggleLibPath();
	}

	$('#lib').change(function() 
	{
		toggleLibPath();
	});


//	jCrop set up
//
	var jcrop_api;
	var i, ac;
	var ratio = 4/3;
	

	if(document.getElementById('cropbox'))
	{
		jcrop_api = $.Jcrop('#cropbox');
		jcrop_api.release();

//        $('form#crop').submit(function() {
//            return checkCoords();
//        });

	    jQuery('#cropbox').Jcrop({
		    onChange: showCoords,
		    onSelect: showCoords
	    });

	}



	$('#release').click(function(e) {
		// Release method clears the selection
		jcrop_api.release();
        jQuery('#w').val(0);
		jQuery('#y').val(0);
		jQuery('#w').val(0);
		jQuery('#h').val(0);
		return false;
	});


	$('#orientation').change(function () {

		switch($('#orientation').val())
		{
			case 'Portrait':
				var ratio = 3/4;
			break;

			case 'Landscape':
				var ratio = 4/3;
			break;

            default:
                var ration = 0;
            break;

		}

		jcrop_api.setOptions({ aspectRatio: ratio });

	});



// rotate image
    $('a.rotate').click(function() {

    return true;
    // the above line overrides the ajax rotate

    var newSrc      =  $('img#cropbox').attr('src')+'1';
    var newWidth    =  $('img#cropbox').attr('height');
    var newHeight   =  $('img#cropbox').attr('width');

        $.ajax({
            url: this.href,
            type: 'GET',
            data: '',
            success: function(feedback) {

                    $('#cropbox_wrap').fadeOut('slow', function () {

                        $('#cropbox_wrap img').remove();
                        $('.jcrop-holder').remove();

                        var rotateImage = jQuery(document.createElement('img'));
                        rotateImage.attr('id', 'cropbox')
                        $('#cropbox_wrap').append(rotateImage);

                        $('img#cropbox').attr('src', newSrc);
                        $('img#cropbox').attr('width', newWidth);
                        $('img#cropbox').attr('height', newHeight);

                    });


                    $('#cropbox_wrap').fadeIn('fast', function () {
		                jcrop_api.release();
                        jcrop_api.destroy();
                        jQuery('#w').val(0);

		                jcrop_api = $.Jcrop('#cropbox');

	                    jQuery('#cropbox').Jcrop({
		                    onChange: showCoords,
		                    onSelect: showCoords
	                    });

		                jcrop_api.release();
                    });



                    $.jGrowl(feedback);

            },
            error: function(){
                $.jGrowl('Error rotating photo');
            }
        });

        return false;


    });


// crop image
$('form#crop').submit(function () {

		if (!parseInt(jQuery('#w').val())) 
        {
		    alert('Please select a crop region then press submit.');
		    return false;
        }
        else
        {
            return true;
            // the above line overrides the ajax crop
        }

        var newSrc      =  $('img#cropbox').attr('src')+'1';
        var coords = $(this).serialize();
        var url = $('form#crop').attr('action');


                $.ajax({
                    url: $('form#crop').attr('action'),
                    type: 'POST',
                    data: coords,
                    // complete: function(){},
                    success: function(feedback) {

                        $('#cropbox_wrap').fadeOut('slow', function () {

                            $('#cropbox_wrap img').remove();
                            $('.jcrop-holder').remove();

                            var rotateImage = jQuery(document.createElement('img'));
                            rotateImage.attr('id', 'cropbox')
                            $('#cropbox_wrap').append(rotateImage);

                            $('img#cropbox').attr('src', newSrc);
                            $('#img#cropbox').load(function() {
                                var newW = $('img#cropbox').attr('width');
                                var newH = $('img#cropbox').attr('height');
                                $('img#cropbox').attr('width', newW);
                                $('img#cropbox').attr('height', newH);
                            });

                        });


                        $('#cropbox_wrap').fadeIn('fast', function () {
		                    jcrop_api.release();
                            jcrop_api.destroy();
                            jQuery('#w').val(0);

		                    jcrop_api = $.Jcrop('#cropbox');

	                        jQuery('#cropbox').Jcrop({
		                        onChange: showCoords,
		                        onSelect: showCoords
	                        });

		                    jcrop_api.release();
                        });



                        $.jGrowl(feedback);

            },
                    error: function(){
                        $.jGrowl('Crop Fail!');
                        return false;
                    }
                });


        return false;


});




});



	function toggleLibPath() {

		if($('#lib').val() == 'ImageMagick' || $('#lib').val() == 'netbm')
		{
			$('#lib_path').parent().fadeTo('slow', 1);
		}
		else
		{
			$('#lib_path').parent().fadeTo('slow', 0.1);
		}
	}



	function showCoords(c) {

		jQuery('#x').val(c.x);
		jQuery('#y').val(c.y);
		jQuery('#w').val(c.w);
		jQuery('#h').val(c.h);
	};



/*-------------------------------------------------------------------- 
 * JQuery Plugin: 'EqualHeights'
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



