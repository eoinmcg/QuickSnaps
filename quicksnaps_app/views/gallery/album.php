<div id="wrap">

<?php
	if($referer):
?>
	<a id="back" href="<?php echo $referer; ?>">&laquo; Back</a>
<?php
	endif;
?>


<h2><?php echo $album; ?> <small><?php echo $num_photos; ?> photos</small></h2>

<div id="intro">
	<p><?php echo parse_smileys(nl2br($full_txt), base_url().'/assets/i/smileys/'); ?></p>

</div>

<?php
	foreach ($query->result() as $row):
    $img = '<img src="'.base_url().$row->photo.'_thumb'.$row->photo_type.'" alt="'.$row->name.'" />';
?>

	<div class="photo">
		<div class="frame">
            <?php echo anchor(base_url().$row->photo.'_mid'.$row->photo_type,
                $img, array('class' => 'frame', 'rel' => 'lightbox-album', 'title' => $row->name)); ?>
		</div>

		<div class="caption">
			<!--a href="<?php echo base_url().'index.php/gallery/view_photo/'.$album_url.'/'.$row->id; ?>">p</a-->
			<?php echo character_limiter($row->name, 10); ?>
		</div>
	</div>


<?php  endforeach;  ?>

</div>

