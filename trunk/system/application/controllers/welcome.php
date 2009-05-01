<?php

class Welcome extends Controller {

    function Welcome()
    {
        parent::Controller();
        $this->load->library('Smarty');
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
		$coursegroups = array(
            '' => 'All course groups',
		  '70' => 'Chemical',
          '10' => 'Civil',
          '60' => 'Computers',
          '40' => 'Electrical',
          '50' => 'Electronics',
          '85' => 'General',
          '80' => 'Inter Disciplinary',
          '20' => 'Mechanical',
          '30' => 'Other Management ',
          '04' => 'Textile');

        $districts = array(
          "All Districts" => 'All Districts',
          "Ahmednagar" => "Ahmednagar",
          "Akola" => "Akola",
          "Amravati" => "Amravati",
          "Aurangabad" => "Aurangabad",
          "Beed" => "Beed",
          "Bhandara" => "Bhandara",
          "Bhulhana" => "Bhulhana",
          "Buldhana" => "Buldhana",
          "Chandrapur" => "Chandrapur",
          "Dadra Nagar Haveli" => "Dadra Nagar Haveli",
          "Dhule" => "Dhule",
          "Gondia" => "Gondia",
          "Jalgaon" => "Jalgaon",
          "Jalgoan" => "Jalgoan",
          "Kolhapur" => "Kolhapur",
          "Kolhpur" => "Kolhpur",
          "Latur" => "Latur",
          "Mumbai" => "Mumbai",
          "Nagpur" => "Nagpur",
          "Nanded" => "Nanded",
          "Nandurbar" => "Nandurbar",
          "Nashik" => "Nashik",
          "New Delhi" => "New Delhi",
          "Osmanabad" => "Osmanabad",
          "Parbhani" => "Parbhani",
          "Pune" => "Pune",
          "Raigad" => "Raigad",
          "Raigadh" => "Raigadh",
          "Ratnagiri" => "Ratnagiri",
          "Sangli" => "Sangli",
          "Satara" => "Satara",
          "Solapur" => "Solapur",
          "Thane" => "Thane",
          "Wardha" => "Wardha",
          "Yavatmal" => "Yavatmal");

        $aid = array(
          "No Choice",	
          "Government",
          "Govenment Aided",
          "Government-Government-Aided",
          "Un-Aided",
          "University Managed",
          "University Department",
          "University Managed (UA)");

        $autonomy = array(
          "Any",
          "Autonomous",
          "Non-Autonomous",
          "Deemed University");

        $minority = array(
          "No Choice",
          "Non-minority",
          "Linguistic - Gujarathi",
          "Linguistic - Gujarathi (Kutchhi)",
          "Linguistic - Hindi",
          "Linguistic - Malyalam",
          "Linguistic - Sindhi",
          "Linguistic - Punjabi",
          "Linguistic - South Indian Lang",
          "Religious - Jain",
          "Religious - Muslim",
          "Religious - Roman Catholics",
          "Religious - Christian",
          "Religious - Sikh");

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
            'universitySelect'  => form_dropdown('university', University::getAllUniversities(), null, "id='universities'"),
            'districtLabel'     => form_label('District', 'districts'),
            'districtSelect'    => form_dropdown('districts[]', $districts, null, "id='districts'"),
            'coursesLabel'      => form_label('Course', 'course'),
            'coursesSelect'     => form_dropdown('course', Course::getAllCourses(), null, "id='courses'"),
            'coursegroupLabel'  => form_label('Course Group', 'coursegroup'),
            'coursegroupSelect' => form_dropdown('coursegroup', $coursegroups, null, "id='coursegroups'"),
            'collegenameLabel'  => form_label('College Name', 'collegename'),
            'collegenameBox'    => form_input('collegename', null, "class='big-field'"),
            'aidLabel'          => form_label('Aid Status', 'aid'),
            'aidSelect'         => form_dropdown('aid', $aid),
            'minorityLabel'     => form_label('Minority Status', 'minority'),
            'minoritySelect'    => form_dropdown('minority', $minority),
            'autonomyLabel'     => form_label('Autonomy', 'autonomy'),
            'autonomySelect'    => form_dropdown('autonomy', $autonomy),
            'feesLabel'         => form_label('Approx. Fees (Rs. per year)', 'fees'),
            'feesSelect'        => form_dropdown('fees', $approx_fees),
            'hostelLabel'       => form_label('Hostel', 'hostel'),
            'hostelSelect'      => form_dropdown('hostel', $hostel),
            'establishmentLabel'=> form_label('Established', 'establishment'),
            'establishmentSelect'=> form_dropdown('established', $establishment_year),
            'ladiesCheckLabel'  => form_label ('Search only ladies colleges', 'ladies'),
            'ladiesCheckBox'    => form_checkbox ('ladies','ladies',false),
            'submit'            => form_submit('submit', 'Search',null, "class='search-button'"),
            'formClose'         => form_close()
        );
    	return $form;
    }
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */