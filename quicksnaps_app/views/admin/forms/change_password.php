
<?php echo form_open('admin/dashboard/change_password'); ?>



	<div>
		<label>New Password:</label>
		<input type="password" name="password" value="" />
	</div>

	<div>
		<label>Confirm new Password:</label>
		<input type="password" name="passconf" value="" />
	</div>


	<div class="submit">
		<input type="submit" value="Save Changes"/>
	</div>

</form>


<?php if(!empty($msg)): ?>
	<div class="error">
		<p><?php echo $msg; ?></p>
	</div>
<?php endif; ?>

