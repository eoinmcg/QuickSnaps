<?php


class Photos extends QS_Controller
{

	function Photos()
	{
		parent::QS_Controller();

		$this->load->helper(array('form', 'text'));

		$this->load->model('Dashboard_model');
		$this->load->model('Gallery_model');

	}


	function show($id=0)
	{

		if(!$id)
			redirect('admin/dashboard', 'refresh');


		$data['album_id']	=	$id;
		$data['album']	    =	$this->Dashboard_model->edit_album_name($data['album_id']);

		$data['title']	=	'Photos in '.$data['album'];
		$data['h1']		= 	'Photos in '.$data['album'];
		$data['query']	=	$this->Dashboard_model->photos_get($data['album_id']);
		$data['main'][]	= 	'admin/photos_reorder.php';

		$this->load->view('admin/dashboard', $data);

	}


	function reorder($album)
	{


		$data['album_id'] = str_replace('album-', '', $album);

		$data['album']	=	$this->Dashboard_model->edit_album_name($data['album_id']);

		$data['title']	=	'Photos in '.$data['album'];
		$data['h1']		= 	'Photos in '.$data['album'];
		$data['query']	=	$this->Dashboard_model->photos_get($data['album_id']);
		$data['main'][]	= 	'admin/photos_reorder.php';


		$this->load->view('admin/dashboard', $data);


	}


	function edit($parent, $photo)
	{


		$this->output->set_header("HTTP/1.0 200 OK");
		$this->output->set_header("HTTP/1.1 200 OK");
		$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");

		$data['album'] = str_replace('album-', '', $parent);


		if(!$data['album'] || !$photo)
			die('No album/ photo');

		$data['album_name']	=	$this->Dashboard_model->edit_album_name($data['album']);

		$data['query']	= $this->Dashboard_model->photos_edit($photo);

        if($data['query']->photo)
        {
            $data['image_size'] = getimagesize('.'.$data['query']->photo.'_mid'.$data['query']->photo_type);

        }

		$data['title']	= 'Editing <em>'.$data['query']->name.'</em>';
		$data['back'] = 'admin/photos/show/'.$data['album'];
		$data['delete'] = 'admin/photos/delete/'.$data['query']->id.'/'.$data['album'];
		$data['h1']		= $data['title'];
		$data['main'][]	= 	'admin/photos_edit.php';


		$this->load->view('admin/dashboard', $data);


	}


	function new_photo($parent)
	{

		$data['album'] = str_replace('album-', '', $parent);
		$data['album_name']	=	$this->Dashboard_model->edit_album_name($data['album']);

		$data['title']	=	'Album: '.$data['album_name'];
		$data['h1']		= 	'Add a new photo in '.$data['album_name'];
		$data['main'][]	= 	'admin/photos_new.php';



		$this->load->view('admin/dashboard', $data);


	}


	function save_order($album=0)
	{

		if(!$album)
			die('No album specified');

	    $this->output->enable_profiler(FALSE);

		$this->Dashboard_model->photos_reorder($album);

        $feedback = 'Photos successfully reorderd';

        echo $feedback;

        exit;

	}


	function rotate($id, $direction)
	{

		$p = $this->Gallery_model->get_photo($id);
		$photos['master'] = $p->photo.$p->photo_type;
		$photos['mid'] = $p->photo.'_mid'.$p->photo_type;
		$photos['thumb'] = $p->photo.'_thumb'.$p->photo_type;

		switch($direction)
		{
			case 'left':
				$angle = 90;
			break;

			case 'right':
				$angle = 270;
			break;

		}

		foreach($photos as $photo)
		{
			$path = './'.$photo;
			$this->Dashboard_model->_rotate_image($path, $angle);
		}

        $feedback = 'Photo rotated';

        if($this->_is_ajax())
        {
            echo $feedback;
        }
        else
        {
            $this->session->set_flashdata('jgrowl', $feedback);
		    redirect($_SERVER['HTTP_REFERER'], 'refresh');
        }

		exit;

	}


	function crop($id)
	{


		$this->load->library('image_lib');

		$p = $this->Gallery_model->get_photo($id);
		$orig = $p->photo.$p->photo_type;
		$photo = str_replace('.', '_mid.', $orig);

		$orig_dim = getimagesize('./'.$orig);
		$photo_dim =  getimagesize('./'.$photo);

		$x_off = $orig_dim[0] / $photo_dim[0];
		$y_off = $orig_dim[1] / $photo_dim[1];

		$this->Dashboard_model->_crop_image($p, $x_off, $y_off);

        $feedback = 'Photo cropped';

        if($this->_is_ajax())
        {
            echo $feedback;
        }
        else
        {
            $this->session->set_flashdata('jgrowl', $feedback);
		    redirect($_SERVER['HTTP_REFERER'].'#manipulate_image', 'refresh');
        }

		exit;


	}



	function submit()
	{

		$data = array(
			'album'		=> $this->input->post('album'),
			'name' 		=> $this->input->post('name')
		);

        if($this->input->post('id'))
        {
            $data['id'] = $this->input->post('id');
        }

        if($this->input->post('highlight') == 'on')
        {
            $this->Dashboard_model->photos_highlight($data['album'], $data['id']);
        }
        else
        {
            $data['highlight'] = 0;
        }


        if(!$data['name'])
        {
            $data['name'] = ' ';
        }


		$data['errors'] = $this->Dashboard_model->photos_update($data);

        if(is_array($data['errors']))
        {
            $this->load->view('admin/error', $data);
        }
        else
        {
            $this->session->set_flashdata('jgrowl', 'Photo saved');

            redirect('admin/photos/show/'.$this->input->post('album'), 'refresh');
		    exit;
        }

	}



	function uploadify($id)
	{


		$data['album_id']	=	$id;
		$data['album']	    =	$this->Dashboard_model->edit_album_name($data['album_id']);

		$data['title']	=	'Upload multiple photos to '.$data['album'];
		$data['h1']		= 	'Upload multiple photos to  '.$data['album'];
		$data['query']	=	$this->Dashboard_model->photos_get($data['album_id']);
		$data['key']	= 	$code = md5(uniqid(rand(), true));	// we'll save this in the db and compare it on upload for security
		$data['js']		= 	'admin/uploadify_js.php';
		$data['main'][]	= 	'admin/photos_uploadify.php';

		$this->Dashboard_model->set_key($data['key']);

		$this->load->view('admin/dashboard', $data);

	}



	function upload_batch($key=FALSE)
	{

		$valid_key = $this->Dashboard_model->check_key($key);

		if(!$valid_key)
		{
			echo 'Invalid Key';
		}
       elseif(!empty($_FILES))
        {

			// this isn't perfect but uploadify adds a lot of cack to $_POST['folder']
			$x = explode('/', $this->input->post('folder'));
			$album_id = end($x);


			$data = array
			(
				'album' => $album_id,
				'name' => $_FILES['photo']['name']
			);
			$errors = $this->Dashboard_model->photos_update($data);
			echo $errors;

        }


	}



	function delete($id, $parent)
	{

		$delete = $this->Dashboard_model->photos_delete($id);

        $feedback = 'Photo deleted';

        if($this->_is_ajax())
        {
            echo $feedback;
        }
        else
        {
            $this->session->set_flashdata('jgrowl', $feedback);
            redirect('admin/photos/show/'.$parent, 'refresh');
        }

		exit;


	}


	function highlight($album, $id)
	{

		$this->Dashboard_model->photos_highlight($album, $id);


        $feedback = 'Cover photo set';

        if($this->_is_ajax())
        {
            echo $feedback;
        }
        else
        {
            $this->session->set_flashdata('jgrowl', $feedback);
		    header('Location: '.$_SERVER['HTTP_REFERER']);
        }

		exit;
	}


}


/* End of file photos.php */
/* Location: ./quicksnaps_app/controllers/admin/photos.php */

