<?php

class Dashboard_model extends Model {


	function Dashboard_model() 
	{
		parent::Model();


	}

	function get_overview()
	{

        $albums = $this->db->count_all_results('albums');

        $photos = $this->db->count_all_results('photos');

		$max_upload = GALLERY_MAX_UPLOAD / 1024;
		return array('albums' => $albums, 'photos' => $photos, 'max_upload' => $max_upload.' MB');

	}




	function get_themes()
	{

		$this->load->helper('directory');
        $dir = './themes/';
		$themes = directory_map($dir, TRUE);

		return $themes;

	}


	function get_default_theme()
	{

        $this->db->select('default_theme');
        $this->db->where('id = ', 1);
        $query = $this->db->get('settings');

		$row = $query->row();

		return $row->default_theme;
	}


	function update_settings($data)
	{

		 	$this->db->where('id', '1');
			$this->db->update('settings', $data);

	}



#
#	ALBUMS
#

    function get_albums()
    {

        $this->db->order_by('rank', 'asc');
        $query = $this->db->get('albums');

        return $query;

    }


	function album_count_photos($album) 
	{

		$this->db->where('album', $album);
		$this->db->from('photos');

		return $this->db->count_all_results();

	}


	function edit_album_name($album)
	{

		$this->db->select('name');
		$this->db->where('id', $album);
		$this->db->limit(1);
		$query = $this->db->get('albums');

		$row = $query->row();

		return $row->name;

	}


	function edit_album($album)
	{

        $this->db->where('id', $album);
        $this->db->limit(1);
        $query = $this->db->get('albums');

		$row = $query->row();

		return $row;

	}


	function albums_reorder($photos)
	{

		$total_photos = count($this->input->post('photos'));

		for($photo = 0; $photo < $total_photos; $photo++ )
		{
			$id = $photos[$photo];
			$rank = $photo;
            $data = array(
                'rank' => 10000 - ($rank*-1),
                'id' => $id
            );

		 	$this->db->where('id', $data['id']);
			$this->db->update('albums', $data);
		}

		return;

	}


	function update_album($data)
	{


      if(empty($data['name']))
      {
            $data['name'] = 'Gallery '.$data['id'];
      }

		if(!$data['id']) 
		{
			$this->db->insert('albums', $data);	
            $id = $this->db->insert_id();

            $data['id']= $id;
            $data['url'] = url_title($data['name']);
            $data['rank'] = 10000 - $id;
        	$this->db->where('id', $data['id']);
    	    $this->db->update('albums', $data);

		}
		else
		{
		 	$this->db->where('id', $data['id']);
			$this->db->update('albums', $data);
		}

		return $data['id'];

	}

#
#	PHOTOS
#
	function photos_get($id) 
    {

        $this->db->select('id, name, album ,photo, photo_type, highlight');
        $this->db->where('album', $id);
        $this->db->order_by('rank', 'asc');
        $query = $this->db->get('photos');

		return $query;

	}


	function photos_edit($id) 
    {

        $this->db->where('id', $id);
        $this->db->limit(1);
        $query = $this->db->get('photos');

		$row = $query->row();

		return $row;


	}


	function photos_highlight($album, $id)
	{

        $data = array(
            'highlight' => 0
        );

    	$this->db->where('album', $album);
		$this->db->update('photos', $data);


        $highlight = array(
            'id' => $id,
            'highlight' => 1
        );

    	$this->db->where('id', $highlight['id']);
		$this->db->update('photos', $highlight);


	}


	function photos_update($data)
	{


		if($_FILES['photo']['name'])
		{

            if(array_key_exists('id', $data))
            {
			    $this->photos_delete($data['id'], TRUE);
            }

			$folder = './uploads/gallery-'.$data['album'].'/';

			if(!is_dir($folder))
			{
				mkdir($folder, 0777);
			}


			$config['upload_path'] = $folder;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= GALLERY_MAX_UPLOAD;

			$this->load->library('upload', $config);

				if (!$this->upload->do_upload('photo'))
				{
					$errors = array('error' => $this->upload->display_errors());

                    return $errors;

				}
				else 
				{


					$file = array('upload_data' => $this->upload->data());
					chmod($file['upload_data']['full_path'], 0777);

					
					$data['photo'] = substr($folder.$file['upload_data']['raw_name'], 1);
					$data['photo_type'] = $file['upload_data']['file_ext'];

					$this->_resize_pic($file['upload_data']['full_path'], '700', '500');

				}
		}



		if(!array_key_exists('id', $data)) 
		{
			$data['rank'] = time();
			$this->db->insert('photos', $data);	
		}
		else
		{
		 	$this->db->where('id', $data['id']);
			$this->db->update('photos', $data);
		}

		return TRUE;


	}


	function photos_reorder($album)
	{
		$photos = $this->input->post('photos');
		$total_photos = count($this->input->post('photos'));

		for($photo = 0; $photo < $total_photos; $photo++ )
		{

            $data = array(
                'id' => $photos[$photo],
                'rank' => $rank = $photo
            );

		 	$this->db->where('id', $data['id']);
			$this->db->update('photos', $data);

		}

		return;

	}


	function photos_delete($id = 0, $photos_only = FALSE)
	{

        $this->db->select('photo, photo_type');
        $this->db->where('id', $id);
        $query = $this->db->get('photos');

		$row = $query->row();

		if(!$photos_only)
		{
			$this->db->where('id', $id);
			$this->db->delete('photos'); 
		}

		if(!empty($row->photo))
		{
			$this->_remove_image($row->photo, $row->photo_type);
		}

	}


	function albums_delete($id = 0)
	{

#		GET INFO ABOUT THE ALBUM WE'RE ABOUT TO WIPE
        $this->db->select('id');
        $this->db->where('id', $id);
        $query = $this->db->get('albums');

		$row = $query->row();
		$album = $row->id;


		$query->free_result();

#		DELETE ALL PHOTOS IN ALBUM
        $this->db->select('id');
        $this->db->where('album', $album);
        $query = $this->db->get('photos');

		foreach($query->result() as $photo)
		{
			$this->photos_delete($photo->id);

		}
		$query->free_result();


#		NOW WIPE THE ALBUM
        $this->db->delete('albums', array('id' => $album)); 


	}


	function _remove_image($name, $type)
	{
		if(is_file('.'.$name.$type))
		{
			@unlink('.'.$name.$type);
		}

		if(is_file('.'.$name.'_thumb'.$type))
		{
			@unlink('.'.$name.'_thumb'.$type);
		}

		if(is_file('.'.$name.'_mid'.$type))
		{
			@unlink('.'.$name.'_mid'.$type);
		}
	}

#
#	IMAGE RELATED
#

	function _upload_pic($config)
	{


			$this->load->library('upload', $config);

				if (!$this->upload->do_upload('photo'))
				{
					$this->upload->display_errors();
					exit();
				}
				else 
				{

					$file = array('upload_data' => $this->upload->data());
					chmod($file['upload_data']['full_path'], 0777);

					$this->_resize_pic($file['upload_data']['full_path']);

				}



	}


	function _resize_pic($path) 
	{

   
			$images = array();
			$dim = getimagesize($path);
			$this->load->library('image_lib');


	#			MAIN PIC
				if($dim[0] > GALLERY_MID_W)
				{
					$this->_create_mid($path);
				}
				else
				{
                    $mid = str_replace('.', '_mid.', $path);
                    $mid = str_replace('_mid./', './', $mid);
                    copy($path, $mid);
				}



	#			THUMBNAIL
				if($dim[0] > GALLERY_THUMB_W)
				{
					$this->_create_thumb($path);
				}
				else
				{
                    $thumb = str_replace('.', '_thumb.', $path);
                    $thumb = str_replace('_thumb./', './', $thumb);
					copy($path, $thumb);
				}


	}


	function _create_mid($path)
	{

			$this->load->library('image_lib');

			$config['image_library'] = LIB;
			$config['library_path'] = LIB_PATH;
			$config['source_image'] = $path;
			$config['create_thumb'] = TRUE;
			$config['thumb_marker'] = '_mid';
			$config['maintain_ratio'] = TRUE;
			$config['width'] = GALLERY_MID_W;
			$config['height'] = GALLERY_MID_H;
			$this->image_lib->initialize($config);

			if ( ! $this->image_lib->resize())
			{
				echo $this->image_lib->display_errors();
				exit;
			}


			$this->image_lib->clear();

	}

	
	function _create_thumb($path)

	{
			$this->load->library('image_lib');

			$config['image_library'] = LIB;
			$config['library_path'] = LIB_PATH;
			$config['source_image'] = $path;
			$config['create_thumb'] = TRUE;
			$config['thumb_marker'] = '_thumb';
			$config['maintain_ratio'] = TRUE;
			$config['width'] = GALLERY_THUMB_W;
			$config['height'] = GALLERY_THUMB_H;
			$this->image_lib->initialize($config);

			if ( ! $this->image_lib->resize())
			{
				echo $this->image_lib->display_errors();
			}


			$this->image_lib->clear();


	}


	function _rotate_image($path, $angle)
	{

		$config['image_library'] = LIB;
		$config['library_path'] = LIB_PATH;
		$config['source_image'] = $path;
		$config['rotation_angle'] = $angle;
		$this->load->library('image_lib', $config);

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->rotate())
		{
			$error = $this->image_lib->display_errors();
			die($error);
		}

		$this->image_lib->clear();

	}


	function _crop_image($p, $x_off, $y_off)
	{

		$config['image_library'] = LIB;
		$config['library_path'] = LIB_PATH;
		$config['source_image'] = './'.$p->photo.$p->photo_type;
		$config['maintain_ratio'] = FALSE;
		$config['x_axis'] = ceil ( $this->input->post('x') * $x_off );
		$config['y_axis'] = ceil ( $this->input->post('y') * $y_off );
		$config['width'] = $this->input->post('w') * $x_off;
		$config['height'] = $this->input->post('h') * $y_off;

		$this->image_lib->initialize($config);


		if ( ! $this->image_lib->crop())
		{
			echo $this->image_lib->display_errors();
		}

		$this->_create_mid('.'.$p->photo.$p->photo_type);
		$this->_create_thumb('.'.$p->photo.$p->photo_type);

		$this->image_lib->clear();

	}


	function set_key($key)
	{

		$data['uploadify_key'] = $key;

		$this->db->where('id', 1);
		$this->db->update('settings', $data);

	}


	function get_key()
	{

        $this->db->select('uploadify_key');
        $this->db->where('id', 1);
		$query = $this->db->get('settings');

		$row = $query->row();

		return $row->uploadify_key;


	}


	function check_key($key)
	{

		$db_key = $this->get_key();

		if($key == $db_key)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}



}


/* End of file dashboard_model.php */ 
/* Location: ./quicksnaps_app/models/dashboard_model.php */ 
