<?php

/**
 * MY Controller class
 *
 * Extends the base class and loads Install and Quicksnap Controllers
 *
 * @package		QuickSnaps
 * @author		Eoin McGrath
 * @link		http://www.starfishwebconsulting.co.uk/quicksnaps
 */
class MY_Controller extends Controller
{

    function MY_Controller()
    {
        parent::Controller();
    }

}

require_once('./quicksnaps_app/libraries/Install_Controller.php');
require_once('./quicksnaps_app/libraries/QS_Controller.php');

/* End of file MY_Controllers.php */
/* Location: ./quicksnaps_app/libraries/MY_Controllers.php */

