<?php

class Gallery_model extends Model {


    function Gallery_model()
    {
        parent::Model();
    }
    

	function get_default_theme()
	{

        $this->db->select('default_theme');
        $this->db->where('id', 1);
		$query = $this->db->get('settings');

		$row = $query->row();

		return $row->default_theme;
	}


	function get_theme_js($theme)
	{

		if(file_exists('./themes/'.$theme.'/effects.js'))
			return TRUE;
		else
			return FALSE;
	}


	function get_theme_favicon($theme)
	{

		if(file_exists('./themes/'.$theme.'/favicon.ico'))
			$check = TRUE;
		else
			$check = FALSE;

        return $check;  

	}


	function count_albums()
	{

        $this->db->select('id');
        $this->db->where('private', 0);
		$query = $this->db->get('albums');

		return $query->num_rows();

	}


    function get_albums($from, $to)
    {

        $this->db->where('private !=', 1);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('albums', $to, $from);

		if(!$query->num_rows())
			return FALSE;
		else
        	return $query;

    }


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



	function album_cover($album, $size='thumb')
	{

        $this->db->select('photo, photo_type');
        $this->db->where('highlight =', 1);
        $this->db->where('album =', $album);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('photos');

		if(!$query->num_rows())
			return base_url().'/assets/i/no_photo.png';

		$p = $query->row();


		return base_url().'/'.$p->photo.'_'.$size.$p->photo_type;


	}


	function count_photos($album)
	{

        $this->db->select('id');
        $this->db->where('album =', $album);
		$query = $this->db->get('photos');

		return $query->num_rows();

	}


    function get_album_title($album)
    {

        $this->db->select('id, name, full_txt, theme, private');
        $this->db->where('url =', $album);
		$query = $this->db->get('albums');

		if(!$query->num_rows())
			return FALSE;

		$row = $query->row();

        return array('id' => $row->id, 'name' => $row->name, 'full_txt' => $row->full_txt, 'theme' => $row->theme, 'private' => $row->private);

    }



	function get_photos($album)
	{

        $this->db->where('album =', $album);
        $this->db->order_by('rank', 'asc');
		$query = $this->db->get('photos');

		return $query;

	}

	function get_album_id($album) 
	{

        $this->db->select('id, name, url');
        $this->db->where('url =', $album);
		$query = $this->db->get('albums');

		$name = $query->row();

		return $name->id;

	}


	function get_photo($id)
	{

        $this->db->where('id = ', $id);
        $query = $this->db->get('photos');

		$row = $query->row();

		return $row;

	}


}


/* End of file gallery_model.php */ 
/* Location: ./quicksnaps_app/models/gallery_model.php */ 
