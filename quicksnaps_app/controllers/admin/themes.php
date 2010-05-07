<?php

define("THEME_DIR", './themes/');

class Themes extends QS_Controller
{


	function Themes()
	{
		parent::QS_Controller();

		$this->load->helper(array('file', 'directory'));

		$this->load->model('Gallery_model');
		$this->load->model('Dashboard_model');

	}


	function index()
	{
		$data['title']	=	'Manage Themes';
		$data['h1']		= 	'Manage Themes';
		$data['main'][]	= 	'admin/themes';



		$path = './themes/';
		$themes = $this->_read_subdir(THEME_DIR);

		$data['default_theme'] = $this->Dashboard_model->get_default_theme();

		foreach($themes as $theme)
		{
			$theme_data = $this->_parse_theme_info($theme);

			if(count($theme_data))
				$data['themes'][$theme] = $this->_parse_theme_info($theme);

		}


		$this->load->vars($data);
		$this->load->view('admin/dashboard');

	}


	function set_default($theme)
	{
		$data['default_theme'] = $theme;

		$this->Dashboard_model->update_settings($data);

        $feedback = 'Default theme changed';

        if($this->_is_ajax())
        {
            echo $feedback;
        }
        else
        {
            $this->session->set_flashdata('jgrowl', $feedback);
            redirect('admin/themes', 'refresh');
        }

        exit;

	}

	function _read_subdir($path)
	{

		$subdirs = array();

		if ($handle = opendir($path))
		{
			while (false !== ($file = readdir($handle)))
			{

				if(is_dir($path.$file) && $file != "." && $file != "..")
					$subdirs[] = $file;
			}

			closedir($handle);
		}

		return $subdirs;
	}


	function _parse_theme_info($theme)
	{

			$theme_path = THEME_DIR.$theme.'/style.css';

			$style = read_file($theme_path);
			if(!$style)
				return FALSE;

			$theme_data = $this->_get_theme_data( $style, $theme );

			return $theme_data;


	}


//	Adapted from Wordpress code
	function _get_theme_data( $theme_data, $folder_name )
	{

		$theme_data = str_replace ( '\r', '\n', $theme_data );

		preg_match( '|Theme Name:(.*)$|mi', $theme_data, $theme_name );
		preg_match( '|Theme URI:(.*)$|mi', $theme_data, $theme_uri );
		preg_match( '|Description:(.*)$|mi', $theme_data, $description );

		if ( preg_match( '|Author URI:(.*)$|mi', $theme_data, $author_uri ) )
		{
			$author_uri = trim( $author_uri[1]);
		}
		else
		{
			$author_uri = '';
		}

		if ( preg_match( '|Template:(.*)$|mi', $theme_data, $template ) )
		{
			$template = trim( $template[1] );
		}
		else
		{
			$template = '';
		}

		if ( preg_match( '|Version:(.*)|i', $theme_data, $version ) )
		{
			$version = trim( $version[1] );
		}
		else
		{
			$version = '';
		}


		if(file_exists(THEME_DIR.$folder_name.'/screenshot.jpg'))
		{
			$preview = './themes/'.$folder_name.'/screenshot.jpg';
		}
		else
		{
			$preview = './assets/admin/i/nopreview.jpg';
		}

		$name = $theme = trim($theme_name[1] );
		$theme_uri = trim($theme_uri[1]);
		$description = trim($description[1]);

		if ( preg_match( '|Author:(.*)$|mi', $theme_data, $author_name ) )
		{
			$author = trim( $author_name[1] );
		}
		else
		{
			$author = 'Anonymous';
		}

		return array(
				'name' => $name,
				'title' => $theme,
				'uri' => $theme_uri,
				'preview' => $preview,
				'description' => $description,
				'author' => $author,
				'author_uri' => $author_uri,
				'version' => $version
				);
		}

}


/* End of file themes.php */
/* Location: ./quicksnaps_app/controllers/admin/themes.php */

