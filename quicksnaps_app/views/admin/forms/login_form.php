<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/admin.css" type="text/css" media="screen" />


</head>


<body id="login">

<div id="header">
	<h1>QuickSnaps</h1>
</div>



	<div id="content">

		<h2>Login</h2>

        <?php echo form_open('admin/login'); ?>

			<div>
				<label>Username:</label>
				<input type="text" name="uname" value="<?php echo $this->input->post('uname'); ?>" />
			</div>

			<div>
				<label>Password:</label>
				<input type="password" name="pword"  />
			</div>


			<div class="submit">
				<input type="submit" name="login" value="Login" />
			</div>

		</form>

	</div>


		<?php echo $msg; ?>


</body>

</html>
