<div class="info">

	<p>You have <?php echo $overview['albums']; ?> albums with a total of <?php echo $overview['photos']; ?> photos </p>

	<p>Maximum image upload size is limited to <b><?php echo $overview['max_upload']; ?></b></p>

	<p>
        You are using the <b><?php echo LIB; ?></b> 
            <?php if(LIB == 'ImageMagick') 
                { 
                    echo '<em>[ '.LIB_PATH.' ]</em>'; 
                } 
            ?> image library
        <br />
        Photos will be resized to <?php echo GALLERY_MID_W.'x'.GALLERY_MID_H; ?> 
        with a thumbnail size of <?php echo GALLERY_THUMB_W.'x'.GALLERY_THUMB_H; ?> 
    </p>

</div>

    <?php if(isset($win_imagemagick) && $win_imagemagick === TRUE): ?>
        <div class="warning">
            <p class="title">Detected Windows server running ImageMagick</p>
            <p>Please ensure that you set the path correctly! <em>e.g. 'C:\Program Files\ImageMagick-6...' etc</em></p>
        </div>
    <?php endif; ?>
