<?php

class Search extends Model {

    function Search()
    {
        parent::Model();
        $this->load->model('University');
        $this->load->model('Institute');
        $this->load->model('Course');
    }
    
    function search_form()
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
    
    function searchCourseCodes($params)
    {
    	extract($params);
    	$courses = array_filter($courses);
    	$districts = array_filter($districts);
    	$coursegroups = array_filter($coursegroups);
    	$universities = array_filter($universities);

    	if ($mode == 's')
    	{
    		$this->db->where('name', "%$search%")->limit(10)->get('institutes');
    	}
    	else
    	{
	    	if (count($universities)) $this->db->where_in('universities.id', $universities);
	    	if (count($districts)) $this->db->where_in('district', $districts);
	    	if (!empty($aid)) $this->db->where('aid_status', $aid);
	    	if (!empty($fees)) $this->db->where('total_fee between ' . str_replace(',', ' and ', $fees));
	    	if (!empty($autonomy)) $this->db->where('autonomy_status', $autonomy);
	    	if (!empty($minority)) $this->db->where('minority_status', $minority);
    		if($mode == 'c')
    		{
		    	if (count($courses)) $this->db->where_in('courses.code', $courses);
    		}
    		else //mode = cg
    		{
	    		if (count($coursegroups)) $this->db->where_in('group', $coursegroups);
    		}
    	}
    	$this->db->select('institutes.name AS iname,courses.name AS cname, choice_codes.code, institutes.district, total_fee');
    	$this->db->from('universities');
		$this->db->join('institutes', 'institutes.university_id = universities.id');
		$this->db->join('choice_codes', 'choice_codes.institute_code = institutes.code');
		$this->db->join('courses', 'courses.code = choice_codes.course_code');
		$this->db->join('fee_structure', 'fee_structure.institute_code = institutes.code');
		$this->db->limit(10);
    	return $this->db->get()->result_object();
    	
    	//'hostel' = $this->input->get('hostel'),
    	//'ladies' = $this->input->get('ladies'),
    	//'establishedin' = $this->input->get('establishedin'));
    	
    }
}

/* End of file search.php */
/* Location: ./system/application/models/search.php */