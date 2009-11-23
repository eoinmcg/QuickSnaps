<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>
        <?php if($private): ?>
            <?php echo $title; ?>
        <?php else: ?>
		    <?php echo GALLERY_NAME; ?>
	    <?php endif; ?>

    </title>
 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="author" content="Eoin McGrath - http://www.starfishwebconsulting.co.uk" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>themes/<?php echo $theme; ?>/style.css" type="text/css" media="screen" />

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.3.2.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/slimbox2.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slimbox2.css" media="screen" />

	<?php if(!empty($js)): ?>
    	<script type="text/javascript" src="<?php echo base_url();?>themes/<?php echo $theme; ?>/effects.js"></script>
	<?php else: ?>
    	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/effects.js"></script>
	<?php endif; ?>

	<?php if(!($favicon)): ?>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
	<?php else: ?>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>/themes/<?php echo $theme; ?>/favicon.ico" type="image/x-icon" />
	<?php endif; ?>





</head>

<body>



<div id="mast">

<h1>
	<?php if($private): ?>
		<?php echo $title; ?>
	<?php else: ?>
        <?php echo anchor('', GALLERY_NAME); ?>
	<?php endif; ?>
</h1>


</div>
<!--end #mast -->



