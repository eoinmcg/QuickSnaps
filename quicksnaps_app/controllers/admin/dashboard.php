<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Dashboard
 *
 * @scope			public
 * @package			QuickSnaps
 * @subpackage		Controllers
 * @author			Eoin McGrath
 *
 *
 */ 
class Dashboard extends QS_Controller
{


	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */ 
	function Dashboard()
	{

		parent::QS_Controller();

		$this->load->model('Dashboard_model');
		$this->load->model('Gallery_model');

	}


	/**
	 * Main Dashboard page
	 *
	 * @access public
	 * @return void
	 */ 
	function index()
	{

		$data['overview'] = $this->Dashboard_model->get_overview();

		$data['title']	= 'Quicksnaps Dashboard';
		$data['h1']		= GALLERY_NAME;
		$data['main'][]	= 'admin/summary';

		$this->load->vars($data);
		$this->load->view('admin/dashboard');

	}


	/**
	 * About / Credits page
	 *
	 * @access public
	 * @return void
	 */ 
	function about()
	{
		$data['title']	= 'About QuickSnaps';
		$data['h1']		= 'About QuickSnaps';
		$data['main'][]	= 'admin/about';



		$this->load->vars($data);
		$this->load->view('admin/dashboard');
	}


	/**
	 * Logged in user can changed password
	 *
	 * @access public
	 * @return void
	 */ 
	function change_password()
	{

		$this->load->helper(array('form', 'url'));

		$data['msg']	= '';
		$data['title']	= 'Change your password';
		$data['h1']		= 'Change your password';

		if($this->input->post('password'))
		{
			$this->load->library('form_validation');

			$this->form_validation->set_rules('password', 'Password', 'xss_clean|required|matches[passconf]');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'xss_clean|required');

			if ($this->form_validation->run() == TRUE)
			{
				$data['main'][]	= 'admin/password_changed';
				$new_pass = md5($this->input->post('password'));
				$this->Dashboard_model->change_password($new_pass);
			}
			else
			{
				$data['main'][]	= 'admin/forms/change_password';
				$data['msg'] = 'Passwords do not match';
			}
		}
		else
		{
				$data['main'][]	= 'admin/forms/change_password';
		}


		$this->load->vars($data);
		$this->load->view('admin/dashboard');

	}


	/**
	 * logout user out of control panel
	 *
	 * @access public
	 * @return void
	 */ 
	function logout()
	{

		$this->load->view('admin/logged_out');

        $this->session->sess_destroy();


	}


}


/* End of file dashboard.php */
/* Location: ./quicksnaps_app/controllers/admin/dashboard.php */
