<div class="info">
	<p>Complete the form below to create your Admin account.</p>
</div>

<?php echo form_open('installer/create');?>

	<div>
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo $this->input->post('username'); ?>" />
	</div>

	<div>
		<label>Password:</label>
		<input type="password" name="password" value="<?php echo $this->input->post('password'); ?>" />
	</div>

	<div>
		<label>Password Confirm:</label>
		<input type="password" name="passconf" value="<?php echo $this->input->post('passconf'); ?>" />
	</div>

	<div class="submit">
		<input type="submit" value="Create Admin Account">
	</div>

</form>

	<?php if(validation_errors()): ?>
	<div class="error">
		<?php echo validation_errors(); ?>
	</div>
	<?php endif; ?>
