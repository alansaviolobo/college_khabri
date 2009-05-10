<?php

class Info extends Controller {

    function Info()
    {
        parent::Controller();
        $this->load->model('search');
        $this->smarty->assign('searchForm', Search::search_form());
    }

    function choicecode_info($choicecode, $showTemplate = 'true')
    {
    	$this->load->model('choicecode');
        $this->smarty->assign('choicecode', Choicecode::getChoicecode($choicecode));
        $this->smarty->assign('template', 'choicecode_info.html');
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
        $this->smarty->display('template3column.html');
    }    
    
    function benefits_of_becoming_an_engineer()
    {
    	$this->smarty->assign('template', 'benefits_of_becoming_an_engineer.html');
        $this->smarty->display('template3column.html');
    }   
    
    function engineering_achievements()
    {
        $this->smarty->assign('template', 'engineering_achievements.html');
        $this->smarty->display('template3column.html');
    }  
    
     function work_engineers_do()
    {
        $this->smarty->assign('template', 'work-engineers-do.html');
        $this->smarty->display('template3column.html');
    } 
    
      function aerospace()
    {
        $this->smarty->assign('template', 'branches/aerospace.html');
        $this->smarty->display('template3column.html');
    }  
    
    function agriculture()
    {
        $this->smarty->assign('template', 'branches/agriculture.html');
        $this->smarty->display('template3column.html');
    }    
      
	function biomedical()
    {
        $this->smarty->assign('template', 'branches/biomed.html');
        $this->smarty->display('template3column.html');
    } 
    
    function civil()
    {
        $this->smarty->assign('template', 'branches/civil.html');
        $this->smarty->display('template3column.html');
    } 
    
    function computer()
    {
        $this->smarty->assign('template', 'branches/computer.html');
        $this->smarty->display('template3column.html');
    }    
    
     function computerscience()
    {
        $this->smarty->assign('template', 'branches/computerscience.html');
        $this->smarty->display('template3column.html');
    }   
}

/* End of file info.php */

/* Location: ./system/application/controllers/info.php */