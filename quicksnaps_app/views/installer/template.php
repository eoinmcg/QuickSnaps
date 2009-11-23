<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>QuickSnaps - Installer</title>

<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/admin.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/admin/css/installer.css" type="text/css" media="screen" />


</head>


<body id="installer">

<div id="header">
	<h1>QuickSnaps <small>Installer</small></h1>
</div>


<div id="wrap"><div id="main">

		<h1><?php echo $title; ?></h1>

		<?php $this->load->view('installer/'.$view); ?>

	</div>


</div></div>

</body>

</html>
