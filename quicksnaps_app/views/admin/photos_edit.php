

<p>
    <?php echo anchor($back, 'Back', array('class' => 'back')); ?>
    | 
    <?php echo anchor($delete, 'Delete', array('class' => 'delete', 'title' => $query->name)); ?>
</p>

<?php echo form_open_multipart('admin/photos/submit'); ?>

	<div class="hidden">
		<input type="hidden" name="id" value="<?php echo $query->id; ?>" />
		<input type="hidden" name="album" value="<?php echo $album; ?>" />
	
	</div>

	<div>
		<label>Caption:</label>
		<input type="text" name="name" value="<?php echo $query->name; ?>" />
	</div>


	<div>
		<label>Cover Photo</label>
		<input type="checkbox" name="highlight" <?php if($query->highlight) echo 'checked="checked"'; ?> />
	</div>


	<div>
		<label>Photo: </label>
 		<input name="photo" type="file" />
		<?php
			if(!$query->photo) 
			{
				echo 'No photo uploaded';
			}
		?>

	</div>


	<div class="submit">
		<input type="submit" value="Save Changes" />
	</div>

</form>

	<?php 
        if($query->photo): 
    ?>


	<div id="manipulate_image">


		<h3>Rotate Photo</h3>
                <?php echo anchor('admin/photos/rotate/'.$query->id.'/right', 'Left', array('id' => 'rotate_left', 'class' => 'rotate')); ?>
                | 
                <?php echo anchor('admin/photos/rotate/'.$query->id.'/left', 'Right', array('id' => 'rotate_right', 'class' => 'rotate')); ?>

            <div id="cropbox_wrap">
			    <img src="<?php echo base_url().$query->photo.'_mid'.$query->photo_type.'?x='.time(); ?>" 
                    alt="<?php echo $query->name; ?>" width="<?php echo $image_size[0]?>" height="<?php echo $image_size[1]?>" id="cropbox" />
            </div>

            <div id="cropform_wrap">
		        <h3>Crop Photo</h3>

                <?php $atts = array('id' => 'crop'); ?>
                <?php echo form_open('admin/photos/crop/'.$query->id, $atts); ?>
				    <div>
				    <input type="hidden" id="x" name="x" />
				    <input type="hidden" id="y" name="y" />
				    <input type="hidden" id="w" name="w" />
				    <input type="hidden" id="h" name="h" />
				    <input type="submit" value="Crop Image" id="crop_button" />
				    <button id="release">Clear</button>
				    <label for="orientation">Orientation</label>
					    <select name="orientation" id="orientation">
						    <option value="" selected="selected">Orientation: Free</option>
						    <option value="Portrait">Orientation: Portrait</option>
						    <option value="Landscape">Orientation: Landscape</option>
					    </select>
				
				    </div>

			    </form>
            </div>

	</div>


	<?php endif; ?>

