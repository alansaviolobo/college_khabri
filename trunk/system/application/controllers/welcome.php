<?php

class Welcome extends Controller {

    function Welcome()
    {
        parent::Controller();
        $this->load->model('University');
        $this->load->model('Institute');
        $this->load->model('Course');
    }

    function index()
    {
		$this->smarty->assign('bigheader', true);
        $this->smarty->assign('searchForm', $this->_search_form());
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

    	$this->smarty->assign('results', Course::searchCourseCodes($params));
    	$this->smarty->assign('searchForm', $this->_search_form());
        $this->smarty->assign('template', 'searchresults.html');
        $this->smarty->display('template.html');
    }
    
    function _search_form()
    {
        $approx_fees = array(
            '' => 'Any amount',
            '20000,50000' => '20,000 - 50,000',
            '50000,70000' => '50,000 - 70,000',
            '70000,100000' => '70,000 - 1,00,000');

        $hostel = array(
            '' => 'Not Needed',
            'boys' => 'Boys',
            'girls' => 'Girls');

        $establishment_year = array(
            "Any",
            "1800 - 1850",
            "1851 - 1900",
            "1901 - 2000");

		$coursesJS = 	"this.parentNode.style.display='none';".
						"getElementById('course_selection_div').style.display='block';".
						"document.searchform.mode.value='c';".
						"return false";
		$coursegroupsJS="this.parentNode.style.display='none';".
						"getElementById('coursegroup_selection_div').style.display='block';".
						"document.searchform.mode.value='cg';".
						"return false";
		$searchJS = 	"this.parentNode.parentNode.style.display='none';".
						"getElementById('less-details-search').style.display='block';".
						"document.searchform.mode.value='s';".
						"return false";
        $form = array(
            'formOpen'          => form_open('welcome/search_results', array('method'=>'get', 'name'=>'searchform'), array('mode'=>'c')),
            'stateLabel'        => form_label('State', 'state'),
            'stateSelect'       => form_dropdown('state', array('mh'=>'Maharashtra'), 'mh'),
            'careerLabel'       => form_label('A Career in', 'career'),
            'careerSelect'      => form_dropdown('career', array('en'=>'Engineering'), 'en'),
            'universityLabel'   => form_label('University', 'universities[]'),
            'universitySelect'  => form_dropdown('universities[]', University::getUniversities(), null, "id='universities'"),
            'districtLabel'     => form_label('District', 'districts'),
            'districtSelect'    => form_dropdown('districts[]', Institute::getDistricts(), null, "id='districts'"),
            'coursesLabel'      => form_label('Course', 'courses[]'),
            'coursesSelect'     => form_dropdown('courses[]', Course::getAllCourses(), null, "id='courses' onchange=\"document.searchform.mode.value='c'\""),
            'coursegroupLabel'  => form_label('Course Group', 'coursegroupss[]'),
            'coursegroupSelect' => form_dropdown('coursegroups[]', Course::getAllCourseGroups(), null, "id='coursegroups' onchange=\"document.searchform.mode.value='cg'\""),
            'searchLabel'		=> form_label('College Name or Course', 'search'),
            'searchBox'		    => form_input('search', null, "class='big-field' onchange=\"document.searchform.mode.value='s'\""),
            'aidLabel'          => form_label('Aid Status', 'aid'),
            'aidSelect'         => form_dropdown('aid', Institute::getAllAidStatus()),
            'minorityLabel'     => form_label('Minority Status', 'minority'),
            'minoritySelect'    => form_dropdown('minority', Institute::getAllMinorities()),
            'autonomyLabel'     => form_label('Autonomy', 'autonomy'),
            'autonomySelect'    => form_dropdown('autonomy', Institute::getAllAutonomies()),
            'feesLabel'         => form_label('Approx. Fees (Rs. per year)', 'fees'),
            'feesSelect'        => form_dropdown('fees', $approx_fees),
            'hostelLabel'       => form_label('Hostel', 'hostel'),
            'hostelSelect'      => form_dropdown('hostel', $hostel),
            'establishmentLabel'=> form_label('Established', 'establishment'),
            'establishmentSelect'=> form_dropdown('established', $establishment_year),
            'ladiesCheckLabel'  => form_label ('Search only ladies colleges', 'ladies'),
            'ladiesCheckBox'    => form_checkbox ('ladies','ladies',false),
        	'coursesLink'		=> anchor('','Search by specific course?', array('class'=>'small-link', 'onClick'=>$coursesJS)),
        	'courseGroupLink'	=> anchor('','Search by a course group?', array('class'=>'small-link', 'onClick'=>$coursegroupsJS)),
        	'searchLink'		=> anchor('','Search by typing the name of the college?', array('class'=>'small-link', 'onclick'=>$searchJS)),
            'submit'            => form_submit('submit', 'Search', "class='search-button'"),
            'formClose'         => form_close()
        );
    	return $form;
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */