<?php
class Course extends Model
{
	private $code;
	private $name;
	private $group;
	
    function Course()
    {
        parent::Model();
    }

    function code() {if (is_null($this->code)) $this->set(); return $this->code; }
    function name() {if (is_null($this->name)) $this->set(); return $this->name; }
    function group() {if (is_null($this->address)) $this->set(); return $this->group; }
    
    static function getCourse($courseId)
    {
		$course = new Course();
        $result = $course->db->from('courses')->where('id', $courseId);
        if ($result->num_rows() <> 1){
            throw new Exception('Invalid Course');
        }
        $this->set($result->row_object());
        $result->free_result();
        return $course;
    }
    
    private function set($data = null)
    {
        if (is_null($data))
        {
            $data = $this->db->where('code', $this->code)->get('courses')->result_object();
        }

        $this->code = $data->code;
        $this->name = $data->name;
        $this->group = $data->group;
    }
    
    function getAllCourses()
    {
        $query = $this->db->select('code, name')->order_by('name')->get('courses');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['code']]=$row['name'];
        return array('' => 'All') + $result;
    }
    
    function getAllCourseGroups()
    {
        $query = $this->db->distinct()->select('group')->order_by('group')->get('courses');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['group']]=$row['group'];
        return array('' => 'All') + $result;
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
?>