
<?php echo anchor('admin/albums', 'Back', array('class' => 'back')); ?>

<div class="controls">
<?php echo anchor('admin/photos/new_photo/album-'.$album_id, 'New Photo', array('class' => 'control', 'id' => 'photo_single')); ?>
<?php echo anchor('admin/photos/uploadify/'.$album_id, 'Upload multiple photos', array('class' => 'control', 'id' => 'photo_multi')); ?>
<?php echo anchor('admin/albums/edit/'.$album_id, 'Edit Album Info', array('class' => 'control', 'id' => 'album_edit')); ?>
</div>

<noscript>
    <div class="warning">
        <p>You must have javascript enabled for the reorder function to work</p>
    </div>
</noscript>

<ul id="reOrder">
		<?
			foreach ($query->result() as $row): 

				$class = ($row->highlight) ? 'highlight photo_block' : 'photo_block';
                $img = '<img src="'.base_url().$row->photo.'_thumb'.$row->photo_type.'"  alt="'.$row->name.'" />';

		?>
			<li id="photos-<?php echo $row->id?>" class="<?php echo $class; ?>">
				<?php if($row->highlight): ?>			
					<span>Cover Photo</span>			
				<?php endif; ?>

				<div class="img_wrap">
                    <?php echo anchor('admin/photos/edit/album-'.$album_id.'/'.$row->id, $img); ?>
				</div>



				<div class="caption">
                    <?php echo anchor('admin/photos/edit/album-'.$album_id.'/'.$row->id, 
                                        'Edit', array('class' => 'edit')); ?>
                    <?php echo anchor('admin/photos/delete/'.$row->id.'/'.$album_id, 
                                        'Delete', 
                                        array('class' => 'delete_ajax', 'title' => $row->name)); ?>
                    <?php echo anchor('admin/photos/highlight/'.$album_id.'/'.$row->id, 
                                        'Set as cover photo', 
                                        array('class' => 'make_default')); ?>
					<a href="#" class="close">
						[ Close ]
					</a>
				</div>

				<p>
                    <?php echo anchor(
                                'admin/photos/edit/album-'.$album_id.'/'.
                                $row->id, character_limiter($row->name, 10), 
                                array('class' => 'edit')); ?>
</p>

			</li>
		<?php endforeach; ?>
</ul>


