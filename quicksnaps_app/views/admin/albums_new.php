<?php echo form_open_multipart('admin/albums/submit'); ?>

	<div class="hidden">
		<input type="hidden" name="id" value="" />
	
	</div>

	<div>
		<label>Name:</label>
		<input type="text" name="name" value="" />
	</div>


	<div>
		<label>Private?</label>
		<input type="checkbox" name="private" />
	</div>

	<div>
		<label>Theme:</label>
		<select name="theme">
			<?php foreach($themes as $theme):
				$selected = ($theme == GALLERY_THEME) ? ' selected="selected"' : '';
			?>
				<option value="<?php echo $theme; ?>"<?php echo $selected; ?>>
                    <?php echo $theme; ?>
                </option>

			<?php endforeach; ?>
		</select>
	</div>

	<div>
		<label>Description:</label>
		<textarea name="full_txt" rows="10" cols="25"></textarea>
	</div>



	<div class="submit">
		<input type="submit" value="Create Album" />
	</div>

</form>
