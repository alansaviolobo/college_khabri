<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();
        $this->load->library('Smarty');
	}
	
	function index()
	{
		$this->smarty->assign('title', "Welcome to Claudia's Kids");
		$this->smarty->assign('template', 'index.html');
        $this->smarty->display('template.html');
	}

    function contactus()
    {

    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */