$(document).ready(function() {

//  Change Themes
    $('a.theme_change').click(function() {

        var block = $(this).parent('div.theme');

        $.ajax({
            url: this.href,
            type: 'GET',
            data: '',
            success: function(feedback){
               block.animate({'backgroundColor':'#FFFFB4'},300, function () {
                    $('.theme.active').animate({'backgroundColor':'#EFEFEF'},100)
                    .removeClass('active');

                    block.addClass('active');

                    $('.photo_block').equalHeights();
                    $.jGrowl(feedback);
                });

            },
            error: function(){
                $.jGrowl('Error changing theme!');
                return false;
            }
        });

        return false;

    });


//  Set new cover photo
    $('a.make_default').click(function() {

        var block = $(this).parents('li');

        $.ajax({
            url: this.href,
            type: 'GET',
            data: '',
            success: function(feedback){
                block.animate({'backgroundColor':'#FFFFB4'},300, function () {

                    $('.ui-sortable li.highlight').animate({'backgroundColor':'#EFEFEF'},100)
                    .removeClass('highlight');
                    $('.ui-sortable li span').remove();

                    var coverPhoto = jQuery(document.createElement('span'));
                    coverPhoto.html('Cover Photo');
                    block.addClass('highlight')
                    .prepend(coverPhoto);

                    $('.photo_block').equalHeights();

                    $.jGrowl(feedback);

                });
            },
            error: function(){
                $.jGrowl('Error!');
                return false;
            }
        });


        return false;

    });


//  delete photo
    $('.caption a.delete_ajax').click(function() {

    if(!confirm('Delete "'+jQuery(this).attr('title')+'" ?')) {
        return false;
    }

    var block = $(this).parents('li.photo_block');

        $.ajax({
            url: this.href,
            type: 'GET',
            data: '',
            success: function(feedback){
               	$('.photo_block .caption').hide();
                block.addClass('pre_delete')
                .fadeOut('slow', function () {
                    block.remove();
                    $.jGrowl(feedback);
                });

            },
            error: function(){
                $.jGrowl('Error deleting photo!');
            }
        });

        return false;

    });


//delete album
    $('tr.album_row a.delete_ajax').click(function() {

    if(!confirm('Delete "'+jQuery(this).attr('title')+'" ?')) {
        return false;
    }

    var row = $(this).parents('tr:first');

        $.ajax({
            url: this.href,
            type: 'GET',
            data: '',
            success: function(feedback) {
					row.addClass('pre_delete')
                    .fadeOut('slow')
                    $.jGrowl(feedback);

            },
            error: function(){
                $.jGrowl('Error deleting album!');
            }
        });

        return false;


    });


//reorder albums / photos
    $('#reOrder').sortable({
        opacity: '0.5',
            update: function(e, ui){
                serial = $(this).sortable('serialize');	
                $.ajax({
                    url: QUICKSNAPS.reorder,
                    type: 'POST',
                    data: serial,
                    // complete: function(){},
                    success: function(feedback){
                        $.jGrowl(feedback);
                        $('.photo_block .caption').hide();
                    },
                    error: function(){
                        $.jGrowl('Reorder Fail!');
                        return false;
                    }
            });
        }
    });




});




