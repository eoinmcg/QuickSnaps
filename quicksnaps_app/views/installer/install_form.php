<div class="info">
	<p>We need to know a bit about your setup.</p>
</div>

<?php echo form_open('installer/create_database');?>



	<fieldset>
	<legend>Admin account</legend>
		<div>
			<label>Username:</label>
			<input type="text" name="uname" value="<?php echo $this->input->post('uname'); ?>" />
		</div>

		<div>
			<label>Password:</label>
			<input type="password" name="pword" value="<?php echo $this->input->post('pword'); ?>" />
		</div>
	</fieldset>


	<fieldset>
	<legend>Database</legend>
	<div>
		<label>Hostname:</label>
		<input type="text" name="hostname" value="localhost" />
	</div>


	<div>
		<label>Database:</label>
		<input type="text" name="database" value="<?php echo $this->input->post('database'); ?>" />
	</div>


	<div>
		<label>Username:</label>
		<input type="text" name="username" value="<?php echo $this->input->post('username'); ?>" />
	</div>

	<div>
		<label>Password:</label>
		<input type="password" name="password" value="<?php echo $this->input->post('password'); ?>" />
	</div>

	<div>
		<label>Prefix:</label>
		<input type="text" name="dbprefix" value="<?php echo $this->input->post('dbprefix'); ?>" />
	</div>

	<div>
		<label>Database Type:</label>
		<input type="dbdriver" name="dbdriver" value="mysql" />
	</div>

	<div class="submit">
		<input type="submit" value="Create Database">
	</div>
	</fieldset>

</form>

	<?php if(validation_errors()): ?>
	<div class="error">
		<?php echo validation_errors(); ?>
	</div>
	<?php endif; ?>

