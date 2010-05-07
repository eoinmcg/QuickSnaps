<?php


class Settings extends QS_Controller
{


	function Settings()
	{
		parent::QS_Controller();

		$this->load->helper('form');

		$this->load->model('Dashboard_model');

	}


	function index()
	{

		$this->load->helper('form');
		$this->load->helper('image');
		$data['themes'] = $this->Dashboard_model->get_themes();
		$data['overview'] = $this->Dashboard_model->get_overview();

        if(strtoupper(substr(PHP_OS, 0,3)) === 'WIN' && LIB == 'ImageMagick')
        {
            $data['win_imagemagick'] = TRUE;
        }
        else
        {
            $data['win_imagemagick'] = FALSE;
        }

		$data['title']	=	'Edit Gallery settings';
		$data['h1']		= 	'Settings';
		$data['main'][]	= 	'admin/summary.php';
		$data['main'][]	= 	'admin/settings_update.php';

		$data['libs'] = installed_image_libs();


		$this->load->vars($data);
		$this->load->view('admin/dashboard');

	}


	function submit()
	{


		$data = array(
			'name'				=> $this->input->post('name'),
			'summary' 			=> $this->input->post('summary'),
			'default_theme' 	=> $this->input->post('theme'),
			'per_page'			=> $this->input->post('per_page'),
			'w'					=> $this->input->post('w'),
			'h'					=> $this->input->post('h'),
			'mid_w'				=> $this->input->post('mid_w'),
			'mid_h'				=> $this->input->post('mid_h'),
			'thumb_w'			=> $this->input->post('thumb_w'),
			'thumb_h'			=> $this->input->post('thumb_h'),
			'lib'				=> $this->input->post('lib'),
			'lib_path'			=> $this->input->post('lib_path')
		);

#		If lib_path isn't specified we will insert default value
		if(empty($data['lib_path']))
		{
			switch($data['lib'])
			{

				case 'ImageMagick':
					$data['lib_path'] = '/usr/bin/convert';
				break;

				case 'netpbm':
					$data['lib_path'] = '/usr/bin/';
				break;

				default:
					$data['lib_path'] = '';
				break;

			}
		}

		$this->Dashboard_model->update_settings($data);
        $this->session->set_flashdata('jgrowl', 'Settings updated');

		redirect('admin/settings', 'refresh');
		exit;

	}

}


/* End of file settings.php */
/* Location: ./quicksnaps_app/controllers/admin/settings.php */

