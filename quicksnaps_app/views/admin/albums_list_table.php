<table>

	<thead>
		<tr>
			<th>Preview</th>
			<th>Name</th>
			<th>Theme</th>
			<th>Private?</th>
			<th>Delete</th>
		</tr>
	</thead>

	<tbody>
		<?php 
			foreach ($query->result() as $row): 
			$private = ($row->private) 
                ? '<img src="'.base_url().'assets/admin/i/private.png" title="Private galleries will not be listed in the Gallery. Click the thumbnail to for a link to the Album " />' 
                : '';
            $img = '<img src="'.$this->Gallery_model->album_cover($row->id).'" width="60" alt="Preview" class="new_window" title="Click for a preview of the gallery" />';
            $photos = $this->Dashboard_model->album_count_photos($row->id);
		?>
			<tr class="album_row">
				<td>
                    <?php echo anchor('/gallery/album/'.$row->url, 
                                $img, array('title' => 'Click to view live site')); ?>
                </td>
				<!--td>
                    <?php echo anchor('admin/albums/edit/'.$row->id, 
                                        $row->name, array('class' => 'edit')); ?>
                </td-->

				<td>
					<strong><?php echo  $row->name?></strong><br />
                    <?php echo anchor('admin/photos/show/'.$row->id, 
                                        $photos.' photo(s)', array('class' => 'photo')); ?>
                </td>
				<td><?php echo $row->theme; ?></td>
				<td><?php echo $private; ?></td>
				<td>
                    <?php echo anchor('admin/albums/delete/'.$row->id, 
                                        'Delete', array('class' => 'delete_ajax', 
                                        'title' => $row->name)); ?>
                </td>

			</tr>
		<?php endforeach; ?>
	</tbody>

</table>
