<?php
class Gallery extends QS_Controller {

        /**
         *
         */
	function Gallery()
	{
		parent::QS_Controller();


                $this->load->model('Gallery_model');
		$this->load->helper(array('smiley', 'text', 'form'));

	}

        /**
         *
         * @param <type> $page
         */
	function index($page=1)
	{
                //TODO: debug!

		if ( ! $this->db->table_exists('settings') )
		{
			redirect('/installer', 'refresh');
			exit;
		}


		$data['title'] 		= GALLERY_NAME.' | Welcome';
		$data['heading'] 	= $data['title'];

		$this->load->library('pagination');

		$config = $this->_pagination_links();
		$this->pagination->initialize($config);
		$paginate = $this->pagination->create_links();

		$data['query'] 	= $this->Gallery_model->get_albums($config['from'], $config['to']);

		if(!$data['query'])
		{
            $data['main']       = 'gallery/no_albums';
		}
        else
        {
            $data['main']       = 'gallery/home';
        }

        $data['paginate'] = $paginate;

		$data['private']    = FALSE;
		$data['photos']     = $this->Gallery_model->get_albums_photo_count();
		$data['theme'] 	    = $this->Gallery_model->get_default_theme();
		$data['js']		    = $this->Gallery_model->get_theme_js($data['theme']);
		$data['favicon']	= $this->Gallery_model->get_theme_favicon($data['theme']);

		$this->load->view('gallery/gallery', $data);

	}


	function album($album_url=FALSE)
	{

		if(!$album_url)
		{
			show_404();
		}

		$album = $this->Gallery_model->get_album_title($album_url);

		if(!$album)
		{
			show_404();
		}

		$data['title']				= 'Album: '.$album['name'];
		$data['heading']			= $album['name'];
		$data['album']				= $album['name'];
		$data['theme']				= $album['theme'];
		$data['private']			= $album['private'];
		$data['js']					= $this->Gallery_model->get_theme_js($data['theme']);
		$data['favicon']	        = $this->Gallery_model->get_theme_favicon($data['theme']);
		$data['num_photos']			= $this->Gallery_model->count_photos($album['id']);
		$data['full_txt']			= parse_smileys(nl2br($album['full_txt']), $this->config->item('base_url')."/assets/i/smileys");
		$data['query'] 				= $this->Gallery_model->get_photos($album['id']);
		$data['main']               = 'gallery/album';

		$data['referer'] = (isset($_SERVER['HTTP_REFERER']))
			? $_SERVER['HTTP_REFERER']
			: FALSE;


		$this->load->view('gallery/gallery', $data);


	}


	function admin()
	{

		redirect(base_url().'admin/login/', 'refresh');
		exit;
	}


	function _pagination_links()
	{

		$page = $this->uri->segment(3, 1);

        $config['base_url'] = site_url().'/gallery/index/';
        $config['total_rows'] = $this->Gallery_model->count_albums();
        $config['per_page'] = PER_PAGE;

        $config['base_url'] = site_url().'/gallery/index/';
		$config['per_page'] = PER_PAGE;
		$config['num_links'] = 5;
		$config['cur_tag_open'] = '<b>';
		$config['cur_tag_close'] = '</b>';
		$config['uri_segment'] = 3;

		$offset = ($page == '1') ? 0 : 1;
		$config['cur_page'] = ceil ( $page / PER_PAGE ) + $offset;

		$total_pages = ceil ( $config['total_rows'] / $config['per_page'] );
		$config['from'] = ($page == '1') ? 0 : $page  ;
		$config['to'] = ($page == '1')
                    ? ($config['from'] + PER_PAGE)
                    : $config['from'] + PER_PAGE;

		$config['full_tag_open'] = '<div class="pagination"> '."<strong>Viewing page ".$config['cur_page'];
		$config['full_tag_open'] .= " of $total_pages </strong><br />";
		$config['full_tag_close'] = '</div>';

		return $config;

	}



}


/* End of file gallery.php */
/* Location: ./quicksnaps_app/controllers/gallery.php */

