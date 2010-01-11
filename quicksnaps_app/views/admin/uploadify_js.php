
<link type="text/css" rel='stylesheet' href="<?php echo base_url(); ?>assets/admin/css/uploadify.css" media="screen, projection" />	
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/jquery.uploadify.v2.1.0.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/swfobject.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

									
				$("#upload").uploadify({
						uploader: '<?php echo base_url();?>assets/admin/flash/uploadify.swf',
						script: '<?php echo site_url();?>/admin/photos/upload_batch/<?php echo $key; ?>',
						cancelImg: '<?php echo base_url();?>assets/admin/i/cancel.png',
						folder: '<?php echo $album_id; ?>',
						fileDataName: 'photo',
						scriptAccess: 'sameDomain',
					//	sizeLimit: '<?php echo GALLERY_MAX_UPLOAD; ?>',
						multi: true,
						'onError' : function (a, b, c, d) {
							 if (d.status == 404)
								alert('Could not find upload script.');
							 else if (d.type === "HTTP")
								alert('error '+d.type+": "+d.status);
							 else if (d.type ==="File Size")
								alert(c.name+' '+d.type+' Limit: '+Math.round(d.sizeLimit/1024)+'KB');
							 else
								alert('error '+d.type+": "+d.text);
							},
						'onComplete'   : function (event, queueID, fileObj, response, data) {
											$.post('<?php echo site_url()."/admin/photos/upload_batch/$key";?>',{filearray: response},function(info){
												$("#target").append(info);	  
											});								 			
						},	
						'onAllComplete': function (event, data) {
											window.location = '<?php echo site_url();?>/admin/photos/show/<?php echo $album_id?>';
											},
							fileExt: '.jpg,.jpeg,.png,.gif'
				});				
	});
</script>
