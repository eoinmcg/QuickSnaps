
<p><?php echo anchor('admin/photos/show/'.$album, 'Back', array('class' => 'back')); ?></p>

<?php echo form_open_multipart('admin/photos/submit'); ?>

	<div class="hidden">
		<input type="hidden" name="album" value="<?php echo $album; ?>" />
	
	</div>

	<div>
		<label>Caption:</label>
		<input type="text" name="name" value="" />
	</div>


	<div>
		<label>Photo: </label>
 		<input name="photo" type="file" />


	</div>

	<div class="submit">
		<input type="submit" value="Save Photo" />
	</div>

</form>
