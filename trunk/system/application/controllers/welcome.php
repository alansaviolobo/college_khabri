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
	    	'aid' => $this->input->post('aid'),
	    	'fees' => $this->input->post('fees'),
	    	'mode' => $this->input->post('mode'),
	    	'hostel' => $this->input->post('hostel'),
	    	'ladies' => $this->input->post('ladies'),
	    	'search' => $this->input->post('search'),
	    	'courses' => $this->input->post('courses'),
	    	'autonomy' => $this->input->post('autonomy'),
	    	'minority' => $this->input->post('minority'),
	    	'districts' => $this->input->post('districts'),
	    	'coursegroups' => $this->input->post('coursegroups'),
	    	'universities' => $this->input->post('universities'),
	    	'establishedin' => $this->input->post('establishedin'));

    	$this->smarty->assign('results', Search::searchCourseCodes($params));
    	$this->smarty->assign('searchForm', Search::search_form());
        $this->smarty->assign('template', 'searchresults.html');
        $this->smarty->display('template3column.html');
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */