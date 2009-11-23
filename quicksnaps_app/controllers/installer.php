<?php


class Installer extends MY_Controller
{

	function Installer()
	{
		parent::MY_Controller();

        $this->load->helper('image');

		$this->load->library('form_validation');

		$this->load->model('Installer_model');


	}


    function index()
	{

		if ( ! $this->db->table_exists('settings'))
		{
            $this->load->dbforge();
            $this->Installer_model->create_db();
	    }


        if( $this->Installer_model->is_installed())
        {
            die('QuickSnaps is already installed');
        }

        $uploads = is_writable('./uploads');

		$data['title'] = 'QuickSnaps - Installing';
		$data['view'] = 'start';
        $data['uploads_writable'] = ($uploads) 
            ? '<span class="true">WRITABLE</span>'
            : '<span class="true">IS NOT WRITABLE</span>';
        $data['image_libs'] = installed_image_libs();

		$this->load->vars($data);
		$this->load->view('/installer/template');

	}


	function create()
	{

        if( $this->Installer_model->is_installed())
        {
            die('QuickSnaps is already installed');
        }


		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[12]|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]|md5');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required');
				
		if ($this->form_validation->run() == FALSE)
		{
			$data['title'] = 'Create Admin Account';
			$data['view'] = 'setup_form';

		}
		else
		{

			$data['title'] = 'Created Admin account';
			$data['view'] = 'finished';

			$user = $this->input->post('username');
			$pass = $this->input->post('password');

			$this->Installer_model->create_admin($user, $pass);


		}

			$this->load->vars($data);
			$this->load->view('/installer/template');

	}


}


/* End of file installer.php */ 
/* Location: ./quicksnaps_app/controllers/installer.php */ 
