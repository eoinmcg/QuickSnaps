
<?php echo anchor('admin/albums', 'Back', array('class' => 'back')); ?>

<noscript>
    <div class="warning">
        <p>You must have javascript enabled for the reorder function to work</p>
    </div>
</noscript>

<ul id="reOrder">
		<?php foreach ($query->result() as $row): ?>
			<li id="photos-<?php echo $row->id;?>" class="photo_block">
					<img src="<?php echo $this->Gallery_model->album_cover($row->id); ?>" alt="" /> </a>

					<p>
						<?php echo $row->name;?>
					</p>
			</li>
		<?php endforeach; ?>
</ul>


