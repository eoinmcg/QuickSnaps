<?php

	function installed_image_libs()
	{

		$libs = array();

		$imagemagick = is_installed_imagemagick();
		$gd = is_installed_gd();

		if($imagemagick)
			$libs['ImageMagick'] = $imagemagick;

        if($gd)
        {
		    if($gd == 2)
            {
			    $libs['gd2'] = TRUE;
            }
		    elseif($gd == 1)
            {
			    $libs['gd'] = TRUE;
            }
        }


		return $libs;

	}


	function is_installed_imagemagick()
	{


		# If no path is set we're going to guess, obviously not ideal
		$path = (LIB == 'ImageMagick' && LIB_PATH != '') ? LIB_PATH : '/usr/bin/convert';

		$convert_path = $path.' --version';
		$return =  shell_exec($convert_path);
		$x = preg_match('/Version: ImageMagick ([0-9]*\.[0-9]*\.[0-9]*)/', $return, $arr_return);


		if(is_array($arr_return) && array_key_exists(1, $arr_return))
        {
			return $arr_return[1];
        }
		else
        {
			return FALSE;
        }

	}


 
	function is_installed_gd()
	{
		$gd = gd_info();

		if(!$gd['GD Version'])
        {
			return FALSE;
        }
		elseif ($gd['GD Version'] == '2.0 or higher')
        {
			return 2;
        }
		else
        {
			return 1;
        }

	}


	function is_installed_netpbm()
	{
#		NO IDEA HOW TO CHECK FOR THIS
		return FALSE;		
	}



 


