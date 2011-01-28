<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
* Installer
*
* Attempts to check if setup is usable, then creates db and user account
* If successful user is redirect to Admin panel
* TODO: Provision for errors
*
* @package		Quicksnaps
* @subpackage	Installer
* @author		Eoin McGrath
* @link			http://www.starfishwebconsulting.co.uk/quicksnaps
*/
class Installer extends Install_Controller
{

	/**
	 * Constructor
	 *
	 * @access public
	 * @return void
	 */ 
	function Installer()
	{
		parent::Install_Controller();

        $this->load->helper('image');

		$this->load->library(array('form_validation', 'session'));

		$this->load->model('Installer_model');


	}


	/**
	 * index - Installer home
	 *
	 * @access public
	 * @return void
	 */ 
    function index()
	{

		$this->_check_installed();

        $uploads = is_writable('./uploads');
		$config  = is_writable('./quicksnaps_app/config');

		$data['title'] = 'QuickSnaps - Installing';
		$data['view'] = 'start';

		$data['config_writable'] = ($config)
			? '<span class="true">WRITABLE</span>'
			: '<span class="false">IS NOT WRITABLE</span>';

        $data['uploads_writable'] = ($uploads)
            ? '<span class="true">WRITABLE</span>'
            : '<span class="false">IS NOT WRITABLE</span>';

        $data['image_libs'] = installed_image_libs();

		$this->load->vars($data);
		$this->load->view('/installer/template');

	}


	/**
	 * Creates Database, admin account and redirect to Admin panel
	 *
	 * @access public
	 * @return void
	 */ 
	function create_database()
	{

		$this->_check_installed();

		$this->form_validation->set_rules('uname', 'Your Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('pword', 'Your Password', 'trim|required|xss_clean');

		$this->form_validation->set_rules('hostname', 'Database Hostname', 'trim|required|xss_clean');
		$this->form_validation->set_rules('username', 'Database Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('password', 'Database Password', 'trim|required|xss_clean');



		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Create Admin Account';
			$data['view'] = 'install_form';

		}
		else
		{

			$data['title'] = 'Create Database';
			$data['view'] = 'install_form';

			$db_config = array(
				'hostname' => $this->input->post('hostname'),
				'database' => $this->input->post('database'),
				'username' => $this->input->post('username'),
				'password' => $this->input->post('password'),
				'dbdriver' => $this->input->post('dbdriver'),
				'dbprefix' => $this->input->post('dbprefix')
			);

			//create a database config file
			$this->Installer_model->create_db_config($db_config);
			$this->load->database();
			$this->load->dbforge();
			$this->Installer_model->create_db();

			//create admin account
			$user = $this->input->post('uname');
			$pass_enc = md5($this->input->post('pword'));

			$this->Installer_model->create_admin($user, $pass_enc);

			//log in and redirect to dashboard
			$this->load->model('Login_model');
			$this->Login_model->do_login($user, $this->input->post('pword'));
			
			$this->session->set_flashdata('just_installed', 1);
			redirect('/admin/albums/', 'refresh');


		}

			$this->load->vars($data);
			$this->load->view('/installer/template');


	}


	/**
	 * Check if QuickSnaps is already installed
	 *
	 * Checks if config/database.php has been created
	 * Checks if database already exits
	 *
	 * @access private
	 * @return bool
	 */ 
	function _check_installed()
	{


        if( $this->Installer_model->db_config_exists())
        {
			if($this->Installer_model->db_installed())
			{
            	show_error('QuickSnaps is already installed');
			}
			else
			{
				return FALSE;
			}
        }
		else
		{
			return FALSE;
		}

	}


}


/* End of file installer.php */
/* Location: ./quicksnaps_app/controllers/installer.php */

