<?php

class Albums extends QS_Controller
{

    function __construct()
	{
		parent::__construct();

		$this->load->model('Dashboard_model');
		$this->load->model('Gallery_model');

	}


	function index()
	{
		$data['title']	=	'Albums';
		$data['h1']		= 	'Showing all albums';
		$data['query']	=	$this->Dashboard_model->get_albums();
	    $data['main'][]	= 	'admin/albums_list.php';


		$this->load->vars($data);
		$this->load->view('admin/dashboard');

	}


	function reorder()
	{
		$data['title']	=	'Albums';
		$data['h1']		= 	'Reorder albums';
		$data['query']	=	$this->Dashboard_model->get_albums();
		$data['main'][]	= 	'admin/albums_reorder.php';
		$data['albums_reorder'] = TRUE;

		$this->load->vars($data);
		$this->load->view('admin/dashboard');
	}


	function new_album()
	{

		$data['title']	=	'Albums';
		$data['h1']		= 	'Create New Album';
		$data['main'][]	= 	'admin/albums_new.php';
		$data['themes'] = $this->Dashboard_model->get_themes();

		$this->load->helper('form');

		$this->load->vars($data);
		$this->load->view('admin/dashboard');

	}


	function edit($id = 0)
	{
		if(!$id)
			redirect(base_url().'/admin/albums/', refresh);

		$this->load->helper('form');

		$data['title']	=	'Albums';
		$data['h1']		= 	'Editing album '.$this->Dashboard_model->edit_album_name($id);
		$data['query']	=	$this->Dashboard_model->edit_album($id);
		$data['main'][]	= 	'admin/albums_edit.php';

		$data['themes'] = $this->Dashboard_model->get_themes();

		$this->load->vars($data);
		$this->load->view('admin/dashboard');
	}


	function submit()
	{

		$data = array(
			'id'		=> $this->input->post('id'),
			'name' 		=> $this->input->post('name'),
			'url'		=> url_title($this->input->post('name')),
			'theme'     => $this->input->post('theme'),
			'private'   => ($this->input->post('private') == 'on') ? 1 : 0,
			'full_txt'	=> $this->input->post('full_txt')
		);


		$submit_id = $this->Dashboard_model->update_album($data);


		if(!$data['id'])
		{
	        $this->session->set_flashdata('jgrowl', 'Album created');
		}
		else
		{
	        $this->session->set_flashdata('jgrowl', 'Album info updated');
		}


		redirect('admin/photos/show/'.$submit_id, 'refresh');
		exit;


	}


	function delete($id)
	{

		if(!$id)
		{
			$url = base_url().'admin/albums/';
			header('Location: '.$url);
			exit;
		}

		$this->Dashboard_model->albums_delete($id);

        $feedback = 'Album deleted';

        if($this->_is_ajax())
        {
            echo $feedback;
        }
        else
        {
            $this->session->set_flashdata('jgrowl', $feedback);
		    redirect('admin/albums/', 'refresh');
        }

		exit;


	}


	function save_order()
	{
		$this->output->enable_profiler(FALSE);

		$photos = $this->input->post('photos');
		$this->Dashboard_model->albums_reorder($photos);

        $feedback = 'Albums successfully reordered';

        echo $feedback;

        exit;

	}


}


/* End of file albums.php */
/* Location: ./quicksnaps_app/controllers/admin/albums.php */

