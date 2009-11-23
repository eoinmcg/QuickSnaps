<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo strip_tags($title).' | '.GALLERY_NAME; ?></title>

<meta http-equiv="Pragma" content="no-cache" />

<link type="text/css" rel='stylesheet' href="<?php echo base_url(); ?>assets/admin/css/admin.css" media="screen, projection" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/jquery.jgrowl.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/ajax.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/admin.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/slimbox2.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slimbox2.css" media="screen" />

<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo base_url(); ?>favicon.ico" type="image/x-icon" />


    <script type="text/javascript">

        var QUICKSNAPS = {};

        <?php
            if($this->session->flashdata('jgrowl'))
            {
                echo "QUICKSNAPS.growl = '".$this->session->flashdata('jgrowl')."'; ";
            }

            if(isset($album_id))
            {
                echo 'QUICKSNAPS.reorder = "'.site_url().'/admin/photos/save_order/'.$album_id.'";';
            }

            if(isset($albums_reorder))
            {
                echo 'QUICKSNAPS.reorder = "'.site_url().'/admin/albums/save_order/";';
            }

        ?>
    
    </script>



<?php
			if(isset($js) && is_array($js))
			{
				foreach($js as $view)
				{
					$this->load->view($js);
				}
			}
			elseif(!empty($js))
			{
				$this->load->view($js);
			}
?>

</head>

<body>


	<ul id="toolbar">
		<li class="menu_home">
            <?php echo anchor('', 'View Live Site'); ?>
		</li>


		<li class="menu_about icon">
            <?php echo anchor('admin/dashboard/about', 'About'); ?>
		</li>

		<li class="menu_logout icon">
            <?php echo anchor('admin/dashboard/logout', 'Logout: '.$this->session->userdata('username')); ?>
		</li>
	</ul>


	<div id="header">


		<h1><?php echo anchor('admin/albums', 'QuickSnap - simple photo managment'); ?></h1>


		<div id="tabs">
			<ul>

				<? $class = ($this->uri->segment(2) == 'themes') 
                    ? $class = ' class="selected"' : $class = ''; 
                ?>
				<li<?php echo $class; ?>>
                    <?php echo anchor('admin/themes', 'Themes'); ?>
                </li>

				<? $class = ($this->uri->segment(2) == 'settings') 
                    ? $class = ' class="selected"' : $class = ''; 
                ?>
				<li<?php echo $class; ?>>
                    <?php echo anchor('admin/settings', 'Settings'); ?>
                </li>

				<? $class = ($this->uri->segment(2) == 'albums' || $this->uri->segment(2) == 'photos') 
                    ? $class = ' class="selected"' : $class = ''; 
                ?>
				<li<?php echo $class; ?>>
                    <?php echo anchor('admin/albums', 'Albums'); ?>
                </li>

				<? $class = ($this->uri->segment(2) == 'dashboard' || $this->uri->segment(2) == '') 
                    ? $class = ' class="selected"' 
                    : $class = ''; 
                ?>


			</ul>
		</div>

	</div>



<div id="wrap"><div id="main">



	<h1><?php echo $h1; ?></h1>


	<?php 
			if(is_array($main))
			{
				foreach($main as $view)
				{
					$this->load->view($view);
				}
			}
			elseif(!empty($main))
			{
				$this->load->view($main);
			}
	?>

</div></div>


<div id="footer">
    <p>
    <a href="http://starfishwebconsulting.co.uk/articles/quicksnaps">Quicksnaps - simple photo management</a> |
    Brought to you by <a href="http://starfishwebconsulting.co.uk">Starfish Web Consulting.</a> <br />
    &copy; 2009 | Licensed under the <a href="http://creativecommons.org/licenses/GPL/2.0/">GNU GPL</a> license
    </p>

	<p class="benchmark">
		Loaded in {elapsed_time}s using {memory_usage}
	</p>


</div>

</body>




</html>
