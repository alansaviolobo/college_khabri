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
        return $result;
    }
    
    function getAllCourseGroups()
    {
        $query = $this->db->distinct('group')->order_by('group')->get('courses');
        $result = array();
        foreach($query->result_array() as $row) $result[$row['group']]=$row['group'];
        return $result;
    }
    
    function searchCourseCode()
    {
    	
    }
}
?>