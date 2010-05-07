<?php echo anchor('admin/photos/show/'.$query->id, 'Manage photos in this album', array('class' => 'photo')); ?>

<?php echo form_open_multipart('admin/albums/submit'); ?>

	<div class="hidden">
		<input type="hidden" name="id" value="<?php echo $query->id; ?>" />
	
	</div>

	<div>
		<label>Name:</label>
		<input type="text" name="name" value="<?php echo $query->name; ?>" />
	</div>

	<div>
		<label>Private?</label>
		<input type="checkbox" name="private" <?php if($query->private) echo 'checked="checked"'; ?> />
	</div>

	<div>
		<label>Theme:</label>
		<select name="theme">
			<?php foreach($themes as $theme):
				$selected = ($theme == $query->theme) ? ' selected="selected"' : '';
			?>
				<option value="<?php echo $theme; ?>"<?php echo $selected?>><?php echo $theme; ?></option>

			<?php endforeach; ?>
		</select>
	</div>



	<div>
		<label>Description:</label>
		<textarea name="full_txt" rows="10" cols="25"><?php echo $query->full_txt; ?></textarea>
	</div>



	<div class="submit">
		<input type="submit" value="Save Changes"/>
	</div>

</form>
