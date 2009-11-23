
<?php echo anchor('admin/albums/new_album', 'Create New album', array('class' => 'album')); ?> |
<?php echo anchor('admin/albums/reorder', 'Reorder Albums', array('class' => 'reorder')); ?>

<?php

    if($query->num_rows())
    {
        $this->load->view('admin/albums_list_table');
    }  
    else
    {
        $this->load->view('admin/getting_started');
    }
?>
