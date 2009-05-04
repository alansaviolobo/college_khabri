<?php

class Info extends Controller {

    function Info()
    {
        parent::Controller();
        $this->load->library('Smarty');
    }

    function institute_info($instituteName, $showTemplate = 'true')
    {
        $this->smarty->assign('institute', Institute::getInstituteByName($instituteName));
        $this->smarty->assign('template', 'instituteinfo.html');
        $this->smarty->display(($showTemplate != 'false')?'template.html':'templatecompact.html');
    }

    function contact_us()
    {
        $this->smarty->assign('template', 'contactus.html');
        $this->smarty->display('template.html');
    }

    function terms_of_use()
    {
        $this->smarty->assign('template', 'termsofuse.html');
        $this->smarty->display('template.html');
    }

    function privacy_policy()
    {
        $this->smarty->assign('template', 'privacypolicy.html');
        $this->smarty->display('template.html');
    }

 	function what_is_engineering()
    {
        $this->smarty->assign('template', 'whatisengineering.html');
        $this->smarty->display('template.html');
    }    
    
    function benefits_of_becoming_an_engineer()
    {
        $this->smarty->assign('template', 'benefits_of_becoming_an_engineer.html');
        $this->smarty->display('template.html');
    }   
}

/* End of file static.php */
/* Location: ./system/application/controllers/static.php */