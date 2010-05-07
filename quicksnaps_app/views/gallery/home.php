<div id="wrap">

	<div id="intro">
		<?php echo parse_smileys(nl2br(GALLERY_SUMMARY), base_url().'/assets/i/smileys/'); ?>
	</div>

    <?php echo $paginate; ?>

	<?php foreach ($query->result() as $row): ?>

		<div class="album">

			<img src="<?php echo $this->Gallery_model->album_cover($row->id); ?>" alt=""/>
			
			<h3><?php echo $row->name;?> <small>(<?php echo $photos[$row->id]; ?> photos)</small></h3>

			<p><?php echo parse_smileys(nl2br($row->full_txt), base_url().'/assets/i/smileys/'); ?></p>

            <?php echo anchor('gallery/album/'.$row->url, 'View', array('class' => 'target view')); ?>
		</div>

	<?php  endforeach;  ?>

</div>




