<?php

class Installer_Model extends Model
{

	function Installer_Model()
	{
		parent::Model();


	}


	function is_installed()
	{

		$this->db->limit(1);
		$query = $this->db->get('auth');		

		if(!$query->num_rows())
			return FALSE;
		else
			return TRUE;

	}




	function create_admin($user, $pass)
	{
		$data['user'] = $user;
		$data['pass'] = $pass;

		$this->db->insert('auth', $data); 

		return TRUE;

	}


    function create_db()
    {


		$auth = array(
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),									'user' 			=> array('type' => 'VARCHAR', 'constraint' => 12),
									'pass'		    => array('type' => 'VARCHAR', 'constraint' => 64)
									);		$this->dbforge->add_field($auth);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('auth', TRUE);


		$settings = array(
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),									'name' 			=> array('type' => 'VARCHAR', 'constraint' => 128),
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
									'id' 			=> array('type' => 'INT', 'constraint' => 11, 'auto_increment' => TRUE),									'name' 			=> array('type' => 'VARCHAR', 'constraint' => 128),
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
									'album'	        => array('type' => 'INT', 'constraint' => 11),									'name' 			=> array('type' => 'VARCHAR', 'constraint' => 128),
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
#print_r($libs);
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
		$this->db->set('default_theme', 'default');
		$this->db->set('per_page', 10);
		$this->db->set('mid_w', 700);
		$this->db->set('mid_h', 400);
		$this->db->set('thumb_w', 120);
		$this->db->set('thumb_h', 120);
		$this->db->set('lib', $lib);
		$this->db->set('lib_path', $lib_path);
		$this->db->insert('settings');



    }


}


/* End of file installer_model.php */ 
/* Location: ./quicksnaps_app/models/installer_model.php */ 
