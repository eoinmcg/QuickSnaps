<?php $this->load->view('gallery/header'); ?>

	<?php 
			if(is_array($main))
			{
				foreach($main as $view)
				{
					$this->load->view($view);
				}
			}
			elseif(!empty($main))
			{
				$this->load->view($main);
			}
	?>

<?php $this->load->view('gallery/footer'); ?>
