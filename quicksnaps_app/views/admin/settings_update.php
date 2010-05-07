
<?php echo form_open('admin/settings/submit'); ?>


	<div>
		<label>Title:</label>
		<input type="text" name="name" value="<?php echo GALLERY_NAME; ?>" />
	</div>

	<div>
		<label>Summary:</label>
		<textarea name="summary" rows="5" cols="25"><?php echo GALLERY_SUMMARY; ?></textarea>
	</div>

	<div>
		<label>Theme:</label>
		<select name="theme">
			<?php foreach($themes as $theme):
				$selected = ($theme == GALLERY_THEME) ? ' selected="selected"' : '';
			?>
				<option value="<?php echo $theme?>"<?php echo $selected?>>
                    <?php echo $theme; ?>
                </option>

			<?php endforeach; ?>
		</select>
	</div>


	<div>
		<label>Albums per page:</label>
		<input type="text" name="per_page" class="small" value="<?php echo PER_PAGE; ?>" />
	</div>


	<div>
		<label>Photo Width:</label>
		<input type="text" name="mid_w" class="small" value="<?php echo GALLERY_MID_W; ?>" />
	</div>

	<div>
		<label>Photo Height:</label>
		<input type="text" name="mid_h" class="small" value="<?php echo GALLERY_MID_H; ?>" />
	</div>


	<div>
		<label>Thumb Width:</label>
		<input type="text" name="thumb_w" class="small" value="<?php echo GALLERY_THUMB_W; ?>" />
	</div>

	<div>
		<label>Thumb Height:</label>
		<input type="text" name="thumb_h" class="small" value="<?php echo GALLERY_THUMB_H; ?>" />
	</div>


	<div>
		<label>Image Library:</label>
			<select name ="lib" id="lib">
				<?php foreach($libs as $key => $val): ?>
					<option value="<?php echo $key?>"<?php if($key == LIB) { echo ' selected="selected"'; } ?>>
                        <?php echo $key?>
                    </option>
				<?php endforeach; ?>
			</select>
	</div>


	<div>
		<label>Path to Library:</label>
		<input type="text" name="lib_path" id="lib_path" value="<?php echo LIB_PATH; ?>" />
	</div>


	<div class="submit">
		<input type="submit" value="Save Changes" />
	</div>

</form>
