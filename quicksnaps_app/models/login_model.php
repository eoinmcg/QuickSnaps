<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Login Model
*
* @package		QuickSnaps
* @author		Eoin McGrath
* @link			http://www.starfishwebconsulting.co.uk/quicksnaps
*/

class Login_model extends CI_Model {



	/**
	 * Constructor
	 *
	 */
	function __construct()
	{
		parent::__construct();
	}


	/**
	 * Process login
	 *
	 * @access	public
	 * @param	string
	 * @param	string
	 * @return	bool
	 */
	function do_login($u, $p)
	{

		$p = md5($p);

		$this->db->where('user', $u);
		$this->db->where('pass', $p);
		$this->db->limit(1);
		$query = $this->db->get('auth');


		if($query->num_rows())
		{
			$this->session->set_userdata(array('username' => $u));
			return TRUE;
		}
		else
		{
			return FALSE;
		}


	}

}


/* End of file login_model.php */
/* Location: ./quicksnaps_app/models/login_model.php */

