<?php

class Login extends QS_Controller
{

	function Login()
	{
		parent::QS_Controller();

		$this->load->helper(array('security', 'form'));
		$this->load->library('session');

        if($this->session->userdata('username'))
        {
            redirect('/admin/albums/', 'refresh');
            exit;
        }


	}


	function index() {

		$u = xss_clean($this->input->post('uname'));
		$p = xss_clean($this->input->post('pword'));

		$this->load->model('Login_model');

		$data['msg'] = '';


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

