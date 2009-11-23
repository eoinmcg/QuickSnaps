<?php

class Dashboard extends MY_Controller 
{


	function Dashboard() 
	{

		parent::MY_Controller();

		$this->load->model('Dashboard_model');
		$this->load->model('Gallery_model');

	}


	function index() 
	{

		$data['overview'] = $this->Dashboard_model->get_overview();

		$data['title']	= 'Quicksnaps Dashboard';
		$data['h1']		= GALLERY_NAME;
		$data['main'][]	= 'admin/summary';



		$this->load->vars($data);
		$this->load->view('admin/dashboard');
			
	}


	function about()
	{
		$data['title']	= 'About QuickSnaps';
		$data['h1']		= 'About QuickSnaps';
		$data['main'][]	= 'admin/about';



		$this->load->vars($data);
		$this->load->view('admin/dashboard');
	}


	function logout() 
	{

		$this->load->view('admin/logged_out');

        $this->session->sess_destroy();

		
	}


}


/* End of file dashboard.php */ 
/* Location: ./quicksnaps_app/controllers/admin/dashboard.php */
