<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Login Controller
 *
 * @package		CodeIgniter
 * @subpackage	FrontEnd
 * @author		Eoin McGrath
 * @link		http://www.starfishwebconsulting.co.uk/quicksnaps
 */

class Login extends QS_Controller
{

	/**
	 * Login Constructor Class
	 *
	 * Loads model and necessary helpers
	 * If logged in directs to the dashboard
	 *
	 */
	function __construct()
	{
		parent::__construct();

		$this->load->model('Login_model');
		$this->load->helper(array('security', 'form'));

		// already logged in, redirect
        if($this->session->userdata('username'))
        {
            redirect('/admin/albums/', 'refresh');
            exit;
        }


	}


	/**
	 * Display form and check login in posted
	 *
	 * @access public
	 *
	 */
	function index() {

		// prep login details
		$u = xss_clean($this->input->post('uname'));
		$p = xss_clean($this->input->post('pword'));

		// we'll use this to send errors to the view
		$data['msg'] = '';

		// login attempt
		if($this->input->post('login'))
		{

            $logon = $this->Login_model->do_login($u, $p);

			if($logon)
			{
                redirect('/admin/albums/', 'refresh');
                exit;
			}
			else
			{
				$data['msg'] = '<div class="error"><p>Incorrect username/ password</p></div>';
			}
		}


		$this->load->view('admin/forms/login_form.php', $data);

	}


}


/* End of file login.php */
/* Location: ./quicksnaps_app/controllers/admin/login.php */

