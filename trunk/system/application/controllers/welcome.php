<?php

class Welcome extends Controller {

    function Welcome()
    {
        parent::Controller();
        $this->load->model('Search');
    }

    function index()
    {
        $this->smarty->assign('searchForm', Search::search_form());
        $this->smarty->assign('template', 'index.html');
        $this->smarty->display('template.html');
    }

    function search_results()
    {	
    	$params = array(
	    	'aid' => $this->input->get('aid'),
	    	'fees' => $this->input->get('fees'),
	    	'mode' => $this->input->get('mode'),
	    	'hostel' => $this->input->get('hostel'),
	    	'ladies' => $this->input->get('ladies'),
	    	'search' => $this->input->get('search'),
	    	'courses' => $this->input->get('courses'),
	    	'autonomy' => $this->input->get('autonomy'),
	    	'minority' => $this->input->get('minority'),
	    	'districts' => $this->input->get('districts'),
	    	'coursegroups' => $this->input->get('coursegroups'),
	    	'universities' => $this->input->get('universities'),
	    	'establishedin' => $this->input->get('establishedin'));

    	$this->smarty->assign('results', Search::searchCourseCodes($params));
    	$this->smarty->assign('searchForm', Search::search_form());
        $this->smarty->assign('template', 'searchresults.html');
        $this->smarty->display('template3column.html');
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */