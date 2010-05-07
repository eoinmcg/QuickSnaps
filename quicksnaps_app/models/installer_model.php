<?php


class Installer_Model extends Model
{

	function Installer_Model()
	{
		parent::Model();


	}


	/**
	*
	*  Has the db config been created?
	*
	*  @return bool
	*
	*/
	function db_config_exists()
	{

		if ( file_exists('./quicksnaps_app/config/database.php') )
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}

	}


	/**
	*
	*  Try and load the database
	*
	*  @return bool
	*
	*/
	function db_installed()
	{

		require_once('./quicksnaps_app/config/database.php');

		$this->load->database();

		if ($this->db->table_exists('auth'))
		{
		   return TRUE;
		}
		else
		{
			return FALSE;
		}


	}


	/**
	*
	*  Create database structure
	*
	*  @param array
	*  @return void
	*
	*/
	function create_db_config($db)
	{

		$db_config = file_get_contents('./quicksnaps_app/config/database.php.txt');

		$db_config = str_replace("HOSTNAME", $db['hostname'], $db_config);
		$db_config = str_replace("USERNAME", $db['username'], $db_config);
		$db_config = str_replace("PASSWORD", $db['password'], $db_config);
		$db_config = str_replace("DATABASE", $db['database'], $db_config);
		$db_config = str_replace("DBDRIVER", $db['dbdriver'], $db_config);
		$db_config = str_replace("DBPREFIX", $db['dbprefix'], $db_config);


		$config_file = './quicksnaps_app/config/database.php';
		$fh = fopen($config_file, 'w') or die("can't open db config file");
		fwrite($fh, $db_config);
		fclose($fh);

	}



	/**
	*
	*  Create database structure
	*
	*  @return void
	*
	*/
    function create_db()
    {


		$auth = array(
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
									'user' 			=> array('type' => 'VARCHAR', 'constraint' => 12),
									'pass'		    => array('type' => 'VARCHAR', 'constraint' => 64)
									);
		$this->dbforge->add_field($auth);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('auth', TRUE);


		$settings = array(
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
									'name' 			=> array('type' => 'VARCHAR', 'constraint' => 128),
									'summary'		=> array('type' => 'TEXT'),
									'default_theme'	=> array('type' => 'VARCHAR', 'constraint' => 64),
									'per_page'	    => array('type' => 'INT', 'constraint' => 5),
									'w'     	    => array('type' => 'INT', 'constraint' => 4),
									'h'     	    => array('type' => 'INT', 'constraint' => 4),
									'mid_w'    	    => array('type' => 'INT', 'constraint' => 4),
									'mid_h'   	    => array('type' => 'INT', 'constraint' => 4),
									'thumb_w'  	    => array('type' => 'INT', 'constraint' => 4),
									'thumb_h'  	    => array('type' => 'INT', 'constraint' => 4),
									'lib'	    	=> array('type' => 'VARCHAR', 'constraint' => 12),
									'lib_path'		=> array('type' => 'VARCHAR', 'constraint' => 32),
									'uploadify_key' => array('type' => 'VARCHAR', 'constraint' => 32)
									);
		$this->dbforge->add_field($settings);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('settings', TRUE);


		$albums = array(
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
									'name' 			=> array('type' => 'VARCHAR', 'constraint' => 128),
									'url'	    	=> array('type' => 'VARCHAR', 'constraint' => 128),
									'full_txt'   	=> array('type' => 'TEXT'),
									'theme'        	=> array('type' => 'VARCHAR', 'constraint' => 64),
									'private'	    => array('type' => 'INT', 'constraint' => 1),
									'rank'  	    => array('type' => 'INT', 'constraint' => 11)
									);
		$this->dbforge->add_field($albums);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('albums', TRUE);


		$photos = array(
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),
									'album'	        => array('type' => 'INT', 'constraint' => 11),
									'name' 			=> array('type' => 'VARCHAR', 'constraint' => 128),
									'photo'	    	=> array('type' => 'VARCHAR', 'constraint' => 128),
									'photo_type'   	=> array('type' => 'VARCHAR', 'constraint' => 5),
									'highlight'	    => array('type' => 'INT', 'constraint' => 1),
									'theme'        	=> array('type' => 'VARCHAR', 'constraint' => 64),
									'rank'  	    => array('type' => 'INT', 'constraint' => 11)
									);
		$this->dbforge->add_field($photos);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('photos', TRUE);


		// Insert some default settings
        // First let's find the best image lib;
            $this->load->helper('image');
            $libs = installed_image_libs();

            if(array_key_exists('ImageMagick', $libs) && $libs['ImageMagick'] !== FALSE)
            {
                $lib = 'ImageMagick';
                $lib_path = '/usr/bin/convert';
            }
            elseif(array_key_exists('gd2', $libs) && $libs['gd2'] === TRUE)
            {
                $lib = 'gd2';
                $lib_path = '';
            }
            elseif(array_key_exists('gd', $libs) && $libs['gd'] === TRUE)
            {
                $lib = 'gd';
                $lib_path = '';
            }
            else
            {
                $lib = FALSE;
                $lib_path = FALSE;
            }

		$this->db->set('id', 1);
		$this->db->set('name', 'QuickSnaps Gallery');
		$this->db->set('default_theme', 'polaroid');
		$this->db->set('per_page', 10);
		$this->db->set('mid_w', 700);
		$this->db->set('mid_h', 400);
		$this->db->set('thumb_w', 120);
		$this->db->set('thumb_h', 120);
		$this->db->set('lib', $lib);
		$this->db->set('lib_path', $lib_path);
		$this->db->insert('settings');


    }


	/**
	*
	*  Create admin account
	*
	*  @param string
	*  @param string md5
	*
	*  @return bool
	*
	*/
	function create_admin($user, $pass)
	{
		$data['user'] = $user;
		$data['pass'] = $pass;

		$this->db->insert('auth', $data);

		return TRUE;

	}


}


/* End of file installer_model.php */
/* Location: ./quicksnaps_app/models/installer_model.php */

