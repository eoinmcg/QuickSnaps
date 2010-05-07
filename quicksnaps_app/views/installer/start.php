<div class="info">

<p class="title">
Welcome. <br />
You will now set up the admin account, providing a username and password
</p>

<p><?php echo anchor('installer/create_database',
                    'Activate QuickSnaps &raquo;',
                    array('class' => 'button rounded', 'id' => 'install_button')); ?></p>


<p><b class="block">Config Directory:</b> <?php echo $config_writable; ?></p>

<p><b class="block">Upload directory:</b> <?php echo $uploads_writable; ?></p>

<p><b class="block">Image Libraries available:</b>
<ul>
    <?php foreach($image_libs as $key => $val): ?>
        <li><?php echo $key; ?></li>
    <?php endforeach; ?>
</ul>
</p>

<p><b class="block">Base URL:</b> <?php echo $this->config->item('base_url'); ?>
<br /></p>

<p><b class="block">Index file:</b> <?php echo $this->config->item('index_page'); ?>

</p>

</div>

