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
    	$districts = $this->input->get('districts');
    	$universities = $this->input->get('universities');
    	$aid = $this->input->get('aid');

    	$this->smarty->assign('results', Institute::searchInstitutes());
    	$this->smarty->assign('searchForm', $this->_search_form());
        $this->smarty->assign('template', 'searchresults.html');
        $this->smarty->display('template.html');
    }
    
    function _search_form()
    {
        $approx_fees = array(
            "Any amount",
            "50,000 - 1,00,000",
            "1,00,000 - 2,00,000",
            "2,00,000 - 4,00,000");

        $hostel = array(
            "Not Needed",
            "Boys",
            "Girls");

        $establishment_year = array(
            "Any",
            "1800 - 1850",
            "1851 - 1900",
            "1901 - 2000");

        $form = array(
            'formOpen'          => form_open('welcome/search_results', array('method'=>'get')),
            'stateLabel'        => form_label('State', 'state'),
            'stateSelect'       => form_dropdown('state', array('mh'=>'Maharashtra'), 'mh'),
            'careerLabel'       => form_label('A Career in', 'career'),
            'careerSelect'      => form_dropdown('career', array('en'=>'Engineering'), 'en'),
            'universityLabel'   => form_label('University', 'university'),
            'universitySelect'  => form_dropdown('university', University::getUniversities(), null, "id='universities'"),
            'districtLabel'     => form_label('District', 'districts'),
            'districtSelect'    => form_dropdown('districts[]', University::getDistricts(), null, "id='districts'"),
            'coursesLabel'      => form_label('Course', 'course'),
            'coursesSelect'     => form_dropdown('course', Course::getAllCourses(), null, "id='courses'"),
            'coursegroupLabel'  => form_label('Course Group', 'coursegroup'),
            'coursegroupSelect' => form_dropdown('coursegroup', Course::getAllCourseGroups(), null, "id='coursegroups'"),
            'collegenameLabel'  => form_label('College Name', 'collegename'),
            'collegenameBox'    => form_input('collegename', null, "class='big-field'"),
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
            'submit'            => form_submit('submit', 'Search', "class='search-button'"),
            'formClose'         => form_close()
        );
    	return $form;
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */