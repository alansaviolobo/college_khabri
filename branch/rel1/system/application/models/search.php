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

        $established_in = array(
            		 '' => "Any",
        	'2004,2009' => "1 - 5 years",
        	'1999,2003' => "5 - 10 years",
            '1989,1998' => "10 - 20 years",
            '1979,1988' => "20 - 30 years",
            '1850,1978' => "more than 30 years");

		$coursesJS = 	"this.parentNode.style.display='none';".
						"getElementById('course_selection_div').style.display='block';".
						"document.searchform.mode.value='c';".
						"return false";
/*		$coursegroupsJS="this.parentNode.style.display='none';".
						"getElementById('coursegroup_selection_div').style.display='block';".
						"document.searchform.mode.value='cg';".
						"return false";
*/		$searchJS = 	"this.parentNode.parentNode.style.display='none';".
						"getElementById('less-details-search').style.display='block';".
						"document.searchform.mode.value='s';".
						"return false";
        $form = array(
            'formOpen'          => form_open('welcome/search_results', array('name'=>'searchform'), array('mode'=>'c')),
            'stateLabel'        => form_label('State', 'state'),
            'stateSelect'       => form_dropdown('state', array('mh'=>'Maharashtra'), 'mh'),
            'careerLabel'       => form_label('A Career in', 'career'),
            'careerSelect'      => form_dropdown('career', array('en'=>'Engineering'), 'en'),
            'universityLabel'   => form_label('University', 'universities[]'),
            'universitySelect'  => form_dropdown('universities[]', array('' => 'All Universities') + University::getUniversities(), null, "id='universities'"),
            'districtLabel'     => form_label('District', 'districts'),
            'districtSelect'    => form_dropdown('districts[]', Institute::getDistricts(), null, "id='districts'"),
            'coursesLabel'      => form_label('Course', 'courses[]'),
            'coursesSelect'     => form_dropdown('courses[]', Course::getAllCourses(), null, "id='courses' onchange=\"document.searchform.mode.value='c'\""),
//            'coursegroupLabel'  => form_label('Course Group', 'coursegroupss[]'),
//            'coursegroupSelect' => form_dropdown('coursegroups[]', Course::getAllCourseGroups(), null, "id='coursegroups' onchange=\"document.searchform.mode.value='cg'\""),
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
            'establishmentLabel'=> form_label('Age of the Institute', 'establishedin'),
            'establishmentSelect'=> form_dropdown('establishedin', $established_in),
            'ladiesCheckLabel'  => form_label('Search only ladies colleges', 'ladies'),
            'ladiesCheckBox'    => form_checkbox('ladies','ladies',false),
        	'cetCutoffLabel'	=> form_label('MH-CET', 'cutoff'),
            'cetCutoffRadio'	=> form_radio('cutoff','mhtcet',false),
        	'aieeeCutoffLabel'  => form_label('AIEEE', 'cutoff'),
        	'aieeeCutoffRadio'  => form_radio('cutoff','aieee',false),
            'coursesLink'		=> anchor('','Search by specific course?', array('class'=>'small-link', 'onClick'=>$coursesJS)),
//        	'courseGroupLink'	=> anchor('','Search by a course group?', array('class'=>'small-link', 'onClick'=>$coursegroupsJS)),
        	'searchLink'		=> anchor('','Search by typing the name of the college?', array('class'=>'small-link', 'onclick'=>$searchJS)),
            'submit'            => form_submit('submit', 'Search', "class='search-button'"),
            'formClose'         => form_close()
        );
        
		$params = $this->session->userdata('search');
        if($params and count(array_filter($params)) > 1)
        {
			extract($params);
			$courses = array_filter($courses);
	    	$districts = array_filter($districts);
//	    	$coursegroups = array_filter($coursegroups);
	    	$universities = array_filter($universities);
			$js = '';
	    	for($count=1; $count<count($universities); $count++) $js .= "addOption('universities');";
	    	$js .= "var universitiesv = ['" . implode("','", $universities) . "'];
	    			var universitiesdd = document.getElementsByName('universities[]');
	    			for(var count=0; count < universitiesdd.length; universitiesdd[count].value=universitiesv[count++]);\n";
	    	
	    	for($count=1; $count<count($districts); $count++) $js .= "addOption('districts');";
	    	$js .= "var districtsv = ['" . implode("','", $districts) . "'];
	    			var districtsdd = document.getElementsByName('districts[]');
	    			for(var count=0; count < districtsdd.length; districtsdd[count].value=districtsv[count++]);\n";
	    	
	    	for($count=1; $count<count($courses); $count++) $js .= "addOption('courses');";
	    	$js .= "var coursesv = ['" . implode("','", $courses) . "'];
	    			var coursesdd = document.getElementsByName('courses[]');
	    			for(var count=0; count < coursesdd.length; coursesdd[count].value=coursesv[count++]);\n";
	    	
/*	    	for($count=1; $count<count($coursegroups); $count++) $js .= "addOption('coursegroups');";
	    	$js .= "var coursegroupsv = ['" . implode("','", $coursegroups) . "'];
	    			var coursegroupsdd = document.getElementsByName('coursegroups[]');
	    			for(var count=0; count < coursegroupsdd.length; coursegroupsdd[count].value=coursegroupsv[count++]);\n";
*/	    	
	    	$js .= "document.getElementsByName('aid')[0].value = '$aid';\n";
	    	$js .= "document.getElementsByName('fees')[0].value = '$fees';\n";
	    	$js .= "document.getElementsByName('establishedin')[0].value = '$establishedin';\n";
	    	$js .= "document.getElementsByName('autonomy')[0].value = '$autonomy';\n";
	    	$js .= "document.getElementsByName('minority')[0].value = '$minority';\n";
	    	$js .= "document.getElementsByName('hostel')[0].value = '$hostel';\n";
	    	$js .= "document.getElementsByName('ladies')[0].checked = " . ($ladies?'true':'false') . ";\n";

	    	$form['acjs'] = "<script>$js</script>";
        }
    	return $form;
    }
    
    function searchCourseCodes($params, $user)
    {
		if(count(array_filter($params))>1)
		{
			$this->session->set_userdata(array('search'=>$params));
		}
		elseif(is_array($this->session->userdata('search')))
		{
			$sortorder = $params['sortorder'];
			$params = array_merge($params, $this->session->userdata('search'), array('sortorder'=>$sortorder));
		}
		else
		{
			throw new Exception('invalid search params');
		}

    	extract($params);
    	if(is_array($courses)) $courses = array_filter($courses);
    	if(is_array($districts)) $districts = array_filter($districts);
//    	if(is_array($coursegroups)) $coursegroups = array_filter($coursegroups);
    	if(is_array($universities)) $universities = array_filter($universities);

		if (is_null($user))
    	{
    		$this->db->select("institutes.name AS iname,courses.name AS cname, choice_codes.code, 
    						institutes.district, '' AS fees, '' AS popularity, '' AS cutoff", false);
    		//hack for active record
    		$this->db->from('universities');
    		$this->db->join('institutes', 'institutes.university_id = universities.id');
			$this->db->join('choice_codes', 'choice_codes.institute_code = institutes.code');
			$this->db->join('courses', 'courses.code = choice_codes.course_code');
			$this->db->join('fees', 'fees.institute_code = institutes.code');
    	}
    	else
    	{	$user->homeUni()->id();//hack for active record;
    		$gender = $user->gender() == 'female'?array('g', 'l'):array('g'); 
    		$seattype = $user->category() <> 'open'? array('open', $user->category()):array('open');
    		
    		$this->db->select('institutes.name AS iname,courses.name AS cname, choice_codes.code, 
    						institutes.district, total AS fees, popularity, MAX(cutoffrank) AS cutoff');
    		//hack for active record
    		$this->db->from('universities');
    		$this->db->join('institutes', 'institutes.university_id = universities.id');
			$this->db->join('choice_codes', 'choice_codes.institute_code = institutes.code');
			$this->db->join('courses', 'courses.code = choice_codes.course_code');
			$this->db->join('fees', 'fees.institute_code = institutes.code');
			
    		$this->db->join('cutoffs', 'cutoffs.choicecode = choice_codes.code');
    		$this->db->where('cutoffs.category', $user->category());
    		$this->db->where_in('cutoffs.gender', $gender);
    		$this->db->where_in('cutoffs.seattype', $seattype);
    		$this->db->where('cutoffs.round = 1');
    		$this->db->where("cutoffs.homeuni = IF({$user->homeUni()->id()}=universities.id, 'HU','OHU')");
    		$this->db->group_by('choicecode');
    	}
    	
    	if ($mode == 's')
    	{
    		$this->db->like('institutes.name', $search);
    		$this->db->or_like('courses.name', $search);
    		$this->db->or_like('choice_codes.code', $search);
    	}
    	else
    	{
	    	if (count($universities)) $this->db->where_in('universities.id', $universities);
	    	if (count($districts)) $this->db->where_in('district', $districts);
	    	if (!empty($aid)) $this->db->where('aid_status', $aid);
	    	if (!empty($fees)) $this->db->where('total between ' . str_replace(',', ' and ', $fees));
	    	if (!empty($establishedin)) $this->db->where('established_in between ' . str_replace(',', ' and ', $establishedin));
	    	if (!empty($autonomy)) $this->db->where('autonomy_status', $autonomy);
	    	if (!empty($minority)) $this->db->where('minority_status', $minority);
	    	if (!empty($ladies)) $this->db->where('ladies_only', true);
	    	if (!empty($hostel)) $this->db->where("{$hostel}_hostel > ", '0');
//    		if($mode == 'c')
//    		{
		    	if (count($courses)) $this->db->where_in('courses.code', $courses);
//    		}
//    		else //mode = cg
//    		{
//	    		if (count($coursegroups)) $this->db->where_in('group', $coursegroups);
//    		}
    	}
    	
		if (!empty($sortorder)) $this->db->order_by($sortorder);
		return $this->db->get()->result_object();
    }
}
?>