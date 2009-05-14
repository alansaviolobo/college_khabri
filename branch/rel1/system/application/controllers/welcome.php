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

    function search_results($page = 0, $sortcode = '')
    {
		$this->load->library('pagination');
		
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

   		$params['sortorder'] = $sortorder = $sortfield = '';
    	if ($sortcode <> '')
    	{
    		if (in_array(substr($sortcode, 1), array('iname','cname','district','fees','popularity','cutoff')))
    		{
    			$params['sortorder'] = substr($sortcode, 1);
    			$params['sortorder'] .= $sortcode[0] == 'u' ? '' : ' desc';
    			$sortorder = $sortcode[0]; $sortfield = substr($sortcode, 1);
    		}
    	}

    	try
    	{
    		$user = null;
    		$user_id = $this->session->userdata('userId');
    		if ($user_id)
    		{
    			$this->load->model('user');
    			$user = User::getUserByUserId($user_id);
    		}
	    	$results = Search::searchCourseCodes($params, $user);
    	}
    	catch(Exception $e)
    	{
    		redirect('welcome/index');
    	}

		$config['base_url'] = site_url() . '/welcome/search_results/';
		$config['total_rows'] = count($results);
		$config['per_page'] = 10;
		$config['num_links'] = 5;
		$this->config->set_item('enable_query_strings', false);

		$this->pagination->initialize($config);
    	$this->smarty->assign('results', $results);
    	$this->smarty->assign('pagelinks', $this->pagination->create_links());
    	$this->smarty->assign('pageno', $page);
    	$this->smarty->assign('pagerows', 10);
    	$this->smarty->assign('sortorder', $sortorder);
    	$this->smarty->assign('sortfield', $sortfield);
    	$this->smarty->assign('searchForm', Search::search_form());
        $this->smarty->assign('template', 'searchresults.html');
        $this->smarty->display('template_search_results.html');
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */