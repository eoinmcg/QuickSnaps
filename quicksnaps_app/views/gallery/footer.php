



<div id="footer">
    <p id="about_quicksnaps">
    <a href="http://starfishwebconsulting.co.uk/quicksnaps">Quicksnaps - simple photo management</a> |
    Brought to you by <a href="http://starfishwebconsulting.co.uk">Starfish Web Consulting.</a> <br />
    &copy; <?php echo date('Y', time()); ?> | Licensed under the <a href="http://creativecommons.org/licenses/GPL/2.0/">GNU GPL</a> license
    </p>

	<p id="benchmark">Loaded in {elapsed_time} seconds using {memory_usage}</p>
</div>


<!-- These extra divs/spans may be used as catch-alls to add extra imagery. [As seen on CSS Zen Garden] -->
<div id="extraDiv1">
	<?php if ( $this->session->userdata('username') ): ?>
		<span><?php echo anchor('/admin/albums', $this->session->userdata('username'), array('id' => 'logged_in_link')); ?></span>
	<?php else : ?>
		<span><?php echo anchor('/login', 'Login', array('id' => 'login_link')); ?></span>
	<?php endif; ?>

</div>


<div id="extraDiv2"><span></span></div><div id="extraDiv3"><span></span></div>
<div id="extraDiv4"><span></span></div><div id="extraDiv5"><span></span></div><div id="extraDiv6"><span></span></div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.3.2.min.js"></script>

<?php if(IMAGE_VIEWER == 'slimbox2'): ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/slimbox2.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/slimbox2.css" media="screen" />
<?php else: ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.mousewheel-3.0.2.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/fancybox/jquery.fancybox-1.3.1.js"></script>
<?php endif; ?>

<?php if(!empty($js)): ?>
	<script type="text/javascript" src="<?php echo base_url();?>themes/<?php echo $theme; ?>/effects.js"></script>
<?php else: ?>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/effects.js"></script>
<?php endif; ?>

</body>
</html>

