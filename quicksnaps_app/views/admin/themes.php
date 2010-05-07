<div class="info">


	<p>Upload themes into the themes folder. Ensure your css file is entilted 'style.css'<br />
		You may optionally add an effects.js to override the existing one.</p>


	<p>Default theme is: <strong><?php echo $default_theme; ?></strong></p>

</div>


<?php foreach($themes as $name=>$theme):
	$class = ($name == $default_theme) 
			? ' active' 
			: '';


?>

	<div class="theme<?php echo $class?>">
		<h3><?php echo $name?></h3>
				<?php if(is_array($theme)): ?>
					<a href="<?php echo base_url().$theme['preview']?>" 
                        title="Preview of <?php echo $theme['name']?> theme" rel="lightbox">
                        <img src="<?php echo base_url().$theme['preview']?>" 
                            class="preview" width="150" 
                            alt="Preview of <?php echo $theme['name']; ?>" />
                    </a>
					<p>
						<b>Name: </b><?php echo $theme['name']; ?> <br />
						<b>Version: </b><?php echo $theme['version']; ?> <br />
						<b>Description: </b><?php echo $theme['description']; ?> <br />
						<b>Author: </b><?php echo $theme['author']; ?> <br />
						<b>Version: </b><?php echo $theme['version']; ?> <br />
					</p>
				<?php else: ?> 
					<p class="warning">This theme has no info</p>
				<?php endif; ?>

                <?php echo anchor('admin/themes/set_default/'.$name, 
                                    'Make this theme default', 
                                    array('class' => 'theme_change')); ?>
				

	</div>
<?php endforeach; ?>
