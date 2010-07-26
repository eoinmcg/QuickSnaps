<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* Gallery Model
* These methods are to be accessed by both front and back end controllers,
* hence the read only nature
*
* @package		QuickSnaps
* @author		Eoin McGrath
* @link			http://www.starfishwebconsulting.co.uk/quicksnaps
*/


class Gallery_model extends Model {

	/**
	* PHP4 Style contructor
	* [if(date('Y', time()) > 2006)) echo 'Flux Capacitor broken again??']
	*
	* @access public
	* @return void
	*/
    function Gallery_model()
    {
        parent::Model();
    }


	/**
	* Load default theme for safe keeping
	*
	* @access public
	* @return string
	*/
	function get_default_theme()
	{

        $this->db->select('default_theme');
        $this->db->where('id', 1);
		$query = $this->db->get('settings');

		$row = $query->row();

		return $row->default_theme;
	}


	/**
	* Check if theme has some javascript associated jiggery pokery
	*
	* @access public
	* @param string
	* @return boolean
	*/
	function get_theme_js($theme)
	{

		if(file_exists('./themes/'.$theme.'/effects.js'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}


	/**
	* Check if theme has toolbar bling
	*
	* @access public
	* @param string
	* @return boolean
	*/
	function get_theme_favicon($theme)
	{

		if(file_exists('./themes/'.$theme.'/favicon.ico'))
		{
			$check = TRUE;
		}
		else
		{
			$check = FALSE;
		}

        return $check;

	}


	/**
	* Exactly what it says on the tin
	*
	* @access public
	* @return int
	*/
	function count_albums()
	{

        $this->db->select('id');
        $this->db->where('private', 0);
		$query = $this->db->get('albums');

		return $query->num_rows();

	}


	/**
	* Grabs DB resource of albums within range (for pagination)
	*
	* @access public
	* @param int
	* @param int
	* @return resource
	*/
    function get_albums($from, $to)
    {

        $this->db->where('private !=', 1);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('albums', $to, $from);

		if(!$query->num_rows())
		{
			return FALSE;
		}
		else
		{
			return $query;
		}

    }

	/**
	* Counts all photos per album
	*
	* @access public
	* @return array
	*/
	function get_albums_photo_count()
	{

        $this->db->select('id');
        $this->db->where('private !=', 1);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('albums');

		$albums = array();

		foreach ($query->result() as $row)
		{
			$albums[$row->id] = $this->count_photos($row->id);
		}

		return $albums;

	}


	/**
	* Get cover photo for album if set.
	* Otherwise grab the first photo, if there is one
	* and, if not, default to placeholder
	*
	* @access public
	* @param int
	* @param string
	* @return array
	*/
	function album_cover($album, $size='thumb')
	{

        $this->db->select('photo, photo_type');
        $this->db->where('highlight =', 1);
        $this->db->where('album =', $album);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('photos');

		if(!$query->num_rows())
		{
			if($this->count_photos($album))
			{
				$p = $this->album_first_photo($album);
			}
			else
			{
				return base_url().'/assets/i/no_photo.png';
			}
		}
		else
		{
			$p = $query->row();
		}

		return base_url().'/'.$p->photo.'_'.$size.$p->photo_type;


	}


	/**
	* Get cover photo for album if set.
	* Otherwise grab the first photo, if there is one
	* and lastly default to placeholder
	*
	* @access public
	* @param int
	* @return mixed
	*/
	function album_first_photo($album)
	{

        $this->db->select('photo, photo_type');
        $this->db->where('album =', $album);
        $this->db->order_by('rank', 'asc');
        $this->db->limit(1);
		$query = $this->db->get('photos');

		if(!$query->num_rows())
		{
			return base_url().'/assets/i/no_photo.png';
		}

		$p = $query->row();

		return $p;

	}


	/**
	* Count photos in album.
	*
	* @access public
	* @param int
	* @return int
	*/
	function count_photos($album)
	{

        $this->db->select('id');
        $this->db->where('album =', $album);
		$query = $this->db->get('photos');

		return $query->num_rows();

	}


	/**
	* Get album title plus id, text, theme and private
	*
	* @access public
	* @param int
	* @return array
	*/
    function get_album_title($album)
    {

        $this->db->select('id, name, url, full_txt, theme, private');
        $this->db->where('url =', $album);
		$query = $this->db->get('albums');

		if(!$query->num_rows())
			return FALSE;

		$row = $query->row_array();

        return $row;

    }


	/**
	* Get album title plus id, text, theme and private
	*
	* @access public
	* @param int
	* @return array
	*/
	function get_photos($album)
	{

        $this->db->where('album =', $album);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('photos');

		return $query;

	}



	/**
	* Get id of album from URL slug
	*
	* @access public
	* @param string
	* @return int
	*/
	function get_album_id($album)
	{

        $this->db->select('id, name, url');
        $this->db->where('url =', $album);
		$query = $this->db->get('albums');

		if(!$query->num_rows())
		{
			return FALSE;
		}

		$name = $query->row();

		return $name->id;

	}


	/**
	* Get photo and all it's bits from the db
	*
	* @access public
	* @param int
	* @return object
	*/
	function get_photo($id)
	{

        $this->db->where('id = ', $id);
        $query = $this->db->get('photos');

		$row = $query->row();

		return $row;

	}



	/**
	* Get next photo and all it's bits from the db
	*
	* @access public
	* @param int
	* @return object
	*/
	function get_photo_next($id)
	{

        $this->db->where('id = ', $id);
        $query = $this->db->get('photos');

		$row = $query->row();

		return $row;

	}



	/**
	* Get prev photo and all it's bits from the db
	*
	* @access public
	* @param int
	* @return object
	*/
	function get_photo_prev($id)
	{

        $this->db->where('id = ', $id);
        $query = $this->db->get('photos');

		$row = $query->row();

		return $row;

	}



}


/* End of file gallery_model.php */
/* Location: ./quicksnaps_app/models/gallery_model.php */

