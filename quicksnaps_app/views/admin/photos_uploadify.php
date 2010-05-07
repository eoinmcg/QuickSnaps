
<noscript>
    <div class="warning">
        <p>You must have javascript enabled for the reorder function to work</p>
    </div>
</noscript>


<p><?php echo anchor('admin/photos/show/'.$album_id, 'Back', array('class' => 'back')); ?></p>


<h3>Select Photos</h3>

<div id="uploadify_wrap">

        <?php echo form_upload(array('name' => 'Filedata', 'id' => 'upload'));?>
        <a class="upload" href="javascript:$('#upload').uploadifyUpload();">Upload Photo(s)</a>

		<div id="target"></div>

</div>
